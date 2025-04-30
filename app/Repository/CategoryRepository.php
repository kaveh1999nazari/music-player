<?php

namespace App\Repository;

use App\Models\Category;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Support\Str;

class CategoryRepository
{
    public function create(array $data)
    {
        do {
            $shareToken = Str::random(16);
        } while (Song::query()->where('share_token', $shareToken)->exists()
        && Playlist::query()->where('share_token', $shareToken)->exists()
        && Category::query()->where('share_token', $shareToken)->exists());

        return Category::query()
            ->create([
                'name' => $data['name'],
                'share_token' => $shareToken
            ]);
    }
    public function checkExist(int $id): bool
    {
        return Category::query()
            ->where('id', $id)
            ->exists();
    }
}
