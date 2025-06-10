<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistCreateRequest;
use App\Service\PlaylistService;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function __construct(
        private readonly PlaylistService $playlistService
    )
    {}

    public function create(PlaylistCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $playlist = $this->playlistService->create(
            $request->validated(),
            $request->file('photo')
        );

        return response()->json([
            'id' => $playlist->share_token,
            'code' => 201
        ]);
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $playList = $this->playlistService->all($perPage, $page);

        return response()->json([
            'data' => $playList->items(),
            'page' => $playList->currentPage(),
            'code' => 200
        ]);
    }

    public function get(string $shareToken): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $this->playlistService->get($shareToken),
            'code' => 200
        ]);
    }

    public function destroy(string $shareToken)
    {
        $playList = $this->playlistService->delete($shareToken);
        return response()->json([
            'message' => 'The playlist has been deleted successfully',
            'code' => 200
        ]);
    }
}
