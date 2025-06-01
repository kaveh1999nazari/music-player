<?php

namespace App\Exceptions;

use Exception;

class UserNotFound extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error' => 'Only admins have access to this section',
            'code' => 404,
        ]);
    }
}
