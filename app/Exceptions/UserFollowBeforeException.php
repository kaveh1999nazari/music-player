<?php

namespace App\Exceptions;

use Exception;

class UserFollowBeforeException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'You have already followed this user',
            'code' => 406
    ]);
    }
}
