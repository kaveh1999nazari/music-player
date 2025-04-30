<?php

namespace App\Repository;

use App\Models\SongArtist;

class SongArtistRepository
{
    public function create(array $data)
    {
        return SongArtist::query()
            ->create([
                'song_id' => $data['song_id'],
                'artist_id' => $data['artist_id']
            ]);
    }
}
