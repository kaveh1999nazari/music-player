<?php

namespace App\Repository;

use App\Models\Song;
use Illuminate\Support\Str;

class SongRepository
{
    public function create(array $data)
    {
        do {
            $shareToken = Str::random(8);
        } while (Song::query()->where('share_token', $shareToken)->exists());

        return Song::query()->create([
            'title' => $data['title'],
            'artist_id' => $data['artist_id'] ?? null,
            'album_id' => $data['album_id'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'created_by' => auth()->id(),
            'share_token' => $shareToken,
        ]);
    }
}
