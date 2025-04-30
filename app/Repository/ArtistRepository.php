<?php

namespace App\Repository;

use App\Models\Artist;

class ArtistRepository
{
    public function create(array $data)
    {
        return Artist::query()
            ->create($data);
    }

    public function checkExist(int $id): bool
    {
        return Artist::query()
            ->where('id', $id)
            ->exists();
    }

    public function get(int $id)
    {
        return Artist::query()
            ->where('id', $id)
            ->first();
    }
}
