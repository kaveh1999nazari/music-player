<?php

namespace App\Repository;

use App\Models\Artist;
use App\Trait\GeneratesUniqueShareToken;

class ArtistRepository
{
    use GeneratesUniqueShareToken;
    public function create(array $data)
    {
        return Artist::query()
            ->create([
                'name' => $data['name'],
                'share_token' => $this->generateUniqueShareToken()
            ]);
    }

    public function checkExist(int $id): bool
    {
        return Artist::query()
            ->where('id', $id)
            ->exists();
    }

    public function checkExistByName(string $name): bool
    {
        return Artist::query()
            ->where('name', $name)
            ->exists();
    }

    public function getById(int $id)
    {
        return Artist::query()
            ->with('songArtist')
            ->where('id', $id)
            ->first();
    }

    public function getByToken(string $shareToken)
    {
        return Artist::query()
            ->with('songArtist')
            ->where('share_token', $shareToken)
            ->with('media')
            ->first();
    }

    public function all(int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Artist::query()
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
