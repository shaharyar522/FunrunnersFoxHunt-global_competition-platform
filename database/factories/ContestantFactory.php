<?php

namespace Database\Factories;

use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contestant>
 */
class ContestantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'contestant']),
            'name' => fake()->name('female'),
            'image' => 'https://i.pravatar.cc/300?img=' . fake()->numberBetween(1, 70),
            'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
            'contact' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'region_id' => Region::factory(),
            'bio' => fake()->paragraph(),
            'payment_status' => fake()->randomElement([0, 1]),
            'profile_status' => 1,
            'status' => 1,
        ];
    }
}
