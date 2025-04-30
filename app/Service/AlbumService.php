<?php

namespace App\Service;

use App\Exceptions\AlbumNotExistException;
use App\Repository\AlbumRepository;

class AlbumService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository
    )
    {}

    public function getById(int $id)
    {
        $album = $this->albumRepository->getById($id);
        if (! $album) {
            throw new AlbumNotExistException();
        }

        return $album;
    }

    public function getByToken(string $shareToken)
    {
        $album = $this->albumRepository->getByToken($shareToken);
        if (! $album) {
            throw new AlbumNotExistException();
        }

        return $album;
    }
}
