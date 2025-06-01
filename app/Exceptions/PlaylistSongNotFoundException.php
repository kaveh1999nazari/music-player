<?php

namespace App\Exceptions;

use Exception;

class PlaylistSongNotFoundException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => "The song you are looking for was not found in this playlist",
            'code' => 404,
        ]);
    }
}
