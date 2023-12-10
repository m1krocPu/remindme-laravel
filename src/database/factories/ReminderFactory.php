<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reminder>
 */
class ReminderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>1,
            'title' => fake()->sentence(2),
            'description' => fake()->paragraph(1),
            'remind_at' => fake()->unixTime(new DateTime('+3 days')),
            'event_at' => fake()->unixTime(new DateTime('+3 days'))
        ];
    }
}
