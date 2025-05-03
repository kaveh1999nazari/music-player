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
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'],
            'mobile' => $data['mobile'] ?? null,
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

    public function all()
    {
        return User::query()
            ->get();
    }

}
