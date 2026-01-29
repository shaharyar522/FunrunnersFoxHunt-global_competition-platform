<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function dashboard()
    {
        $member = Member::where('user_id', Auth::id())->first();
        // Fetch active voting rounds (status 1 = open, 0 = pending for now)
        // Adjust status logic based on requirements. "Open Voting" -> status 1.
        $activeRounds = \App\Models\Voting::where('status', 1)->get(); 

        return view('member.dashboard', compact('member', 'activeRounds'));
    }

    public function showVotingRound($voting_id)
    {
        $voting = \App\Models\Voting::with(['votingContestants.contestant.questions' => function($q) {
            $q->where('is_answered', true)->with('member')->orderBy('created_at', 'desc');
        }])->findOrFail($voting_id);
        
        // Check if user has already voted
        $userVote = \App\Models\Vote::where('user_id', Auth::id())
                                    ->where('voting_id', $voting_id)
                                    ->first();
        
        $votedContestantId = $userVote ? $userVote->contestant_id : null;

        return view('member.contestants.index', compact('voting', 'votedContestantId'));
    }

    public function liveResults($voting_id)
    {
        $voting = \App\Models\Voting::findOrFail($voting_id);

        // Get updated vote counts
        // Need to group by contestant_id and count
        $results = \App\Models\Vote::where('voting_id', $voting_id)
            ->select('contestant_id', \Illuminate\Support\Facades\DB::raw('count(*) as total_votes'))
            ->groupBy('contestant_id')
            ->orderByDesc('total_votes')
            ->with(['contestant']) 
            ->get();
            
        return view('member.results.index', compact('voting', 'results'));
    }
}
