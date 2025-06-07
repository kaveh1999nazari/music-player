<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Service\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        private readonly SearchService $searchService
    )
    {}

    public function search(SearchRequest $request): \Illuminate\Http\JsonResponse
    {
        $query = $request->input('query');
        $filters = $request->input('filters', ['songs', 'albums', 'artists', 'playlists']);
        $page = $request->input('page', 1);
        $search = $this->searchService->search($query, $filters, $page);

        return response()->json([
            'code' => 200,
            'data' => $search['results'],
            'page' => $search['page'],
        ]);
    }
}
