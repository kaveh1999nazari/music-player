<?php

namespace App\Exceptions;

use Exception;

class UserFollowBeforeException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'شما این کاربر را قبلا دنبال کرده اید',
            'code' => 406
    ]);
    }
}
