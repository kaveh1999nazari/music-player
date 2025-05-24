<?php

namespace App\Service;

use App\Exceptions\UserExistException;
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
                    'first_name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'photo' => $socialUser->getAvatar(),
                    'password' => Str::random(32),
                ]);
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

        $this->userRepository->update([
            'access_token' => Auth::login($user),
            'refresh_token' =>  \Illuminate\Support\Str::random(60)
        ], $user);

        return $user;
    }
}
