<?php

namespace App\Repository;

use App\Models\Album;

class AlbumRepository
{
    public function create(array $data)
    {
        return Album::query()
            ->create($data);
    }

    public function checkExist(int $id): bool
    {
        return Album::query()
            ->where('id', $id)
            ->exists();
    }
}
