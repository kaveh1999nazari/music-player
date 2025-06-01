<?php

namespace App\Exceptions;

use Exception;

class NotFoundItemException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Item not found',
            'code' => 404
        ]);
    }
}
