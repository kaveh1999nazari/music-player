<?php

namespace App\Exceptions;

use Exception;

class FavoriteNotFoundException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => "آهنگ مورد علاقه شما در لیست یافت نشد",
            'code' => 404,
        ]);
    }
}
