<?php

namespace App\Exceptions;

use Exception;

class ArtistFollowBeforeException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'You have already followed this artist',
            'code' => 406
        ]);
    }
}
