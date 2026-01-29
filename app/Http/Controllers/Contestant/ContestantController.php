<?php

namespace App\Http\Controllers\Contestant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contestant;
use Illuminate\Support\Facades\Auth;

class ContestantController extends Controller
{
    public function dashboard()
    {
        $contestant = Contestant::where('user_id', Auth::id())->first();
        return view('contestant.dashboard', compact('contestant'));
    }
}
