<?php

namespace App\Exceptions;

use Exception;

class DuplicateTitleSongException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => "A song with this title has already been registered by you",
            'code' => 409,
        ]);
    }
}
