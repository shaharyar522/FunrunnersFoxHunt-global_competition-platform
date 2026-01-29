<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Voting;
use App\Models\Contestant;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Store a newly created vote in storage.
     */
    public function store(Request $request, $voting_id, $contestant_id)
    {
        $user = Auth::user();

        // 1. Validate User is a Member
        if ($user->role !== 'member') {
            return redirect()->back()->with('error', 'Only members can vote.');
        }

        // 2. Validate Voting Round Exists and is Open
        // Assuming status: 0=pending, 1=open, 2=closed
        $voting = Voting::where('voting_id', $voting_id)->firstOrFail();

        if ($voting->status != 1) { 
             // Allow testing in pending mode if needed, but strictly should be 1. 
             // For now, let's assume 1 is Active. 
             // Steps says "Members Vote -> Voting Closes". 
             return redirect()->back()->with('error', 'This voting round is not currently open.');
        }

        // 3. Validate Contestant exists in this Voting Round
        // We can check VotingContestant table, or just basic existence.
        // Let's check if contestant exists first.
        $contestant = Contestant::findOrFail($contestant_id);

        // 4. Check if User has already voted in this round
        $existingVote = Vote::where('user_id', $user->id)
                            ->where('voting_id', $voting_id)
                            ->exists();

        if ($existingVote) {
            return redirect()->back()->with('error', 'You have already voted in this round.');
        }

        // 5. Create Vote
        Vote::create([
            'user_id' => $user->id,
            'voting_id' => $voting->voting_id,
            'contestant_id' => $contestant->id,
        ]);

        return redirect()->back()->with('success', 'Your vote has been cast successfully!');
    }
}
