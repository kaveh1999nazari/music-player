<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongCreateRequest;
use App\Service\SongService;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function __construct(
        private readonly SongService $songService
    )
    {}

    public function create(SongCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $song = $this->songService->create($request->validated(), $request->file('audio'));

        return response()->json([
            'id' => $song->id,
            'code' => 201
        ]);
    }
}
