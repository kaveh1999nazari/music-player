<?php

namespace App\Exceptions;

use Exception;

class MediaNotEmpty extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'لطفا فایل اپلودی خود را قرار دهید',
            'code' => 422,
        ]);
    }
}
