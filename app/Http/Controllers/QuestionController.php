<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Contestant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Store a new question from a member.
     */
    public function store(Request $request, Contestant $contestant)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
        ]);

        Question::create([
            'user_id' => Auth::id(),
            'contestant_id' => $contestant->id,
            'question' => $request->question,
        ]);

        return back()->with('success', 'Your question has been sent to the contestant!');
    }

    /**
     * Contestant: List questions for them.
     */
    public function contestantIndex()
    {
        $contestant = Contestant::where('user_id', Auth::id())->firstOrFail();
        $questions = Question::where('contestant_id', $contestant->id)
            ->with('member')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('contestant.questions.index', compact('questions'));
    }

    /**
     * Contestant: Answer a question.
     */
    public function answer(Request $request, Question $question)
    {
        $contestant = Contestant::where('user_id', Auth::id())->firstOrFail();
        
        if ($question->contestant_id !== $contestant->id) {
            abort(403);
        }

        $request->validate([
            'answer' => 'required|string|max:2000',
        ]);

        $question->update([
            'answer' => $request->answer,
            'is_answered' => true,
        ]);

        return back()->with('success', 'Your answer has been posted!');
    }
}
