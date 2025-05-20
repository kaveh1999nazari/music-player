<?php

namespace App\Repository;

use App\Models\UserFollow;

class UserFollowRepository
{
    public function create(array $data)
    {
        return UserFollow::query()
            ->create([
                'user_id' => auth()->id(),
                'following_user_id' => $data['following_user_id'],
            ]);
    }

    public function delete(int $id)
    {
        return UserFollow::query()
            ->where('id', $id)
            ->delete();
    }

    public function get(int $id)
    {
        return UserFollow::query()
            ->where('id', $id)
            ->first();
    }

    public function getByUserId(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return UserFollow::query()
            ->where('user_id', $userId)
            ->get();
    }

    public function checkExist(int $userId, int $followingId)
    {
        return UserFollow::query()
            ->where('user_id', $userId)
            ->where('following_user_id', $followingId)
            ->exists();
    }
}
