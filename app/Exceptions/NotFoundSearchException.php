<?php

namespace App\Exceptions;

use Exception;

class NotFoundSearchException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'نتیجه‌ای برای جست‌وجوی شما یافت نشد.',
            'status' => 404,
        ]);
    }
}
