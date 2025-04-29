<?php

namespace App\Exceptions;

use Exception;

class PlaylistSongNotFoundException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => "آهنگ مورد نظر شمادر این پلی لیست یافت نشد",
            'code' => 404,
        ]);
    }
}
