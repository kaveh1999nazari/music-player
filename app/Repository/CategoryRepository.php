<?php

namespace App\Repository;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Playlist;
use App\Models\Song;
use App\Trait\GeneratesUniqueShareToken;
use Illuminate\Support\Str;

class CategoryRepository
{
    use GeneratesUniqueShareToken;

    public function create(array $data)
    {
        return Category::query()
            ->create([
                'name' => $data['name'],
                'share_token' => $this->generateUniqueShareToken()
            ]);
    }
    public function checkExistById(int $id): bool
    {
        return Category::query()
            ->where('id', $id)
            ->exists();
    }

    public function checkExistByName(string $name): bool
    {
        return Category::query()
            ->where('name', $name)
            ->exists();
    }

    public function getByToken(string $shareToken)
    {
        return Category::query()
            ->with('songCategory')
            ->where('share_token', $shareToken)
            ->first();
    }

    public function getById(int $id)
    {
        return Category::query()
            ->with('songCategory')
            ->where('id', $id)
            ->first();
    }

    public function all()
    {
        return Category::query()
            ->get();
    }
}
