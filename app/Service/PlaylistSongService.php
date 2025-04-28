<?php

namespace App\Service;

use App\Exceptions\PlaylistSongExistException;
use App\Models\PlaylistSong;
use App\Repository\PlaylistSongRepository;

class PlaylistSongService
{
    public function __construct(
        private readonly PlaylistSongRepository $playlistSongRepository
    )
    {}

    public function create(array $data)
    {
        $existing = $this->playlistSongRepository->get(
            $data['playlist_id'],
            $data['song_id']
        );

        if ($existing) {
            throw new PlaylistSongExistException;
        }

        return $this->playlistSongRepository->create([
            'playlist_id' => $data['playlist_id'],
            'song_id' => $data['song_id'],
            'added_at' => now()
        ]);
    }
}
