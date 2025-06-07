<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistFollowCreateRequest;
use App\Service\PlaylistFollowService;
use Illuminate\Http\Request;

class PlaylistFollowController extends Controller
{
    public function __construct(
        private readonly PlaylistFollowService $playlistFollowService
    )
    {}

    public function store(PlaylistFollowCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->playlistFollowService->create($request->validated());

        return response()->json([
            'message' => 'followed successfully',
            'code' => 200
        ]);
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $userFollow = $this->playlistFollowService->getByUserId(auth()->id(), $perPage, $page);

        return response()->json([
            'data' => $userFollow->items(),
            'page' => $userFollow->currentPage(),
            'code' => 200
        ]);
    }

    public function destroy(int $artistId): \Illuminate\Http\JsonResponse
    {
        $this->playlistFollowService->delete($artistId);

        return response()->json([
            'message' => 'Unfollowed successfully',
            'code' => 200
        ]);
    }
}
