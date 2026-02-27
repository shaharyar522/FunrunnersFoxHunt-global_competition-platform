<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voting>
 */
class VotingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true) . ' Competition',
            'region_id' => Region::factory(),
            'creationdate' => now()->toDateString(),
            'status' => fake()->randomElement([0, 1, 2]), // 0=pending, 1=active, 2=closed
        ];
    }
}
