<?php

namespace App\Repository;

use App\Models\Media;

class MediaRepository
{
    public function create(array $data): Media
    {
        return Media::query()
                ->create($data);
    }
}
