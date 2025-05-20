<?php

namespace App\Exceptions;

use Exception;

class AlbumFollowBeforeException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'شما این آلبوم را قبلا دنبال کرده اید',
            'code' => 406
        ]);
    }
}
