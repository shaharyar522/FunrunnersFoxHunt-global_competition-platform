@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <a href="{{ route('member.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center mb-2 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900">Live Results: {{ $voting->title }}</h1>
                <p class="mt-2 text-slate-600">Real-time vote counts. Judges' decisions are final.</p>
            </div>
            
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
            @if($results->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-indigo-50 text-indigo-900 border-b border-indigo-100">
                        <tr>
                            <th class="px-6 py-5 font-bold uppercase text-xs tracking-wider">Rank</th>
                            <th class="px-6 py-5 font-bold uppercase text-xs tracking-wider">Contestant</th>
                            <th class="px-6 py-5 font-bold uppercase text-xs tracking-wider hidden sm:table-cell">Region</th>
                            <th class="px-6 py-5 font-bold uppercase text-xs tracking-wider text-center">Total Votes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($results as $index => $result)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 font-black {{ $index == 0 ? 'text-yellow-500 text-2xl' : ($index == 1 ? 'text-slate-400 text-xl' : ($index == 2 ? 'text-amber-700 text-lg' : 'text-slate-400')) }}">
                                #{{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 flex-shrink-0 relative">
                                        <img class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm group-hover:scale-110 transition-transform duration-300" 
                                             src="{{ $result->contestant->image ?? 'https://ui-avatars.com/api/?name='.urlencode($result->contestant->name) }}" 
                                             alt="">
                                        @if($index == 0)
                                            <div class="absolute -top-1 -right-1 bg-yellow-400 rounded-full p-0.5 border border-white">
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-slate-900">{{ $result->contestant->name }}</div>
                                        <div class="text-xs text-slate-500 sm:hidden">{{ $result->contestant->region->name ?? 'Unknown' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 hidden sm:table-cell">
                                <span class="px-2 py-1 bg-slate-100 rounded-full text-xs font-semibold text-slate-600">
                                    {{ $result->contestant->region->name ?? 'Unknown Region' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-indigo-100 text-indigo-700">
                                    {{ $result->total_votes }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-slate-900">No votes yet</h3>
                <p class="mt-1 text-sm text-slate-500">Be the first to cast a vote!</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
