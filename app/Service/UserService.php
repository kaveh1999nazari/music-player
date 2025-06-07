<?php

namespace App\Service;

use App\Exceptions\InvalidUserToken;
use App\Exceptions\UserExistException;
use App\Exceptions\UserNotAdminException;
use App\Exceptions\UserNotFound;
use App\Exceptions\UserPasswordIncorrect;
use App\Http\Requests\UserRequestOtpRequest;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;
use Psy\Util\Str;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {}

    public function create(array $data): \App\Models\User
    {
        $user = $this->userRepository->get($data['email'], $data['mobile']);
        if ($user) {
            throw new UserExistException();
        }
        return $this->userRepository->create($data);
    }

    public function all(int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        if (auth()->user()->is_admin === true) {
            return $this->userRepository->all($perPage, $page);
        } else {
            throw new UserNotAdminException();
        }
    }

    public function getById(int $id)
    {
        if(auth()->user()->is_admin === true) {
            return $this->userRepository->getById($id);
        }else {
            throw new UserNotAdminException();
        }
    }

    public function login(array $data): \Illuminate\Http\JsonResponse
    {
        $user = $this->userRepository->getByEmail($data['email']);

        if (!$user) {
            throw new UserNotFound();
        }elseif (!Hash::check($data['password'], $user->password)) {
            throw new UserPasswordIncorrect();
        }else {
            $token = auth()->login($user);
        }

        $refreshToken = \Illuminate\Support\Str::random(60);

        $this->userRepository->update([
            'last_login' => now(),
            'access_token' => $token,
            'refresh_token' => $refreshToken,
        ], $user);

        return $this->respondWithToken($token, $refreshToken);
    }

    public function updatePassword(array $data)
    {
        $user = $this->userRepository->getByEmail($data['email']);

        if (! $user) {
            throw new UserNotFound();
        }

        return $this->userRepository->update([
            'password' => Hash::make($data['password'])
        ], $user);
    }

    public function requestOtp(array $data)
    {
        $user = $this->userRepository->getByEmail($data['email']);

        if (! $user) {
            $user = $this->userRepository->create([
                'email' => $data['email'],
                'password' => \Illuminate\Support\Str::random(8)
            ]);
        }

        return $this->userRepository->createOtp($user->id);
    }

    public function confirmOtp(array $data)
    {
        $user = $this->userRepository->getByEmail($data['email']);

        if (! $user) {
            throw new UserNotFound();
        }

        if (
            $user->otp_code === $data['otp_code']
            && $user->otp_expired > now()
        ) {
            $token = auth('api')->login($user);
            $refreshToken = \Illuminate\Support\Str::random(60);

            $this->userRepository->update([
                'last_login' => now(),
                'access_token' => $token,
                'refresh_token' => $refreshToken,
            ], $user);
        } else {
            throw new UserPasswordIncorrect();
        }

        return $this->respondWithToken($token, $refreshToken);
    }

    public function refreshToken(string $refreshToken): \Illuminate\Http\JsonResponse
    {
        $user = $this->userRepository->getByRefreshToken($refreshToken);

        if (! $user) {
            throw new InvalidUserToken();
        }

        $token = auth()->login($user);
        $newRefreshToken = \Illuminate\Support\Str::random(60);

        $this->userRepository->update([
            'access_token' => $token,
            'refresh_token' => $newRefreshToken,
        ], $user);

        return $this->respondWithToken($token, $newRefreshToken);
    }

    protected function respondWithToken($token, $refreshToken): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
