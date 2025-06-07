<?php

namespace App\Repository;

use App\Models\PlaylistFollow;

class PlaylistFollowRepository
{
    public function create(array $data)
    {
        return PlaylistFollow::query()
            ->create([
                'user_id' => auth()->id(),
                'playlist_id' => $data['playlist_id'],
            ]);
    }

    public function delete(int $id)
    {
        return PlaylistFollow::query()
            ->where('id', $id)
            ->delete();
    }

    public function get(int $id)
    {
        return PlaylistFollow::query()
            ->where('id', $id)
            ->first();
    }

    public function getByUserId(int $userId, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return PlaylistFollow::query()
            ->where('user_id', $userId)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function checkExist(int $userId, int $playlistId)
    {
        return PlaylistFollow::query()
            ->where('user_id', $userId)
            ->where('playlist_id', $playlistId)
            ->exists();
    }
}
