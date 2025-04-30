<?php

namespace App\Exceptions;

use Exception;

class ArtistNotExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'خواننده مورد نظر پیدا نشد',
            'code' => 404
        ]);
    }
}
