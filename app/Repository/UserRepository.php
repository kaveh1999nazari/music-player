<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    public function create(array $data): User
    {
        return User::query()
            ->create([
            'full_name' => $data['full_name'] ?? null,
            'email' => $data['email'],
            'mobile' => $data['mobile'] ?? null,
            'photo' => $data['photo'] ?? null,
            'password' => Hash::make($data['password']) ?? null,
        ]);
    }

    public function createOtp(int $id)
    {
        User::query()
            ->where('id', $id)
            ->update([
                'otp_code' => rand(100000, 999999),
                'otp_expired' => now()->addMinutes(3),
                'updated_at' => now()
            ]);

        return User::query()->find($id);
    }

    public function get(string $email, string $mobile)
    {
        return User::query()
            ->where('email', $email)
            ->orWhere('mobile', $mobile)
            ->first();
    }

    public function getByEmail(string $email): ?User
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }

    public function update(array $data, User $user)
    {
        return User::query()
            ->where('id', $user->id)
            ->update($data);
    }

    public function getById(int $id)
    {
        return User::query()
            ->with('playlists')
            ->where('id', $id)
            ->first();
    }

    public function getByRefreshToken(string $refreshToken)
    {
        return User::query()
            ->where('refresh_token', $refreshToken)
            ->first();
    }

    public function all(int $perPage, $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return User::query()
            ->paginate($perPage, ['*'], 'page', $page);
    }

}
