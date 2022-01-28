<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Access\User;

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
        if (! $jwt) {
            $request->session()->forget('userInfo');
            return redirect()->route('login');
        }

        $payload = self::getDecodedPayload($jwt);
        $expDate = date("Y-m-d H:i:s", $payload['exp']);
        if (time() >= $expDate) {
            $request->session()->forget('userInfo');
            return redirect()->route('login');
        }

        self::insertUserInfoIntoSession($request, $payload['sub']);
        
        return $next($request);
    }

    static public function getDecodedPayload($jwt) {
        $payload = explode('.', $jwt)[1];
        $decodedPayload = base64_decode($payload);
        return json_decode($decodedPayload, true);
    }

    static protected function insertUserInfoIntoSession(Request $request, $userId) {
        $user = User::find($userId);
        $userInfo = [
            "id" => $user->id,
            "nome" => $user->nome_escolhido,
            "avatar" => $user->avatar_path
        ];

        $request->session()->put('userInfo', $userInfo);
    }
}
