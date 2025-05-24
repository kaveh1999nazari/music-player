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
        $result = $this->socialAuthService->callback($provider);

         return [
             'user' => $result['user'],
             'access_token' => $result['access_token'],
             'refresh_token' => $result['refresh_token'],
         ];

    }
}
