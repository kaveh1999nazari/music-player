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
        $playList = $this->playlistService->create($request->validated());

        return response()->json([
            'id' => $playList->share_token,
            'code' => 201
        ]);
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $playList = $this->playlistService->all();

        return response()->json([
            'data' => $playList,
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
}
