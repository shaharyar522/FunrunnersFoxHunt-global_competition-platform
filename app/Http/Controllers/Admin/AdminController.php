<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Voting;
use App\Models\VotingContestant;
use App\Models\Member;
use App\Models\Contestant;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
            Auth::logout();
            return back()->with('error', 'You do not have admin access.');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function votingList()
    {
        $votings = Voting::orderBy('created_at', 'desc')->get();
        return view('admin.voting.list', compact('votings'));
    }

    public function votingDetail($id)
    {
        
        $voting = Voting::with('contestants.contestant')->findOrFail($id);
        return view('admin.voting.detail', compact('voting'));

    }

    public function updateContestantStatus(Request $request, $id)
    {

        $vc = VotingContestant::findOrFail($id);
        $vc->status = $request->status;
        $vc->save();

        return back()->with('success', 'Status updated successfully.');

    }

    public function membersList()
    {

        $members = Member::all();
        return view('admin.members.list', compact('members'));

    }

    public function contestantsList()
    {
        $contestants = Contestant::with('region')->get();
        $regions = \App\Models\Region::all(); // Needed for the edit modal
        return view('admin.contestants.list', compact('contestants', 'regions'));
    }

    public function getContestant($id)
    {
        $contestant = Contestant::findOrFail($id);
        return response()->json($contestant);
    }

    public function updateContestant(Request $request, $id)
    {
        $contestant = Contestant::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:20',
            'region_id' => 'required|exists:regions,id',
            'dob' => 'nullable|date',
            'profile_status' => 'required|in:0,1',
        ]);

        $contestant->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Contestant profile updated successfully'
        ]);
    }

    public function toggleContestantStatus(Request $request, $id)
    {
        $contestant = Contestant::findOrFail($id);
        $contestant->status = $request->input('status');
        $contestant->save();

        return response()->json([
            'success' => true,
            'status' => $contestant->status,
            'message' => 'Status updated successfully'
        ]);
    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');

    }
}
