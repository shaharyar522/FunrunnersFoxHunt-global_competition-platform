<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicResultsController extends Controller
{
    public function index()
    {
        $activeRounds = Voting::where('status', 1)->get();
        return view('public.results.index', compact('activeRounds'));
    }

    public function show($id)
    {
        $voting = Voting::findOrFail($id);
        
        // Only show results if public requirement is met (status Open or Closed)
        if ($voting->status == 0) {
            abort(403, 'This round is not public yet.');
        }

        $results = Vote::where('voting_id', $id)
            ->select('contestant_id', DB::raw('count(*) as total_votes'))
            ->groupBy('contestant_id')
            ->orderByDesc('total_votes')
            ->with(['contestant']) 
            ->get();

        return view('public.results.show', compact('voting', 'results'));
    }
}
