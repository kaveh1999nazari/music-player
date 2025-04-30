<?php

namespace App\Repository;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Playlist;
use App\Models\Song;
use App\Trait\GeneratesUniqueShareToken;
use Illuminate\Support\Str;

class AlbumRepository
{
    use GeneratesUniqueShareToken;
    public function create(array $data)
    {
        return Album::query()
            ->create([
                'name' => $data['name'],
                'artist_id' => $data['artist_id'],
                'release_year' => $data['release_year'] ?? null,
                'share_token' => $this->generateUniqueShareToken()
            ]);
    }

    public function checkExist(int $id): bool
    {
        return Album::query()
            ->where('id', $id)
            ->exists();
    }

    public function getByToken(string $shareToken)
    {
        return Album::query()
            ->with('songAlbum')
            ->where('share_token', $shareToken)
            ->first();
    }

    public function getById(int $id)
    {
        return Album::query()
            ->with('songAlbum')
            ->where('id', $id)
            ->first();
    }

    public function all()
    {
        return Album::query()
            ->get();
    }
}
