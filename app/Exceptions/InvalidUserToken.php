<?php

namespace App\Exceptions;

use Exception;

class InvalidUserToken extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'توکن شما منقضی شده است، لطفا مجددا وارد شوید',
            'code' => 406
        ]);
    }
}
