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
            'message' => 'با موفقیت دنبال شد',
            'code' => 200
        ]);
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $userFollow = $this->playlistFollowService->getByUserId(auth()->id());

        return response()->json([
            'data' => $userFollow,
            'code' => 200
        ]);
    }

    public function destroy(int $artistId): \Illuminate\Http\JsonResponse
    {
        $this->playlistFollowService->delete($artistId);

        return response()->json([
            'message' => 'با موفقیت آنفالو شد',
            'code' => 200
        ]);
    }
}
