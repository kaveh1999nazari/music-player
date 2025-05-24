<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserProvider;

class SocialAuthRepository
{
    public function create(array $data)
    {
        return UserProvider::query()
            ->create([
                'user_id' => $data['user_id'],
                'provider' => $data['provider'],
                'provider_id' => $data['provider_id'],
            ]);
    }

    public function findUserByProvider(string $provider, string $providerId): ?User
    {
        $userProvider = UserProvider::query()
            ->where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        return $userProvider?->user;
    }
}
