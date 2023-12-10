<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Models\PersonalAccessToken;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SessionAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            throw new HttpException(401);
        }

        if (!SessionService::isValidToken($token)) {
            throw new HttpException(401);
        }


        Auth::loginUsingId(PersonalAccessToken::where('token',$token)->pluck('tokenable_id'));
        return $next($request);
    }
}
