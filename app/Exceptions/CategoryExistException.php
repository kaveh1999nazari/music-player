<?php

namespace App\Exceptions;

use Exception;

class CategoryExistException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'دسته انتخاب شده قبلا ایجاد شده است',
            'code' => 406
        ]);
    }
}
