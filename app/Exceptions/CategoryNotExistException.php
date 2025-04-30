<?php

namespace App\Exceptions;

use Exception;

class CategoryNotExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'دسته انتخاب شده موجود نیست',
            'code' => 404
        ]);
    }
}
