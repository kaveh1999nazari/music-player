<?php

namespace App\Repository;

use App\Models\Playlist;
use App\Trait\GeneratesUniqueShareToken;

class PlaylistRepository
{
    use GeneratesUniqueShareToken;
    public function create(array $data)
    {
        return Playlist::query()
            ->create([
                'user_id' => auth()->id(),
                'title' => $data['title'],
                'is_public' => true,
                'share_token' => $this->generateUniqueShareToken()
            ]);
    }

    public function all(int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Playlist::query()
            ->with('media')
            ->where('user_id', auth()->id())
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function get(string $shareToken)
    {
        return Playlist::query()
            ->with(['playlistSongs', 'media'])
            ->where('share_token', $shareToken)
            ->where('user_id', auth()->id())
            ->first();
    }

    public function getById(int $id)
    {
        return Playlist::query()
            ->with('media')
            ->where('id', $id)
            ->first();
    }

    public function delete(Playlist $playlist)
    {
        return $playlist->delete();
    }

    public function checkExist(int $id): bool
    {
        return Playlist::query()
            ->where('id', $id)
            ->exists();
    }

    public function checkByUserId(int $playlistId, int $userId): bool
    {
        return Playlist::query()
            ->where('id', $playlistId)
            ->where('user_id', $userId)
            ->exists();
    }
}
