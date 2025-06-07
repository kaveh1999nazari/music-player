<?php

namespace App\Service;

use App\Exceptions\ArtistFollowBeforeException;
use App\Exceptions\ArtistNotExistException;
use App\Repository\ArtistFollowRepository;
use App\Repository\ArtistRepository;

class ArtistFollowService
{
    public function __construct(
        private readonly ArtistFollowRepository $artistFollowRepository,
        private readonly ArtistRepository        $artistRepository,
    )
    {
    }

    public function create(array $data)
    {
        $album = $this->artistRepository->getById($data['artist_id']);

        if (!$album) {
            throw new ArtistNotExistException();
        }

        if ($this->artistFollowRepository->checkExist(auth()->id(), $data['artist_id'])) {
            throw new ArtistFollowBeforeException();
        }

        return $this->artistFollowRepository->create($data);
    }

    public function delete(int $id)
    {
        return $this->artistFollowRepository->delete($id);
    }

    public function get(int $id)
    {
        return $this->artistFollowRepository->get($id);
    }

    public function getByUserId(int $userId, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->artistFollowRepository->getByUserId($userId, $perPage, $page);
    }
}
