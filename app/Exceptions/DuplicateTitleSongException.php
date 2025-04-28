<?php

namespace App\Exceptions;

use Exception;

class DuplicateTitleSongException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => "آهنگی با این عنوان قبلاً توسط شما ثبت شده است.",
            'code' => 409,
        ]);
    }
}
