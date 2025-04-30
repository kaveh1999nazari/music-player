<?php

namespace App\Exceptions;

use Exception;

class AlbumNotExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'آلبوم مورد نظر پیدا نشد',
            'code' => 404
        ]);
    }
}
