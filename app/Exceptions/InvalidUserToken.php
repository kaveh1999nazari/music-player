<?php

namespace App\Exceptions;

use Exception;

class InvalidUserToken extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Your token has expired. Please log in again',
            'code' => 406
        ]);
    }
}
