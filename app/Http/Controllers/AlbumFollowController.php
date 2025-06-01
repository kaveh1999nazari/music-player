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

    public function index(): \Illuminate\Http\JsonResponse
    {
        $userFollow = $this->albumFollowService->getByUserId(auth()->id());

        return response()->json([
            'data' => $userFollow,
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
