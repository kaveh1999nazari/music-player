<?php

namespace App\Exceptions;

use Exception;

class UserFollowNotAllow extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'شما نمیتوانید خودتان را دنبال کنید',
            'code' => 406
        ]);
    }
}
