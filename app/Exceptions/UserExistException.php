<?php

namespace App\Exceptions;

use Exception;

class UserExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'کاربر ثبت نام کرده است',
            'code' => 406
        ]);
    }
}
