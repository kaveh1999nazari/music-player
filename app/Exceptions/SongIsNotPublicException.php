<?php

namespace App\Exceptions;

use Exception;

class SongIsNotPublicException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'The specified song is private and cannot be added to the list',
            'code' => 406
        ]);
    }
}
