<?php

namespace App\Repository;

use App\Models\PlaylistSong;

class PlaylistSongRepository
{
    public function create(array $data)
    {
        return PlaylistSong::query()
            ->create([
                'playlist_id' => $data['playlist_id'],
                'song_id' => $data['song_id'],
                'added_at' => now()
            ]);
    }

    public function get(int $playlistId, int $songId): ?PlaylistSong
    {
        return PlaylistSong::query()
            ->where('playlist_id', $playlistId)
            ->where('song_id', $songId)
            ->first();
    }
}
