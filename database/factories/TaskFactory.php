<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::all()->random();
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(5),
            'published_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            // 'user_id' => $this->faker->numberBetween(1, 10),
            'user_id' => $user->id,
        ];
    }
}
