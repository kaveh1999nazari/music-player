<?php

namespace App\Exceptions;

use Exception;

class CategoryNotExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'The selected category does not exist',
            'code' => 404
        ]);
    }
}
