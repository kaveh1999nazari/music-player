<?php

namespace App\Exceptions;

use Exception;

class SongNotFoundException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => "آهنگ مورد نظر شما یافت نشد",
            'code' => 404,
        ]);
    }
}
