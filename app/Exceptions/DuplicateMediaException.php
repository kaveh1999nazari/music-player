<?php

namespace App\Exceptions;

use Exception;

class DuplicateMediaException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'فایل مشابهی قبلاً آپلود شده است',
            'code' => 409,
        ]);
    }
}
