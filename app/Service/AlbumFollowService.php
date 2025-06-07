<?php

namespace App\Service;

use App\Exceptions\AlbumFollowBeforeException;
use App\Exceptions\AlbumNotExistException;
use App\Repository\AlbumFollowRepository;
use App\Repository\AlbumRepository;

class AlbumFollowService
{
    public function __construct(
        private readonly AlbumFollowRepository $albumFollowRepository,
        private readonly AlbumRepository       $albumRepository,
    )
    {
    }

    public function create(array $data)
    {
        $album = $this->albumRepository->getById($data['album_id']);

        if (!$album) {
            throw new AlbumNotExistException();
        }

        if ($this->albumFollowRepository->checkExist(auth()->id(), $data['album_id'])) {
            throw new AlbumFollowBeforeException();
        }

        return $this->albumFollowRepository->create($data);
    }

    public function delete(int $id)
    {
        return $this->albumFollowRepository->delete($id);
    }

    public function get(int $id)
    {
        return $this->albumFollowRepository->get($id);
    }

    public function getByUserId(int $userId, int $perPage, int $page)
    {
        return $this->albumFollowRepository->getByUserId($userId, $perPage, $page);
    }
}
