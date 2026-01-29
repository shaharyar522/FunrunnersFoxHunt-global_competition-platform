@extends('layouts.app')

@section('title', 'Questions for Me')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Questions from Members</h1>
            <a href="{{ route('contestant.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">← Back to Dashboard</a>
        </div>

        @if(session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="space-y-6">
            @forelse($questions as $question)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold mr-3">
                                {{ strtoupper(substr($question->member->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $question->member->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $question->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($question->is_answered)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Answered</span>
                        @else
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4 italic text-gray-700 border-l-4 border-gray-200">
                        "{{ $question->question }}"
                    </div>

                    @if($question->is_answered)
                    <div class="mt-4">
                        <h5 class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">My Answer:</h5>
                        <p class="text-gray-800">{{ $question->answer }}</p>
                    </div>
                    @else
                    <form action="{{ route('contestant.questions.answer', $question) }}" method="POST">
                        @csrf
                        <textarea name="answer" rows="3" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder-gray-400"
                                  placeholder="Write your answer here..."></textarea>
                        <div class="mt-3 flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm font-medium">
                                Post Answer
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No questions yet</h3>
                <p class="mt-1 text-sm text-gray-500">When members ask you questions, they will appear here.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
