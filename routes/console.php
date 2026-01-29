<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Member;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily cleanup of old expired members (90 days grace period)
Schedule::call(function () {
    $expiredLimit = now()->subDays(90);
    
    // Find members whose subscription ended more than 90 days ago
    $oldMembers = Member::where('subscription_ends_at', '<', $expiredLimit)->get();
    
    foreach ($oldMembers as $member) {
        // Delete the user (this will cascade delete the member record)

        if ($member->user) {
            $member->user->delete();
        }
        
    }
})->daily();
