<?php

namespace App\Exceptions;

use Exception;

class UserExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'User has been registered',
            'code' => 406
        ]);
    }
}
