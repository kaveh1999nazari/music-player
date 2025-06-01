<?php

namespace App\Exceptions;

use Exception;

class AlbumNotExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Album not found',
            'code' => 404
        ]);
    }
}
