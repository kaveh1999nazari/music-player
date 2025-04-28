<?php

namespace App\Service;

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
        return $this->playlistRepository->get($shareToken);
    }
}
