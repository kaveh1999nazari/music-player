<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArtistFollowCreateRequest;
use App\Service\ArtistFollowService;
use Illuminate\Http\Request;

class ArtistFollowController extends Controller
{
    public function __construct(
        private readonly ArtistFollowService $artistFollowService
    )
    {}

    public function store(ArtistFollowCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->artistFollowService->create($request->validated());

        return response()->json([
            'message' => 'followed successfully',
            'code' => 200
        ]);
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $userFollow = $this->artistFollowService->getByUserId(auth()->id(), $perPage, $page);

        return response()->json([
            'data' => $userFollow->items(),
            'page' => $userFollow->currentPage(),
            'code' => 200
        ]);
    }

    public function destroy(int $artistId): \Illuminate\Http\JsonResponse
    {
        $this->artistFollowService->delete($artistId);

        return response()->json([
            'message' => 'Unfollowed successfully',
            'code' => 200
        ]);
    }
}
