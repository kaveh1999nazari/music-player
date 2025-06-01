<?php

namespace App\Exceptions;

use Exception;

class UserFollowNotAllow extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Following yourself is not allowed',
            'code' => 406
        ]);
    }
}
