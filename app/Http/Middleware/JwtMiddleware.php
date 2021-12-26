<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Closure $request
     * @return mixed
     *  */

    public function handle(Request $request, \Closure $next) {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['resp' => 'Token inválido']);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json(['resp' => 'Token expirado']);
            } else {
                return response()->json(['resp' => 'Problema com o token de autenticação', "data" => $e]);
            }
        }
        return $next($request);
    }
}