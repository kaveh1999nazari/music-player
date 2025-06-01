<?php

namespace App\Exceptions;

use Exception;

class PlaylistFollowBeforeException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'You have already followed this playlist',
            'code' => 406
        ]);
    }
}
