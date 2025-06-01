<?php

namespace App\Exceptions;

use Exception;

class PlaylistNotFoundException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'The requested playlist does not exist',
            'code' => 404
        ]);
    }
}
