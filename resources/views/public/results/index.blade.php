@extends('layouts.app')

@section('title', 'Live Results - Funrunners')

@section('content')
<div class="bg-gradient-to-br from-slate-900 to-indigo-900 py-20 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">Live Voting Results</h1>
        <p class="text-indigo-200 text-lg max-w-2xl mx-auto">Stay updated with the latest scores from around the globe. Transparency is our priority.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 mb-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($activeRounds as $round)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100 transform hover:-translate-y-2 transition-all duration-300">
            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div class="p-3 bg-indigo-50 rounded-xl">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 uppercase tracking-wider">Live</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $round->title }}</h3>
                <p class="text-slate-500 text-sm mb-6 font-medium">Voting Ends: {{ $round->votingdate }}</p>
                
                <a href="{{ route('public.results.show', $round->voting_id) }}" class="block w-full text-center py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition-colors shadow-lg">
                    View Standings
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl p-12 text-center shadow-sm border border-slate-100">
            <p class="text-slate-500 text-lg">No active voting rounds at the moment.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
