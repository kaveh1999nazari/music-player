<?php

namespace App\Service;

use App\Exceptions\FavoriteNotFoundException;
use App\Exceptions\SongIsNotPublicException;
use App\Exceptions\SongNotFoundException;
use App\Repository\FavoriteRepository;
use App\Repository\SongRepository;

class FavoriteService
{
    public function __construct(
        private readonly FavoriteRepository $favoriteRepository,
        private readonly SongRepository $songRepository
    )
    {}

    public function create(array $data)
    {
        $song = $this->songRepository->getById($data['song_id']);
        if (! $song) {
            throw new SongNotFoundException();
        }

        if ($song->is_public === true) {
            return $this->favoriteRepository->create($data['song_id']);
        }else {
            throw new SongIsNotPublicException();
        }
    }

    public function all()
    {
        return $this->favoriteRepository->all();
    }

    public function get(int $id)
    {
        $favorite = $this->favoriteRepository->get($id);
        if(! $favorite) {
            throw new FavoriteNotFoundException();
        }

        return $favorite;
    }

    public function delete(int $id)
    {
        $favorite = $this->favoriteRepository->get($id);
        if(! $favorite) {
            throw new FavoriteNotFoundException();
        }

        return $this->favoriteRepository->delete($id);
    }
}
