<?php

namespace App\Exceptions;

use Exception;

class ArtistNotExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Artist not found',
            'code' => 404
        ]);
    }
}
