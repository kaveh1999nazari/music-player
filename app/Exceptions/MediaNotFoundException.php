<?php

namespace App\Exceptions;

use Exception;

class MediaNotFoundException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'File not found on storage',
            'code' => 404,
        ]);
    }
}
