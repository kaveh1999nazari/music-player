<?php

namespace App\Exceptions;

use Exception;

class UserNotFound extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error' => 'User is not registered',
            'code' => 404,
        ]);
    }
}
