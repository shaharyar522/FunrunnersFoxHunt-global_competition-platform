@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
    <div class="min-h-screen bg-slate-50">

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Title -->
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Member Dashboard</h1>
                    <p class="text-slate-500 mt-2 font-medium">Welcome back, {{ Auth::user()->name }}! Manage your votes and view live results.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Active Voting Rounds -->
                    <section>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-slate-900 flex items-center">
                                <span class="w-2 h-6 bg-indigo-600 rounded-full mr-3"></span>
                                Active Voting Rounds
                            </h2>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider shadow-sm">Global Sync</span>
                        </div>

                        @if (isset($activeRounds) && $activeRounds->count() > 0)
                            <div class="grid grid-cols-1 gap-5">
                                @foreach ($activeRounds as $round)
                                    <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 group">
                                        <div class="flex flex-col md:flex-row justify-between md:items-center space-y-4 md:space-y-0">
                                            <div>
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full uppercase tracking-widest border border-indigo-100">
                                                        {{ $round->region ? $round->region->name : 'Global' }} Round
                                                    </span>
                                                    <span class="text-xs text-slate-300">•</span>
                                                    <span class="text-xs text-slate-500 font-bold flex items-center">
                                                        <svg class="w-3 h-3 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        Ends Soon
                                                    </span>
                                                </div>
                                                <h3 class="text-2xl font-black text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $round->title }}</h3>
                                                <p class="text-sm text-slate-500 mt-1 font-medium">Regional representatives competing for the global title.</p>
                                            </div>
                                            <div class="flex space-x-3">
                                                <a href="{{ route('member.results.show', $round->voting_id) }}" class="px-5 py-2.5 text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 border-2 border-slate-200 hover:border-slate-300 rounded-xl transition-all shadow-sm">
                                                    Leaderboard
                                                </a>
                                                <a href="{{ route('member.voting.show', $round->voting_id) }}" class="px-5 py-2.5 text-sm font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                                    Vote Now
                                                </a>
                                            </div>
                                        </div>
                                        <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                                            <span class="flex items-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200">
                                                <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg> 
                                                Started: {{ \Carbon\Carbon::parse($round->creationdate)->format('M d, Y') }}
                                            </span>
                                            <span class="flex items-center text-slate-400">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Publicly Visible
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white border-2 border-dashed border-slate-200 rounded-3xl p-16 text-center shadow-sm">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4 border border-slate-100">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 mb-2">No Active Rounds</h3>
                                <p class="text-slate-500 font-medium">There are currently no active competition rounds.</p>
                                <p class="text-slate-400 text-sm mt-1">Please wait for the administrator to announce the next phase.</p>
                            </div>
                        @endif
                    </section>
                </div>

                <!-- Right Column: Stats & Meta -->
                <div class="space-y-6">
                    <!-- Membership Status Card -->
                    <div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-3xl p-8 shadow-xl text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 opacity-10">
                            <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                        </div>
                        
                        <div class="relative z-10">
                            <h3 class="text-indigo-200 font-bold uppercase tracking-widest text-xs mb-6">Membership Status</h3>
                            
                            <div class="flex items-end justify-between mb-8">
                                <div>
                                    <p class="text-3xl font-black">Active</p>
                                    <p class="text-indigo-300 text-sm mt-1 font-medium">Monthly Voter Plan</p>
                                </div>
                                <div class="bg-indigo-500/30 border border-indigo-400/30 p-2.5 rounded-xl backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            
                            <div class="bg-indigo-950/50 rounded-2xl p-4 border border-indigo-800/50 backdrop-blur-md">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-indigo-300 font-medium tracking-wide">Valid Until</span>
                                    <span class="font-bold text-white tracking-widest">{{ isset($member) && $member->subscription_ends_at ? \Carbon\Carbon::parse($member->subscription_ends_at)->format('d M, Y') : 'N/A' }}</span>
                                </div>
                                <div class="mt-3 w-full bg-indigo-900 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-indigo-400 h-1.5 rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Competition Rules Summary -->
                    <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
                        <h3 class="text-slate-900 font-extrabold mb-5 text-lg">Voting Rules</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-50 flex items-center justify-center border border-indigo-100 mt-0.5">
                                    <span class="text-indigo-600 text-xs font-bold">1</span>
                                </div>
                                <p class="ml-3 text-sm text-slate-600 font-medium leading-relaxed">One vote per member per round.</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-50 flex items-center justify-center border border-indigo-100 mt-0.5">
                                    <span class="text-indigo-600 text-xs font-bold">2</span>
                                </div>
                                <p class="ml-3 text-sm text-slate-600 font-medium leading-relaxed">Votes are final once cast and cannot be changed.</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-50 flex items-center justify-center border border-indigo-100 mt-0.5">
                                    <span class="text-indigo-600 text-xs font-bold">3</span>
                                </div>
                                <p class="ml-3 text-sm text-slate-600 font-medium leading-relaxed">Regional winners advance to global finals.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        body {
            background-color: #f8fafc;
            color: #1e293b;
        }
    </style>
@endsection
