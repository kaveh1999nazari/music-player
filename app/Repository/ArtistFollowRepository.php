<?php

namespace App\Repository;

use App\Models\ArtistFollow;

class ArtistFollowRepository
{
    public function create(array $data)
    {
        return ArtistFollow::query()
            ->create([
                'user_id' => auth()->id(),
                'artist_id' => $data['artist_id'],
            ]);
    }

    public function delete(int $id)
    {
        return ArtistFollow::query()
            ->where('id', $id)
            ->delete();
    }

    public function get(int $id)
    {
        return ArtistFollow::query()
            ->where('id', $id)
            ->first();
    }

    public function getByUserId(int $userId, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return ArtistFollow::query()
            ->where('user_id', $userId)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function checkExist(int $userId, int $artistId): bool
    {
        return ArtistFollow::query()
            ->where('user_id', $userId)
            ->where('artist_id', $artistId)
            ->exists();
    }
}
