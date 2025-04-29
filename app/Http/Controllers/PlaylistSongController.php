<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistSongCreateRequest;
use App\Service\PlaylistSongService;
use Illuminate\Http\Request;

class PlaylistSongController extends Controller
{
    public function __construct(
        private readonly PlaylistSongService $playlistSongService
    )
    {}

    public function create(PlaylistSongCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $playlistSong = $this->playlistSongService->create($request->validated());

        return response()->json([
            'id' => $playlistSong->id,
            'code' => 201
        ]);
    }

    public function destroy(int $id)
    {
        $this->playlistSongService->delete($id);

        return response()->json([
            'message' => 'باموفقیت از پلی لیست شما حذف شد',
            'code' => 201
        ]);
    }
}
