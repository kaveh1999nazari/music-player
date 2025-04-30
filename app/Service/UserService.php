<?php

namespace App\Service;

use App\Exceptions\UserExistException;
use App\Exceptions\UserNotFound;
use App\Exceptions\UserPasswordIncorrect;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {}

    public function create(array $data): \App\Models\User
    {
        $user = $this->userRepository->getByEmail($data['email']);
        if ($user) {
            throw new UserExistException();
        }
        return $this->userRepository->create($data);
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

        $this->userRepository->update([
            'last_login' => now(),
            'remember_token' => $token,
            ], $user);

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
