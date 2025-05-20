<?php

namespace App\Exceptions;

use Exception;

class PlaylistFollowBeforeException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'شما این پلی لیست را قبلا دنبال کرده اید',
            'code' => 406
        ]);
    }
}
