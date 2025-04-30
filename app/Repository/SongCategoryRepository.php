<?php

namespace App\Repository;

use App\Models\SongCategory;

class SongCategoryRepository
{
    public function create(array $data)
    {
        return SongCategory::query()
            ->create([
                'song_id' => $data['song_id'],
                'category_id' => $data['category_id']
            ]);
    }
}
