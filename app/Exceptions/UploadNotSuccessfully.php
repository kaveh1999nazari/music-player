<?php

namespace App\Exceptions;

use Exception;

class UploadNotSuccessfully extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'can not upload, try later',
            'code' => 422
        ]);
    }
}
