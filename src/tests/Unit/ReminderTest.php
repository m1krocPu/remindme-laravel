<?php

namespace Tests\Unit;

use DateTime;
use App\Http\Resources\ReminderCollection;
use App\Http\Resources\ReminderResource;
use App\Models\Reminder;
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

    public function testReminderDetail(): void
    {
        $this->login();
        $reminder = Reminder::factory()->create();

        $reminderResponse = ReminderService::detailReminder($reminder->id);
        $this->assertInstanceOf(ReminderResource::class, $reminderResponse);

        $reminders = json_decode($reminderResponse->toResponse(app('request'))->content(), true);
        $this->assertArrayHasKey('id', $reminders);
        $this->assertArrayHasKey('title', $reminders);
        $this->assertArrayHasKey('description', $reminders);
        $this->assertArrayHasKey('remind_at', $reminders);
        $this->assertArrayHasKey('event_at', $reminders);

        $this->assertEquals($reminders['id'], $reminder->id);
        $this->assertEquals($reminders['title'], $reminder->title);
        $this->assertEquals($reminders['description'], $reminder->description);
        $this->assertEquals($reminders['remind_at'], $reminder->remind_at);
        $this->assertEquals($reminders['event_at'], $reminder->event_at);
    }
    public function testReminderUpdate(): void
    {
        $this->login();
        $reminder = Reminder::factory()->create();

        $payload = [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(1),
            'remind_at' => $this->faker->unixTime(new DateTime('+3 days')),
            'event_at' => $this->faker->unixTime(new DateTime('+3 days'))
        ];

        $reminderResponse = ReminderService::updateReminder($payload, $reminder->id);
        $this->assertInstanceOf(ReminderResource::class, $reminderResponse);

        $reminders = json_decode($reminderResponse->toResponse(app('request'))->content(), true);
        $this->assertArrayHasKey('id', $reminders);
        $this->assertArrayHasKey('title', $reminders);
        $this->assertArrayHasKey('description', $reminders);
        $this->assertArrayHasKey('remind_at', $reminders);
        $this->assertArrayHasKey('event_at', $reminders);

        $reminder->refresh();
        $this->assertDatabaseHas('reminders', $reminders);
        $this->assertEquals($payload['title'], $reminder->title);
        $this->assertEquals($payload['description'], $reminder->description);
        $this->assertEquals($payload['remind_at'], $reminder->remind_at);
        $this->assertEquals($payload['event_at'], $reminder->event_at);
    }
}
