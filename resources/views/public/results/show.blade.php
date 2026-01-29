@extends('layouts.app')

@section('title', 'Standings: ' . $voting->title)

@section('content')
<div class="bg-slate-50 min-h-screen py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="mb-12 text-center">
            <a href="{{ route('public.results.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to All Results
            </a>
            <h1 class="text-3xl font-extrabold text-slate-900">{{ $voting->title }} - Current Standings</h1>
            <p class="text-slate-500 mt-2">Live updates from our global voting platform.</p>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-4">Note: Judges' decisions are final</p>
        </div>

        <div class="space-y-6">
            @php $topScore = $results->first() ? $results->first()->total_votes : 0; @endphp
            @forelse($results as $index => $result)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex items-center p-6 transform hover:scale-[1.02] transition-transform duration-300">
                <div class="flex-shrink-0 mr-6">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl 
                        {{ $index == 0 ? 'bg-yellow-100 text-yellow-700' : ($index == 1 ? 'bg-slate-100 text-slate-700' : ($index == 2 ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-400')) }}">
                        {{ $index + 1 }}
                    </div>
                </div>
                
                <div class="flex-shrink-0 mr-6">
                    @if($result->contestant->image)
                        <img src="{{ $result->contestant->image }}" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-100">
                    @else
                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="flex-grow">
                    <h3 class="text-lg font-bold text-slate-900">{{ $result->contestant->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $result->contestant->region->name ?? 'Global' }}</p>
                    
                    <div class="mt-3 w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-indigo-600 h-full transition-all duration-1000" style="width: {{ $topScore > 0 ? ($result->total_votes / $topScore) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="ml-6 text-right">
                    <span class="text-2xl font-black text-slate-900">{{ $result->total_votes }}</span>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Votes</p>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-slate-100">
                <p class="text-slate-500">No votes recorded yet for this round.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-12 text-center p-8 bg-indigo-600 rounded-2xl shadow-xl text-white">
            <h3 class="text-xl font-bold mb-2">Want to support your favorite?</h3>
            <p class="text-indigo-100 mb-6">Become a member today and cast your vote!</p>
            <a href="{{ route('google-login') }}" class="inline-block bg-white text-indigo-600 px-8 py-3 rounded-xl font-bold hover:bg-slate-50 transition-colors">
                Register to Vote
            </a>
        </div>
    </div>
</div>
@endsection
