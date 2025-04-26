<?php

namespace App\Exceptions;

use Exception;

class UserNotFound extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error' => 'کاربر مورد نظر ثبت نام نکرده است',
            'code' => 404,
        ]);
    }
}
