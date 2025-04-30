<?php

namespace App\Http\Controllers;

use App\Service\AlbumService;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function __construct(
        private readonly AlbumService $albumService
    )
    {}

    public function getById(int $id)
    {
        $album = $this->albumService->getById($id);

        return response()->json([
            'data' => $album,
            'code' => 201
        ]);
    }

    public function getByToken(string $shareToken): \Illuminate\Http\JsonResponse
    {
        $album = $this->albumService->getByToken($shareToken);

        return response()->json([
            'data' => $album,
            'code' => 201
        ]);
    }
}
