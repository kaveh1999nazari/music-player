<?php

namespace App\Exceptions;

use Exception;

class PlaylistSongExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'این اهنگ قبلا اضاف شده است',
            'code' => 406
        ]);
    }
}
