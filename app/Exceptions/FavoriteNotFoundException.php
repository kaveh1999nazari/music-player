<?php

namespace App\Exceptions;

use Exception;

class FavoriteNotFoundException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => "Your favorite song could not be found in the list",
            'code' => 404,
        ]);
    }
}
