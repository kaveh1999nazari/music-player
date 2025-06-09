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

    /**
     * Check if a media file with the same file_path (i.e. name) already exists.
     */
    public function existsDuplicateByName(string $relativePath): bool
    {
        return Media::query()
            ->where('file_path', $relativePath)
            ->exists();
    }

    public function getByModelAndQuality(int $modelId, string $modelType, int $quality)
    {
        return Media::query()
            ->where('model_id', $modelId)
            ->where('model_type', $modelType)
            ->where('quality', $quality)
            ->first();
    }

}
