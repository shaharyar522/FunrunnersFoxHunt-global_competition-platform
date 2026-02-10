<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voting;
use App\Models\VotingContestant;
use App\Models\Vote;
use App\Models\Region;
use App\Models\Contestant;
use Carbon\Carbon;


class VotingController extends Controller
{
    public function index()
    {
        $votings = Voting::orderBy('creationdate', 'desc')->get();
        $regions = Region::all();
        return view('admin.voting.list', compact('votings', 'regions'));
    }


    public function changeStatus($id)
    {

        $voting = Voting::findOrFail($id);

        // 0=pending, 1=open, 2=close
        if ($voting->status == 0) {
            $voting->status = 1; // Pending → Open
        } elseif ($voting->status == 1) {
            $voting->status = 2; // Open → Closed
            // Note: Requirements say "Votes Deleted after round ends".
            // We could automate it here, but it's safer to keep as a separate action for admin to check results first.
        } else {
            $voting->status = 0; // Closed → Pending
        }

        $voting->save();

        return back()->with('success', 'Voting status updated to ' . ($voting->status == 1 ? 'Open' : ($voting->status == 2 ? 'Closed' : 'Pending')));
    }




    // Show Add Voting Form
    public function create()
    {
        $regions = Region::all();
        return view('admin.voting.create', compact('regions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'creationdate' => 'nullable|date',
            'status' => 'required|integer|in:0,1,2',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        $voting = Voting::create([
            'title' => $request->title,
            'region_id' => $request->region_id,
            'creationdate' => $request->creationdate ?? now()->toDateString(),
            'status' => $request->status,
        ]);

        // AUTOMATIC ADDITION: If a region is selected, add all approved contestants
        if ($request->region_id) {
            $contestants = Contestant::where('region_id', $request->region_id)
                ->where('status', 1) // Approved
                ->get();

            foreach ($contestants as $contestant) {
                VotingContestant::create([
                    'voting_id' => $voting->voting_id,
                    'contestant_id' => $contestant->id,
                    'status' => 1, // Active in round
                    'payments' => 0
                ]);
            }
        }

        return redirect()->route('admin.voting.list')
            ->with('success', 'Voting round added successfully' . ($request->region_id ? ' with ' . $contestants->count() . ' contestants.' : '.'));
    }

    // ============ detials show model =========================================
    // public function detail($id)
    // {
    //     // Get voting with contestants
    //     $voting = Voting::with(['votingContestants' => function ($q) {
    //         $q->with('contestant');
    //     }])->findOrFail($id);

    //     // Load vote counts manually for monitoring
    //     foreach ($voting->votingContestants as $vc) {
    //         $vc->vote_count = Vote::where('voting_id', $id)
    //             ->where('contestant_id', $vc->contestant_id)
    //             ->count();
    //     }

    //     // Get other open/pending rounds for promotion
    //     $otherRounds = Voting::where('voting_id', '!=', $id)->whereIn('status', [0, 1])->get();

    //     // Return HTML for AJAX modal
    //     if (request()->ajax()) {
    //         return view('admin.voting.detail', compact('voting', 'otherRounds'))->render();
    //     }

    //     // fallback
    //     return view('admin.voting.detail', compact('voting', 'otherRounds'));
    // }



    public function getVotingDetailsModal($id)
    {
        // Eager loading: Voting ke sath unke contestants aur contestant info (Name, Image) fetch karna
        $voting = Voting::with(['votingContestants.contestant'])->findOrFail($id);

        return response()->json([
            'title' => $voting->title,
            'contestants' => $voting->votingContestants->map(function ($vc) {
                return [
                    'id' => $vc->id, // voting_contestants ki ID
                    'name' => $vc->contestant->name,
                    'image' => $vc->contestant->image
                        ? asset('storage/' . $vc->contestant->image)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($vc->contestant->name),
                    'status' => $vc->status, // 1=Active, 0=Blocked
                ];
            })
        ]);
    }
    
    //  2. Button click hone par status toggle (flip) karna
    public function toggleContestantStatusModal($id)
    {
        $vc = VotingContestant::findOrFail($id);
        
        // Toggle: 1 (Active) -> 0 (Blocked) or vice versa
        $vc->status = ($vc->status == 1) ? 0 : 1;
        $vc->save();

        return response()->json([
            'success' => true, 
            'new_status' => $vc->status
        ]);
    }

    // Toggle contestant status
    public function toggleContestantStatus($id)
    {
        $vc = VotingContestant::findOrFail($id);
        $vc->status = $vc->status == 1 ? 0 : 1; // toggle
        $vc->save();

        return response()->json([
            'success' => true,
            'status' => $vc->status
        ]);
    }

    // Delete All Votes for a Round
    public function destroyVotes($id)
    {
        $voting = Voting::findOrFail($id);

        // Delete dependent votes
        Vote::where('voting_id', $id)->delete();

        return back()->with('success', 'All votes for this round have been deleted.');
    }

    /**
     * Promote a contestant to another voting round (e.g., Global Finals)
     */
    public function promoteContestant(Request $request)
    {
        $request->validate([
            'contestant_id' => 'required|exists:contestants,id',
            'target_voting_id' => 'required|exists:votings,voting_id',
        ]);

        // Check if already in the target round
        $exists = VotingContestant::where('voting_id', $request->target_voting_id)
            ->where('contestant_id', $request->contestant_id)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Contestant is already in that round.']);
        }

        VotingContestant::create([
            'voting_id' => $request->target_voting_id,
            'contestant_id' => $request->contestant_id,
            'status' => 1, // Active by default in the new round
            'payments' => 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Contestant promoted successfully!']);
    }

    /**
     * Export voting results to CSV
     */
    public function exportResults($id)
    {
        $voting = Voting::findOrFail($id);
        $results = Vote::where('voting_id', $id)
            ->select('contestant_id', \Illuminate\Support\Facades\DB::raw('count(*) as total_votes'))
            ->groupBy('contestant_id')
            ->orderByDesc('total_votes')
            ->with(['contestant'])
            ->get();

        $filename = "voting_results_" . str_replace(' ', '_', strtolower($voting->title)) . ".csv";
        $handle = fopen('php://memory', 'w');

        // CSV Header
        fputcsv($handle, ['Rank', 'Contestant Name', 'Email', 'Region', 'Total Votes']);

        foreach ($results as $index => $result) {
            fputcsv($handle, [
                $index + 1,
                $result->contestant->name,
                $result->contestant->email,
                $result->contestant->region->name ?? 'N/A',
                $result->total_votes
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
