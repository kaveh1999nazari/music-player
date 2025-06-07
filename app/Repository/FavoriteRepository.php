<?php

namespace App\Repository;

use App\Models\Favorite;

class FavoriteRepository
{
    public function create(int $songId)
    {
        return Favorite::query()
            ->create([
                'user_id' => auth()->id(),
                'song_id' => $songId
            ]);
    }

    public function all(int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Favorite::query()
            ->where('user_id', auth()->id())
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function get(int $id)
    {
        return Favorite::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
    }

    public function delete(int $id)
    {
        return Favorite::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();
    }
}
