<?php

namespace Database\Seeders;

use App\Models\Contestant;
use App\Models\Member;
use App\Models\Region;
use App\Models\User;
use App\Models\Voting;
use App\Models\VotingContestant;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProjectDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::updateOrCreate(
            ['email' => 'admin@funrunners.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Create Regions
        $regions = Region::factory()->count(10)->create();

        // 3. Create Contestants
        $contestants = Contestant::factory()->count(50)->recycle($regions)->create();

        // 4. Create Members
        $members = Member::factory()->count(100)->create();

        // 5. Create Votings (Rounds)
        $votings = Voting::factory()->count(5)->recycle($regions)->create();

        // 6. Assign Contestants to Voting Rounds
        foreach ($votings as $voting) {
            // Pick random contestants from the same region for regional rounds
            $regionalContestants = $contestants->where('region_id', $voting->region_id)->take(10);
            
            if ($regionalContestants->isEmpty()) {
                $regionalContestants = $contestants->random(10);
            }

            foreach ($regionalContestants as $contestant) {
                VotingContestant::create([
                    'voting_id' => $voting->voting_id,
                    'contestant_id' => $contestant->id,
                    'status' => 1,
                    'payments' => rand(5, 50),
                ]);
            }

            // 7. Add Votes for Active Rounds
            if ($voting->status == 1) { // Active
                $activeVotingContestants = VotingContestant::where('voting_id', $voting->voting_id)->get();
                
                foreach ($members->random(50) as $member) {
                    $contestantToVote = $activeVotingContestants->random();
                    
                    Vote::create([
                        'user_id' => $member->user_id,
                        'voting_id' => $voting->voting_id,
                        'contestant_id' => $contestantToVote->contestant_id,
                    ]);
                }
            }
        }
    }
}
