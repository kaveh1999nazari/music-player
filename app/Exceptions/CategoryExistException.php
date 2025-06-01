<?php

namespace App\Exceptions;

use Exception;

class CategoryExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'The category you selected already exists',
            'code' => 406
        ]);
    }
}
