<?php

namespace App\Exceptions;

use Exception;

class FavoriteNotCreatedException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'No favorites list has been created by you yet',
            'code' => 400
        ]);
    }
}
