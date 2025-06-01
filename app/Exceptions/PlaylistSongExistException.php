<?php

namespace App\Exceptions;

use Exception;

class PlaylistSongExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'The song is already in the list',
            'code' => 406
        ]);
    }
}
