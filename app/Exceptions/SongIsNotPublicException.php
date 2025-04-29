<?php

namespace App\Exceptions;

use Exception;

class SongIsNotPublicException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'آهنگ مورد نظر خصوصی است، نمیتوان جزو لیست قرار داد',
            'code' => 406
        ]);
    }
}
