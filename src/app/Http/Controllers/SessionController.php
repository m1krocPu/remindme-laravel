<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SessionController extends Controller
{
    public function createSession(SessionRequest $request)
    {
        try {
            $credential = $request->only('email', 'password');
            $session = SessionService::createSession($credential);
    
            return Response::success($session);

        } catch(\Exception $e) {
            return Response::error($e->getMessage());
        }
    }

    public function refreshSession(Request $request)
    {
        try {
            $refreshToken = $request->bearerToken();
            $session = SessionService::refreshSession($refreshToken);
    
            return Response::success($session);

        } catch(\Exception $e) {
            return Response::error($e->getMessage());
        }
    }
}
