<?php

namespace App\Exceptions;

use Exception;

class UserNotAdminException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'فقط ادمین دسترسی به این قسمت دارد',
            'code' => 406
        ]);
    }
}
