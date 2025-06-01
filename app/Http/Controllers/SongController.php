<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongCreateRequest;
use App\Service\SongService;
use Illuminate\Http\JsonResponse;

class SongController extends Controller
{
    public function __construct(
        private readonly SongService $songService
    )
    {}

    public function create(SongCreateRequest $request): JsonResponse
    {
        $song = $this->songService->create($request->validated(), $request->file('audio'));

        return response()->json([
            'id' => $song->share_token,
            'code' => 201
        ]);
    }

    public function index(): JsonResponse
    {
        $songs = $this->songService->all();

        return response()->json([
            'code' => 201,
            'data' => $songs,
        ]);
    }

    public function get(string $shareToken): JsonResponse
    {
        $song = $this->songService->get($shareToken);

        return response()->json([
            'code' => 201,
            'data' => $song
        ]);
    }

    public function destroy(string $shareToken): JsonResponse
    {
        $this->songService->deleteByShareToken($shareToken);

        return response()->json([
            'code' => 200,
            'message' => 'The song has been deleted successfully'
        ]);
    }
}
