@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
<div class="min-h-screen bg-slate-50">
    <!-- Main Navbar/Header -->
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Member Dashboard</h1>
                <!-- <p class="text-slate-500 text-sm">Manage your votes and view live competition results.</p> -->
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500">Premium Member</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Main Content -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Active Voting Rounds -->
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center">
                            <span class="w-2 h-6 bg-indigo-600 rounded-full mr-3"></span>
                            Active Voting Rounds
                        </h2>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded uppercase">Global Sync</span>
                    </div>

                    @if(isset($activeRounds) && $activeRounds->count() > 0)
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($activeRounds as $round)
                                <div class="bg-white border border-slate-200 rounded-xl p-6 hover:shadow-sm transition-shadow">
                                    <div class="flex flex-col md:flex-row justify-between md:items-center space-y-4 md:space-y-0">
                                        <div>
                                            <div class="flex items-center space-x-2 mb-1">
                                                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded uppercase tracking-wider">
                                                    {{ $round->type ?? 'Regional' }} Round
                                                </span>
                                                <span class="text-xs text-slate-400">•</span>
                                                <span class="text-xs text-slate-500 font-medium">Ends in: 12h 45m 30s</span>
                                            </div>
                                            <h3 class="text-xl font-bold text-slate-900">{{ $round->title }}</h3>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('member.results.show', $round->voting_id) }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50 border border-slate-200 rounded-lg transition">
                                                Leaderboard
                                            </a>
                                            <a href="{{ route('member.voting.show', $round->voting_id) }}" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition">
                                                Vote Now
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between text-xs text-slate-500">
                                        <span class="flex items-center"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg> Global Start: {{ $round->creationdate }}</span>
                                        <span>Results are publicly visible</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white border-2 border-dashed border-slate-200 rounded-xl p-12 text-center">
                            <p class="text-slate-400 font-medium">No competition rounds are currently active.</p>
                            <p class="text-slate-300 text-sm mt-1">Please wait for the next announcement.</p>
                        </div>
                    @endif
                </section>

                <!-- Q&A Interaction Quick View (Placeholder) -->
                <!-- <section>
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
                        <span class="w-2 h-6 bg-purple-600 rounded-full mr-3"></span>
                        Recent Q&A Activities
                    </h2>
                    <div class="bg-white border border-slate-200 rounded-xl divide-y divide-slate-100">
                        <div class="p-4 flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex-shrink-0 text-center pt-1">💬</div>
                            <div>
                                <p class="text-sm text-slate-900 font-medium italic">"How do you plan to represent your region?"</p>
                                <p class="text-xs text-slate-500 mt-1">Answered by Contestant #452 • 5 mins ago</p>
                            </div>
                        </div>
                        <div class="p-4 flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex-shrink-0 text-center pt-1">💬</div>
                            <div>
                                <p class="text-sm text-slate-900 font-medium italic">"What is your unique fox hunt style?"</p>
                                <p class="text-xs text-slate-500 mt-1">New Question asked • 2 hours ago</p>
                            </div>
                        </div>
                    </div>
                </section> -->

            </div>

            <!-- Right Column: Stats & Meta -->
            <div class="space-y-6">
                
                <!-- Membership Status Card -->

                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-slate-900 font-bold mb-4">Payment  Subscription Status</h3>
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-slate-500">Monthly Plan</p>
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded uppercase">Active</span>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400">Valid Until:</span>
                            <span class="text-slate-900 font-bold">{{ (isset($member) && $member->subscription_ends_at) ? \Carbon\Carbon::parse($member->subscription_ends_at)->format('M d, Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Competition Rules -->
                <div class="bg-slate-900 rounded-2xl p-6 text-white overflow-hidden relative">
                    <div class="absolute -right-8 -bottom-8 opacity-10">
                        <svg class="w-32 h-32" fill="white" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>

                <!-- Support/Notice -->
                <div class="text-center p-4">
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Project Fox Hunt</p>
                    <p class="text-xs text-slate-500 mt-1">Need help? <a href="#" class="text-indigo-600 font-bold underline">Contact Admin</a></p>
                </div>

            </div>
        </div>
    </main>
</div>

<style>
    /* Clean overrides for a professional look */
    body {
        background-color: #f8fafc;
        color: #1e293b;
    }
</style>
@endsection
