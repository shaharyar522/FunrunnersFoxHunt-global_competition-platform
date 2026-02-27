<?php

namespace Database\Factories;

use App\Models\Contestant;
use App\Models\Voting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VotingContestant>
 */
class VotingContestantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'voting_id' => Voting::factory(),
            'contestant_id' => Contestant::factory(),
            'status' => 1,
            'payments' => fake()->randomFloat(2, 0, 100),
        ];
    }
}
