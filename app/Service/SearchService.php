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

        if (empty($filters) || in_array('songs', $filters)) {
            $songs = $this->searchRepository->searchSongs($query, $perPage, $page);
            if ($songs->total() > 0) {
                $results['songs'] = $songs->items();
            }
        }
        if (empty($filters) || in_array('albums', $filters)) {
            $albums = $this->searchRepository->searchAlbums($query, $perPage, $page);
            if ($albums->total() > 0) {
                $results['albums'] = $albums->items();
            }
        }
        if (empty($filters) || in_array('artists', $filters)) {
            $artists = $this->searchRepository->searchArtists($query, $perPage, $page);
            if ($artists->total() > 0) {
                $results['artists'] = $artists->items();
            }
        }
        if (empty($filters) || in_array('playlists', $filters)) {
            $playlists = $this->searchRepository->searchPlaylists($query, $perPage, $page);
            if ($playlists->total() > 0) {
                $results['playlists'] = $playlists->items();
            }
        }

        if (empty($results)) {
            throw new NotFoundSearchException();
        }

        return $results;
    }
}
