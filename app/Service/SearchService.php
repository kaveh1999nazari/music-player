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
            if ($songs->total() > 0 && $songs->items()[0]->is_public === true) {
                $results['songs'] = $songs->items();
                $currentPage = $songs->currentPage();
            }
        }
        if (empty($filters) || in_array('albums', $filters)) {
            $albums = $this->searchRepository->searchAlbums($query, $perPage, $page);
            if ($albums->total() > 0 && $albums->items()[0]->songs[0]->is_public === true) {
                $results['albums'] = $albums->items();
                $currentPage = $albums->currentPage();
            }
        }
        if (empty($filters) || in_array('artists', $filters)) {
            $artists = $this->searchRepository->searchArtists($query, $perPage, $page);
            if ($artists->total() > 0) {
                $results['artists'] = $artists->items();
                $currentPage = $artists->currentPage();
            }
        }
        if (empty($filters) || in_array('playlists', $filters)) {
            $playlists = $this->searchRepository->searchPlaylists($query, $perPage, $page);
            if ($playlists->total() > 0 && $playlists->items()[0]->is_public === true) {
                $results['playlists'] = $playlists->items();
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
