<?php

namespace App\Http\Controllers;

use App\Service\ArtistService;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function __construct(
        private readonly ArtistService $artistService
    )
    {}

    public function getByToken(string $shareToken)
    {
        $artist = $this->artistService->getByToken($shareToken);

        return response()->json([
            'data' => $artist,
            'code' => 201
        ]);
    }
}
