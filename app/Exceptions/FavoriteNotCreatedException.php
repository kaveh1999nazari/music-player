<?php

namespace App\Exceptions;

use Exception;

class FavoriteNotCreatedException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'لیست مورد علاقه هنوز ایجاد نکرده اید.',
            'code' => 400
        ]);
    }
}
