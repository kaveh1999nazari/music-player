<?php

namespace App\Repository;

use App\Models\AlbumFollow;

class AlbumFollowRepository
{
    public function create(array $data)
    {
        return AlbumFollow::query()
            ->create([
                'user_id' => auth()->id(),
                'album_id' => $data['album_id'],
            ]);
    }

    public function delete(int $id)
    {
        return AlbumFollow::query()
            ->where('id', $id)
            ->delete();
    }

    public function get(int $id)
    {
        return AlbumFollow::query()
            ->where('id', $id)
            ->first();
    }

    public function getByUserId(int $userId, int $perPage, int $page)
    {
        return AlbumFollow::query()
            ->where('user_id', $userId)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function checkExist(int $userId, int $albumId)
    {
        return AlbumFollow::query()
            ->where('user_id', $userId)
            ->where('album_id', $albumId)
            ->exists();
    }
}
