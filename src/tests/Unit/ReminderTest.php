<?php

namespace Tests\Unit;

use App\Http\Resources\ReminderCollection;
use App\Services\ReminderService;
use App\Services\SessionService;
use Tests\TestCase;

class ReminderTest extends TestCase
{
    private function login() {
        $credentials = [
            'email' => 'alice@mail.com',
            'password' => '123456'
        ];
        
        return SessionService::createSession($credentials);
    }

    public function testReminderList(): void
    {
        $this->login();
        $limit = 8;

        $reminderResponse = ReminderService::getReminderList($limit);
        $this->assertInstanceOf(ReminderCollection::class, $reminderResponse);

        $reminders = json_decode($reminderResponse->toResponse(app('request'))->content(), true);
        $this->assertArrayHasKey('reminders', $reminders);
        $this->assertArrayHasKey('limit', $reminders);
    }
}
