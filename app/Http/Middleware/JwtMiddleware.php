<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\GlobalResource;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $request
     * @return mixed
     *  */
    public function handle(Request $request, \Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return GlobalResource::jsonResponse(['resp' => __('jwt.invalid')], 401);
            } elseif ($e instanceof TokenExpiredException) {
                return GlobalResource::jsonResponse(['resp' => __('jwt.expired')], 401);
            } else {
                return GlobalResource::jsonResponse(['resp' => __('jwt.anotherTokenProblem'), 'data' => $e], 401);
            }
        }

        return $next($request);
    }
}
