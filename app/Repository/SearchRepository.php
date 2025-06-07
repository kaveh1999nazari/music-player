<?php

namespace App\Repository;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Song;

class SearchRepository
{
    public function searchSongs(string $query, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Song::search($query)
            ->paginate($perPage, 'page', $page);
    }

    public function searchAlbums(string $query, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Album::search($query)
            ->paginate($perPage, 'page', $page);
    }

    public function searchArtists(string $query, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Artist::search($query)
            ->paginate($perPage, 'page', $page);
    }

    public function searchPlaylists(string $query, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Playlist::search($query)
            ->paginate($perPage, 'page', $page);
    }
}
