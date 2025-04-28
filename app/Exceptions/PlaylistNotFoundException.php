<?php

namespace App\Exceptions;

use Exception;

class PlaylistNotFoundException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'پلی موزیک مورد نظر موجود نیست',
            'code' => 404
        ]);
    }
}
