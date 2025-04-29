<?php

namespace App\Service;

use App\Exceptions\PlaylistNotFoundException;
use App\Exceptions\PlaylistSongExistException;
use App\Exceptions\PlaylistSongNotFoundException;
use App\Exceptions\SongNotFoundException;
use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSongRepository;
use App\Repository\SongRepository;

class PlaylistSongService
{
    public function __construct(
        private readonly PlaylistSongRepository $playlistSongRepository,
        private readonly SongRepository $songRepository,
        private readonly PlaylistRepository $playlistRepository
    )
    {}

    public function create(array $data)
    {
        if ($this->playlistRepository->checkExist($data['playlist_id']) === true) {
            $existing = $this->playlistSongRepository->get(
                $data['playlist_id'],
                $data['song_id']
            );

            if ($existing) {
                throw new PlaylistSongExistException;
            }

            $song = $this->songRepository->getById($data['song_id']);

            if (! $song) {
                throw new SongNotFoundException();
            }

            return $this->playlistSongRepository->create([
                'playlist_id' => $data['playlist_id'],
                'song_id' => $song->id,
                'added_at' => now()
            ]);
        }else {
            throw new PlaylistNotFoundException();
        }
    }

    public function delete(int $id)
    {
        $playlistSong = $this->playlistSongRepository->delete($id);

        if (! $playlistSong) {
            throw new PlaylistSongNotFoundException();
        }

        return $playlistSong;
    }
}
