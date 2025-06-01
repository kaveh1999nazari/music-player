<?php

namespace App\Exceptions;

use Exception;

class SongNotFoundException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => "The specified song was not found",
            'code' => 404,
        ]);
    }
}
