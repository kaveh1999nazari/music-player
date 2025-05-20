<?php

namespace App\Repository;

use App\Models\Playlist;
use App\Models\PlaylistSong;
use App\Models\Song;
use App\Trait\GeneratesUniqueShareToken;
use Illuminate\Support\Str;

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

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Playlist::query()
            ->where('user_id', auth()->id())
            ->get();
    }

    public function get(string $shareToken)
    {
        return Playlist::query()
            ->with('playlistSongs')
            ->where('share_token', $shareToken)
            ->where('user_id', auth()->id())
            ->first();
    }

    public function getById(int $id)
    {
        return Playlist::query()
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
}
