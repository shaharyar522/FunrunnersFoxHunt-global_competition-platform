<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use App\Models\Voting;
use App\Models\Contestant;
use App\Models\Member;
use App\Models\User;
use App\Models\VotingContestant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------------
        // 1. Contestants & Users
        // -----------------------------
        $regionNames = ['North America', 'South America', 'Europe', 'Africa', 'Asia', 'Oceania'];
        $regionIds = [];

        foreach ($regionNames as $regionName) {
            $region = Region::firstOrCreate(['name' => $regionName]);
            $regionIds[] = $region->id;
        }

        for ($i = 1; $i <= 6; $i++) {
            $user = User::create([
                'name' => 'Contestant ' . $i,
                'email' => 'contestant' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'contestant',
            ]);

            Contestant::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'region_id' => $regionIds[$i - 1],
                'image' => 'https://i.pravatar.cc/300?img=' . $i, // placeholder image
                'payment_status' => rand(0, 1), // random paid or not paid
                'status' => 1, // active
            ]);
        }

        // -----------------------------
        // 2. Members & Users
        // -----------------------------
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'Member ' . $i,
                'email' => 'member' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]);

            Member::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'payment_status' => rand(0, 1),
                'status' => 1,
            ]);
        }

        // -----------------------------
        // 3. Voting Round
        // -----------------------------
        $voting1 = Voting::create([
            'creationdate' => Carbon::now()->toDateString(),
            'title' => 'Miss North America – Round 1',
            'status' => 0, // Pending
        ]);

        $voting2 = Voting::create([
            'title' => 'Miss Europe – Round 1',
            'creationdate' => Carbon::now()->toDateString(),
            'status' => 0,
        ]);

        // -----------------------------
        // 4. Voting Contestants (assign contestants to votings)
        // -----------------------------
        $contestants = Contestant::all();

        // Voting 1
        foreach ($contestants->take(4) as $contestant) {
            VotingContestant::create([
                'voting_id' => $voting1->voting_id,
                'contestant_id' => $contestant->id,
                'payments' => rand(0, 100), // random payment amount
                'status' => 1, // active in voting
            ]);
        }

        // Voting 2
        foreach ($contestants->slice(3, 4) as $contestant) {
            VotingContestant::create([
                'voting_id' => $voting2->voting_id,
                'contestant_id' => $contestant->id,
                'payments' => rand(0, 100),
                'status' => 1,
            ]);
        }
    }
}
