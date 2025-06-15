<?php

namespace App\Service;

use App\Exceptions\NotFoundSearchException;
use App\Repository\SearchRepository;

class SearchService
{
    public function __construct(
        private readonly SearchRepository $searchRepository
    )
    {}

    public function search(string $query, array $filters, int $page = 1): array
    {
        $perPage = 10;
        $results = [];
        $currentPage = $page;

        if (empty($filters) || in_array('songs', $filters)) {
            $songs = $this->searchRepository->searchSongs($query, $perPage, $page);

            $publicSongs = collect($songs->items())->filter(fn($song) => $song->is_public);

            if ($publicSongs->isNotEmpty()) {
                $results['songs'] = $publicSongs->values();
                $currentPage = $songs->currentPage();
            }
        }

        if (empty($filters) || in_array('albums', $filters)) {
            $albums = $this->searchRepository->searchAlbums($query, $perPage, $page);

            $publicAlbums = collect($albums->items())->filter(function ($album) {
                return $album->songs->contains(fn($song) => $song->is_public);
            });

            if ($publicAlbums->isNotEmpty()) {
                $results['albums'] = $publicAlbums->values();
                $currentPage = $albums->currentPage();
            }
        }

        if (empty($filters) || in_array('artists', $filters)) {
            $artists = $this->searchRepository->searchArtists($query, $perPage, $page);

            $publicArtists = collect($artists->items())->filter(function ($artist) {
                return $artist->songs->contains(fn($song) => $song->is_public);
            });

            if ($publicArtists->isNotEmpty()) {
                $results['artists'] = $publicArtists->values();
                $currentPage = $artists->currentPage();
            }
        }

        if (empty($filters) || in_array('playlists', $filters)) {
            $playlists = $this->searchRepository->searchPlaylists($query, $perPage, $page);

            $publicPlaylists = collect($playlists->items())->filter(fn($p) => $p->is_public);

            if ($publicPlaylists->isNotEmpty()) {
                $results['playlists'] = $publicPlaylists->values();
                $currentPage = $playlists->currentPage();
            }
        }

        if (empty($results)) {
            throw new NotFoundSearchException();
        }

        return [
            'results' => $results,
            'page' => $currentPage,
        ];
    }
}
