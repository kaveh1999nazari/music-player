<?php

namespace App\Service;

use App\Exceptions\PlaylistNotFoundException;
use App\Repository\PlaylistRepository;

class PlaylistService
{
    public function __construct(
        private readonly PlaylistRepository $playlistRepository
    )
    {}

    public function create(array $data)
    {
        return $this->playlistRepository->create($data);
    }

    public function all()
    {
        return $this->playlistRepository->all();
    }

    public function get(string $shareToken)
    {
        $playList = $this->playlistRepository->get($shareToken);

        if(! $playList) {
            throw new PlaylistNotFoundException();
        }

        return $playList;
    }

    public function delete(string $shareToken)
    {
        $playList = $this->playlistRepository->get($shareToken);

        return $this->playlistRepository->delete($playList);
    }
}
