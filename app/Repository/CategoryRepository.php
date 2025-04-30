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
    public function checkExist(int $id): bool
    {
        return Category::query()
            ->where('id', $id)
            ->exists();
    }
}
