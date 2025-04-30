<?php

namespace App\Repository;

use App\Models\SongAlbum;

class SongAlbumRepository
{
    public function create(array $data)
    {
        return SongAlbum::query()
            ->create([
                'song_id' => $data['song_id'],
                'album_id' => $data['album_id']
            ]);
    }
}
