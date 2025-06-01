<?php

namespace App\Exceptions;

use Exception;

class NotFoundSearchException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'No results found for your search',
            'status' => 404,
        ]);
    }
}
