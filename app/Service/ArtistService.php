<?php

namespace App\Service;

use App\Exceptions\ArtistNotExistException;
use App\Repository\ArtistRepository;

class ArtistService
{
    public function __construct(
        private readonly ArtistRepository $artistRepository
    )
    {}

    public function getByToken(string $shareToken)
    {
        $artist = $this->artistRepository->getByToken($shareToken);
        if(! $artist) {
            throw new ArtistNotExistException();
        }

        return $artist;
    }

    public function getById(int $id)
    {
        $artist = $this->artistRepository->getById($id);
        if(! $artist) {
            throw new ArtistNotExistException();
        }

        return $artist;
    }
}
