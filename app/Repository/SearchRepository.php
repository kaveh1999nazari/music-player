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
        return Song::query()
            ->where('title', 'LIKE', "%$query%")
            ->with('media')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function searchAlbums(string $query, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Album::query()
            ->where('name', 'LIKE', "%$query%")
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function searchArtists(string $query, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Artist::query()
            ->where('name', 'LIKE', "%$query%")
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function searchPlaylists(string $query, int $perPage, int $page): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Playlist::query()
            ->where('title', 'LIKE', "%$query%")
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
