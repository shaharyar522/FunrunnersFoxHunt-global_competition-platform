@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-indigo-900 via-slate-900 to-black">
    <div class="max-w-md w-full space-y-8 bg-white/10 backdrop-blur-xl p-10 rounded-3xl border border-white/20 shadow-2xl" data-aos="zoom-in">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full shadow-lg mb-6">
                <span class="text-4xl">👑</span>
            </div>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Prove You Are Real</h2>
            <p class="mt-4 text-slate-300 text-lg">
                To join the world's foxiest competition, we require a small one-time entry fee to verify your identity and maintain quality.
            </p>
        </div>

        <div class="mt-8 space-y-6">
            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                <div class="flex items-center justify-between">
                    <span class="text-slate-400 font-medium">Entry Fee</span>
                    <span class="text-4xl font-bold text-white">$5.00</span>
                </div>
                <ul class="mt-6 space-y-3">
                    <li class="flex items-center text-slate-300">
                        <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Professional Profile Creation
                    </li>
                    <li class="flex items-center text-slate-300">
                        <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Access to Regional Rounds
                    </li>
                    <li class="flex items-center text-slate-300">
                        <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Global Visibility to Voters
                    </li>
                </ul>
            </div>

            <form action="{{ route('contestant.onboarding.pay') }}" method="POST">
                @csrf
                <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-lg font-bold rounded-xl text-slate-900 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-300 hover:to-orange-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 transform hover:scale-[1.02]">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-orange-900/50" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Pay via Secure Stripe
                </button>
            </form>
            
            <p class="text-center text-xs text-slate-500 italic">
                Secure 256-bit SSL Encrypted Payment
            </p>
        </div>
    </div>
</div>
@endsection
