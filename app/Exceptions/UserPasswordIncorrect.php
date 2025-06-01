<?php

namespace App\Exceptions;

use Exception;

class UserPasswordIncorrect extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error' => 'Incorrect password. Please try again',
            'code' => 401,
        ]);
    }
}
