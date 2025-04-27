<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // اینجا تلاش می‌کنیم توکن رو چک کنیم
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user) {
                return response()->json(['message' => 'لطفا وارد شوید.'], 401);
            }

        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'اعتبار توکن شما به اتمام رسیده است، لطفا مجددا وارد شوید'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'لطفا مجددا وارد شوید'], 401);
        } catch (JWTException $e) {
            return response()->json(['message' => 'ابتدا وارد پنل کاربری شوید'], 401);
        }

        return $next($request);
    }
}
