<?php

namespace App\Exceptions;

use Exception;

class DuplicateMediaException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'A similar file has already been uploaded',
            'code' => 409,
        ]);
    }
}
