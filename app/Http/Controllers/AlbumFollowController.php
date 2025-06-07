<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumFollowCreateRequest;
use App\Service\AlbumFollowService;
use Illuminate\Http\Request;

class AlbumFollowController extends Controller
{
    public function __construct(
        private readonly AlbumFollowService $albumFollowService
    )
    {}

    public function store(AlbumFollowCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->albumFollowService->create($request->validated());

        return response()->json([
            'message' => 'followed successfully',
            'code' => 200
        ]);
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $userFollow = $this->albumFollowService->getByUserId(auth()->id(), $perPage, $page);

        return response()->json([
            'data' => $userFollow->items(),
            'page' => $userFollow->currentPage(),
            'code' => 200
        ]);
    }

    public function destroy(int $albumId): \Illuminate\Http\JsonResponse
    {
        $this->albumFollowService->delete($albumId);

        return response()->json([
            'message' => 'Unfollowed successfully',
            'code' => 200
        ]);
    }
}
