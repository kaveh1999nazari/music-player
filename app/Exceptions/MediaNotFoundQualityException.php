<?php

namespace App\Exceptions;

use Exception;

class MediaNotFoundQualityException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Media with selected quality not found',
            'code' => 404,
        ]);
    }
}
