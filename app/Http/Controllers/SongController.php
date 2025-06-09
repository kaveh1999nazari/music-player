<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongCreateRequest;
use App\Service\SongService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function __construct(
        private readonly SongService $songService
    )
    {}

    public function create(SongCreateRequest $request): JsonResponse
    {
        $song = $this->songService->create($request->validated(),
            $request->file('audio'),
            $request->file('photo'));

        return response()->json([
            'id' => $song->share_token,
            'code' => 201
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $songs = $this->songService->all($perPage, $page);

        return response()->json([
            'code' => 200,
            'data' => $songs->items(),
            'page' => $songs->currentPage(),
        ]);
    }

    public function get(string $shareToken): JsonResponse
    {
        $song = $this->songService->get($shareToken);

        return response()->json([
            'code' => 200,
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

    public function streamMusic(Request $request, string $shareToken): JsonResponse
    {
        $quality = (int) $request->query('quality', 128);

        $url = $this->songService->streamMusic($shareToken, $quality);
        return response()->json([
            'url' => $url
        ]);
    }

    public function streamPhoto(string $shareToken): JsonResponse
    {
        $url = $this->songService->streamPhoto($shareToken);

        return response()->json([
            'url' => $url
        ]);
    }

}
