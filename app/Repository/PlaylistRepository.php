<?php

namespace App\Repository;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Support\Str;

class PlaylistRepository
{
    public function create(array $data)
    {
        do {
            $shareToken = Str::random(16);
        } while (Playlist::query()->where('share_token', $shareToken)->exists()
                && Song::query()->where('share_token', $shareToken)->exists());

        return Playlist::query()
            ->create([
                'user_id' => auth()->id(),
                'title' => $data['title'],
                'is_public' => true,
                'share_token' => $shareToken
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
            ->where('share_token', $shareToken)
            ->where('user_id', auth()->id())
            ->first();
    }

    public function delete(Playlist $playlist)
    {
        return $playlist->delete();
    }
}
