<?php

namespace App\Exceptions;

use Exception;

class UserNotAdminException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Only admins have access to this section',
            'code' => 406
        ]);
    }
}
