@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Member Subscription</h1>
                <p class="text-slate-300">Access exclusive voting and support your favorite contestants.</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-xl p-8 rounded-3xl border border-white/20 shadow-2xl">
                <div class="text-center mb-8">
                    <span class="text-5xl font-bold text-white">$5</span>
                    <span class="text-slate-400">/monthly</span>
                </div>

                <form action="{{ route('member.onboarding.pay') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span>Subscribe Now</span>
                    </button>
                </form>

                <!-- Security Note -->
                <div class="mt-6 flex items-center justify-center space-x-2 text-xs text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Secure payment powered by Stripe</span>
                </div>
            </div>

            <!-- Info Note -->
            <div class="mt-8 text-center">
                <p class="text-white text-sm opacity-60">
                    By subscribing, you agree to our terms of service
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
