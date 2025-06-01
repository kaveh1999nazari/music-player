<?php

namespace App\Exceptions;

use Exception;

class AlbumFollowBeforeException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'you choose this album before',
            'code' => 406
        ]);
    }
}
