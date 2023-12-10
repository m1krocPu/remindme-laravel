<?php

namespace Tests\Unit;

use Str;
use Carbon\Carbon;
use App\Dictionaries\ErrorDictionary;
use App\Http\Resources\SessionResource;
use App\Services\SessionService;
use Tests\TestCase;
use App\Models\PersonalAccessToken;

class RefreshSessionTest extends TestCase
{
    
    public function testRefreshSessionSuccess(): void
    {
        $credentials = [
            'email' => 'alice@mail.com',
            'password' => '123456'
        ];
        $sessionResponse = SessionService::createSession($credentials);

        $refreshToken = $sessionResponse->resource->refresh_token;
        $refreshSession = SessionService::refreshSession($refreshToken);

        $this->assertArrayHasKey('access_token', $refreshSession);
    }
    
    public function testRefreshSessionFailed(): void
    {
        $refreshToken = Str::uuid();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(ErrorDictionary::ERR_INVALID_REFRESH_TOKEN);
        SessionService::refreshSession($refreshToken);
    }
}
