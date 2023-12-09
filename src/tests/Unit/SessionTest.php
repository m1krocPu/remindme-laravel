<?php

namespace Tests\Unit;

use Str;
use Carbon\Carbon;
use App\Dictionaries\ErrorDictionary;
use App\Http\Resources\SessionResource;
use App\Services\SessionService;
use Tests\TestCase;
use App\Models\PersonalAccessToken;

class SessionTest extends TestCase
{
    public function testCreateSessionSuccess(): void
    {
        $credentials = [
            'email' => 'alice@mail.com',
            'password' => '123456'
        ];
        
        $sessionResponse = SessionService::createSession($credentials);
        $this->assertInstanceOf(SessionResource::class, $sessionResponse);

        $session = json_decode($sessionResponse->toResponse(app('request'))->content(), true);
        $this->assertArrayHasKey('user', $session);
        $this->assertArrayHasKey('id', $session['user']);
        $this->assertArrayHasKey('email', $session['user']);
        $this->assertArrayHasKey('name', $session['user']);
        $this->assertArrayHasKey('access_token', $session);
        $this->assertArrayHasKey('refresh_token', $session);
    }

    public function testCreateSessionWhenException(): void
    {
        $credentials = [
            'email' => 'alice@mail.com',
            'password' => '123'
        ];
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(ErrorDictionary::ERR_INVALID_CREDS);
        SessionService::createSession($credentials);
    }

    public function testValidateTokenSuccess(): void
    {
        $credentials = [
            'email' => 'alice@mail.com',
            'password' => '123456'
        ];

        $sessionResponse = SessionService::createSession($credentials);

        $session = $sessionResponse->toResponse(app('request'))->getData();
        $isValid = SessionService::isValidToken($session->access_token);

        $this->assertTrue($isValid);
    }

    public function testValidateTokenNotFound(): void
    {
        $isValid = SessionService::isValidToken(Str::uuid());

        $this->assertFalse($isValid);
    }

    public function testValidateTokenExpired(): void
    {
        $credentials = [
            'email' => 'alice@mail.com',
            'password' => '123456'
        ];

        $sessionResponse = SessionService::createSession($credentials);
        $user = $sessionResponse->resource->tokenable;
        $personalAccessToken = $user->tokens()->create([
            'name' => 'access-token',
            'token' => Str::uuid(),
            'refresh_token' => Str::uuid(),
            'expires_at' => Carbon::now()->subSecond()
        ]);

        $isValid = SessionService::isValidToken($personalAccessToken->token);

        $this->assertFalse($isValid);
    }
}
