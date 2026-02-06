<?php

use App\Http\Controllers\indexController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VotingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Contestant\ContestantController;
use App\Http\Controllers\Member\MemberController;









/// to see the project-  page flow of this..


Route::get('/project', function () {

    return view('backup-page.project-flow');

});




// =======================================================================
Route::get('/', [indexController::class, 'index']);

// Route::get('/live-results', [App\Http\Controllers\PublicResultsController::class, 'index'])->name('public.results.index');
// Route::get('/live-results/{id}', [App\Http\Controllers\PublicResultsController::class, 'show'])->name('public.results.show');
// =================================================================== logout-profiles ===============
// ================================================= login with Social icon =================================================
// Google Login

Route::get('login/google', [SocialController::class, 'redirectToGoogle'])->name('google-login');

Route::get('login/google/callback', [SocialController::class, 'handleGoogleCallback']);
// Twitter/X Login
Route::get('/login/twitter', [SocialController::class, 'redirectToTwitter'])->name('twitter.login');
Route::get('/login/twitter/callback', [SocialController::class, 'handleTwitterCallback']);
// Facebook Login (Mock for now, until developer account is verified)
Route::get('login/facebook', [SocialController::class, 'redirectToFacebookMock'])->name('facebook-login');
// Manual Login/Logout
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

























// ================================================= Dashboards =================================================

// Contestant Dashboard (requires payment)

Route::middleware(['auth', 'unpaid_contestant'])->group(function () {

       Route::get('/contestant-dashboard', [ContestantController::class, 'dashboard'])->name('contestant.dashboard');


});


// Member Routes (Consolidated)
Route::middleware(['auth', 'unpaid_member'])->group(function () {
    Route::get('/member-dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
    Route::post('/member/pay', [MemberController::class, 'paymentProcess'])->name('member.paymentProcess');
    Route::get('/member/success', [MemberController::class, 'paymentSuccess'])->name('member.paymentSuccess');

    Route::get('/member/voting/{voting}', [MemberController::class, 'showVotingRound'])->name('member.voting.show');
    Route::post('/member/vote/{voting}/{contestant}', [App\Http\Controllers\VoteController::class, 'store'])->name('member.vote.store');
    Route::get('/member/results/{voting}', [MemberController::class, 'liveResults'])->name('member.results.show');

});




// ================================================================================= Payment_Processing =================================================================================
// Contestant paymentProcess (Processing only, Views handled by Dashboard)
Route::middleware('auth')->prefix('onboarding')->group(function () {

    Route::post('/pay', [ContestantController::class, 'paymentProcess'])->name('contestant.paymentProcess');
    Route::get('/success', [ContestantController::class, 'paymentSuccess'])->name('contestant.paymentSuccess');
    Route::get('/profile-setup', [ContestantController::class, 'profile'])->name('contestant.profile');
    Route::post('/profile-setup', [ContestantController::class, 'storeProfile'])->name('contestant.storeProfile');

});


// =================================================================================  End Payment_Processing =================================================================================






















// ================================================================================= Admin Routes =================================================================================


Route::prefix('admin')->group(function () {

    Route::get('login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth'])->group(function () {

        // Member & Contestant Routes
        Route::get('members', [AdminController::class, 'membersList'])->name('admin.members.list');
        Route::get('contestants', [AdminController::class, 'contestantsList'])->name('admin.contestants.list');
        Route::get('contestants/{id}/edit', [AdminController::class, 'getContestant'])->name('admin.contestants.get'); // For Modal
        Route::post('contestants/{id}/update', [AdminController::class, 'updateContestant'])->name('admin.contestants.update');
        Route::post('contestants/{id}/toggle-status', [AdminController::class, 'toggleContestantStatus'])->name('admin.contestants.toggle');

        // contestant and member dashboard show when click on dasboard buttun sidebar  right now..

        Route::get('/member-dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');

        // Regions Management
        Route::get('regions', [App\Http\Controllers\Admin\RegionController::class, 'index'])->name('admin.regions.index');
        Route::get('regions/create', [App\Http\Controllers\Admin\RegionController::class, 'create'])->name('admin.regions.create');
        Route::post('regions', [App\Http\Controllers\Admin\RegionController::class, 'store'])->name('admin.regions.store');
        Route::get('regions/{region}/edit', [App\Http\Controllers\Admin\RegionController::class, 'edit'])->name('admin.regions.edit');
        Route::put('regions/{region}', [App\Http\Controllers\Admin\RegionController::class, 'update'])->name('admin.regions.update');
        Route::delete('regions/{region}', [App\Http\Controllers\Admin\RegionController::class, 'destroy'])->name('admin.regions.destroy');

    });
});


// ================================================================================= Admin Routes =================================================================================


// ================================================= Voting Routes =================================================


Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/voting', [VotingController::class, 'index'])
        ->name('admin.voting.list');

    Route::post('/voting/status/{id}', [VotingController::class, 'changeStatus'])
        ->name('admin.voting.status');
        
    // create voting
    Route::get('/voting/create', [VotingController::class, 'create'])->name('admin.voting.create');
    Route::post('/voting/store', [VotingController::class, 'store'])->name('admin.votings.store');

    //details route
    Route::get('/voting/detail/{id}', [VotingController::class, 'detail'])->name('admin.voting.detail');


    // Toggle contestant status inside voting (AJAX optional)
    Route::post('/voting-contestant/toggle/{id}', [VotingController::class, 'toggleContestantStatus'])->name('admin.votingContestant.toggle');
    Route::post('/voting/promote', [VotingController::class, 'promoteContestant'])->name('admin.voting.promote');
    Route::get('/voting/export/{id}', [VotingController::class, 'exportResults'])->name('admin.voting.export');
    Route::delete('/voting/votes/{id}', [VotingController::class, 'destroyVotes'])->name('admin.voting.destroyVotes');
});
