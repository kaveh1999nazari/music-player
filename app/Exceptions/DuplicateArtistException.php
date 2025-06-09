<?php

namespace App\Exceptions;

use Exception;

class DuplicateArtistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Artist already exists',
            'code' => 406
        ]);
    }
}
