<?php

namespace App\Http\Controllers;

use App\Service\SocialAuthService;
use Illuminate\Http\RedirectResponse;

class SocialAuthController extends Controller
{
    public function __construct(
        private readonly SocialAuthService $socialAuthService
    ) {}

    public function redirect(string $provider): RedirectResponse
    {
        return $this->socialAuthService->redirect($provider);
    }

    public function callback(string $provider)
    {
        $user = $this->socialAuthService->callback($provider);

         return response()->json(['token' => $user->access_token]);

    }
}
