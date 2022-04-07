<?php

namespace App\Http\Middleware;

use App\Models\Access\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsersController;

class FrontendAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $jwt = $request->cookie('jat');
        if (!$jwt) {
            UsersController::logout($request);
            return redirect()->route('login');
        }

        $payload = self::getDecodedPayload($jwt);
        if (time() >= $payload['exp']) {
            UsersController::logout($request);
            return redirect()->route('login');
        }

        $userId = $payload['sub'];
        $user = User::find($userId);
        Auth::login($user);

        return $next($request);
    }

    public static function getDecodedPayload($jwt)
    {
        $sections = explode('.', $jwt);
        $payload = $sections[1];    
        $decodedPayload = base64_decode($payload);
        return json_decode($decodedPayload, true);
    }
}
