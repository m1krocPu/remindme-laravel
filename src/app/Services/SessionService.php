<?php

namespace App\Services;

use Auth;
use Str;
use Carbon\Carbon;
use App\Dictionaries\ErrorDictionary;
use App\Http\Resources\SessionResource;
use App\Models\PersonalAccessToken;

class SessionService
{
    public static function createSession($credential)
    {
        if (Auth::attempt($credential)) {
            $user = Auth::user();
            $personalAccessToken = $user->tokens()->create([
                'name' => 'access-token',
                'token' => Str::uuid(),
                'refresh_token' => Str::uuid(),
                'expires_at' => Carbon::now()->addSeconds(config('session.lifetime'))
            ]);

            return new SessionResource($personalAccessToken);

        }

        throw new \Exception(ErrorDictionary::ERR_INVALID_CREDS);
    }

    public static function isValidToken($token)
    {
        $personalAccessToken = PersonalAccessToken::accessToken()
                ->where('token', $token)
                ->first();
        
        if ( !empty($personalAccessToken) ) {
            $isExpired = Carbon::now()->greaterThan($personalAccessToken->expires_at);

            return !$isExpired;
        }
        return false;
    }
}