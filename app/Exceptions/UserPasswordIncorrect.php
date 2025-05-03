<?php

namespace App\Exceptions;

use Exception;

class UserPasswordIncorrect extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error' => 'رمز اشتباه وارد شده است',
            'code' => 401,
        ]);
    }
}
