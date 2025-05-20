<?php

namespace App\Exceptions;

use Exception;

class ArtistFollowBeforeException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'شما این هنرمند را قبلا دنبال کرده اید',
            'code' => 406
        ]);
    }
}
