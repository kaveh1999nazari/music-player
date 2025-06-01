<?php

namespace App\Exceptions;

use Exception;

class MediaNotEmpty extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Please attach the file to upload',
            'code' => 422,
        ]);
    }
}
