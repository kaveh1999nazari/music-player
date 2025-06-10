<?php

namespace App\Service;

use App\Exceptions\UserExistException;
use App\Models\User;
use App\Repository\MediaRepository;
use App\Repository\SocialAuthRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected SocialAuthRepository $socialAuthRepository,
        protected MediaRepository $mediaRepository,
    ) {}

    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $userProvider = $this->socialAuthRepository->findUserByProvider($provider, $socialUser->getId());

        if (!$userProvider) {
            $user = $this->userRepository->getByEmail($socialUser->getEmail());

            if (!$user) {
                $user = $this->userRepository->create([
                    'full_name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Str::random(32),
                ]);
                if ($socialUser->getAvatar()) {
                    $this->mediaRepository->create([
                        'file_path' => $socialUser->getAvatar(),
                        'file_type' => 'photo',
                        'mime_type' => 'image/jpeg',
                        'model_id' => $user->id,
                        'model_type' => User::class,
                    ]);
                }
            }else {
                throw new UserExistException();
            }

            $this->socialAuthRepository->create([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        }else {
            $user = $this->userRepository->getByEmail($socialUser->getEmail());
        }

        $token = Auth::login($user);
        $refreshToken = \Illuminate\Support\Str::random(60);

        $this->userRepository->update([
            'access_token' => $token,
            'refresh_token' => $refreshToken
        ], $user);

        return [
            'user' => $user,
            'access_token' => $token,
            'refresh_token' => $refreshToken,
        ];
    }
}
