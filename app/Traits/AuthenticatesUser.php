<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AuthenticatesUser
{
    public function getAuthenticatedUserOrFail(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $user = Auth::user();

        if (!$user) {
            abort(response()->json([
                'message' => 'ابتدا وارد حساب کاربری خود شوید'
            ], 401));
        }

        return $user;
    }
}
