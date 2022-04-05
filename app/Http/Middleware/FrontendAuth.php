<?php

namespace App\Http\Middleware;

use App\Models\Access\User;
use Closure;
use Exception;
use Illuminate\Http\Request;

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
            $request->session()->forget('userInfo');
            return redirect()->route('login');
        }

        $payload = self::getDecodedPayload($jwt);
        if (time() >= $payload['exp']) {
            $request->session()->forget('userInfo');
            return redirect()->route('login');
        }

        self::insertUserInfoIntoSession($request, $payload['sub']);

        return $next($request);
    }

    public static function getDecodedPayload($jwt)
    {
        $sections = explode('.', $jwt);
        $payload = $sections[1];    
        $decodedPayload = base64_decode($payload);
        return json_decode($decodedPayload, true);
    }

    protected static function insertUserInfoIntoSession(Request $request, $userId)
    {
        $user = User::find($userId);
        $userInfo = [
            'id' => $user->id,
            'nome' => $user->nome_escolhido,
            'avatar' => $user->avatar_path,
        ];

        $request->session()->put('userInfo', $userInfo);
    }
}
