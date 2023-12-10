<?php

namespace Tests\Unit;

use DateTime;
use App\Http\Resources\ReminderCollection;
use App\Http\Resources\ReminderResource;
use App\Services\ReminderService;
use App\Services\SessionService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReminderTest extends TestCase
{
    use WithFaker;

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

    public function testReminderCreate(): void
    {
        $this->login();
        $payload = [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(1),
            'remind_at' => $this->faker->unixTime(new DateTime('+3 days')),
            'event_at' => $this->faker->unixTime(new DateTime('+3 days'))
        ];

        $reminderResponse = ReminderService::createReminder($payload);
        $this->assertInstanceOf(ReminderResource::class, $reminderResponse);

        $reminders = json_decode($reminderResponse->toResponse(app('request'))->content(), true);
        $this->assertArrayHasKey('id', $reminders);
        $this->assertArrayHasKey('title', $reminders);
        $this->assertArrayHasKey('description', $reminders);
        $this->assertArrayHasKey('remind_at', $reminders);
        $this->assertArrayHasKey('event_at', $reminders);

        $this->assertDatabaseHas('reminders', $reminders);
    }
}
