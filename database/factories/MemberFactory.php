<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'member']),
            'name' => fake()->name('male'),
            'email' => fake()->unique()->safeEmail(),
            'subscription_ends_at' => fake()->dateTimeBetween('now', '+1 month'),
            'payment_status' => fake()->randomElement([0, 1]),
            'status' => 1,
        ];
    }
}
