<?php

namespace App\Service;

use App\Exceptions\PlaylistFollowBeforeException;
use App\Exceptions\PlaylistNotFoundException;
use App\Repository\PlaylistFollowRepository;
use App\Repository\PlaylistRepository;

class PlaylistFollowService
{
    public function __construct(
        private readonly PlaylistFollowRepository $playlistFollowRepository,
        private readonly PlaylistRepository       $playlistRepository,
    )
    {
    }

    public function create(array $data)
    {
        $album = $this->playlistRepository->getById($data['playlist_id']);

        if (!$album) {
            throw new PlaylistNotFoundException();
        }

        if ($this->playlistFollowRepository->checkExist(auth()->id(), $data['playlist_id'])) {
            throw new PlaylistFollowBeforeException();
        }

        return $this->playlistFollowRepository->create($data);
    }

    public function delete(int $id)
    {
        return $this->playlistFollowRepository->delete($id);
    }

    public function get(int $id)
    {
        return $this->playlistFollowRepository->get($id);
    }

    public function getByUserId(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->playlistFollowRepository->getByUserId($userId);
    }
}
