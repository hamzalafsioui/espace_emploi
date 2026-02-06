<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile (accessible to all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Search (accessible to all authenticated users)
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');

    // Friendships (accessible to all authenticated users)
    Route::get('/friendships', [FriendshipController::class, 'index'])->name('friendships.index');
    Route::post('/friendships', [FriendshipController::class, 'store'])->name('friendships.store');
    Route::patch('/friendships/{friendship}', [FriendshipController::class, 'update'])->name('friendships.update');
    Route::delete('/friendships/{friendship}', [FriendshipController::class, 'destroy'])->name('friendships.destroy');
});

// Job Seeker Routes (only accessible to job seekers)
Route::middleware(['auth', 'role:job_seeker'])->group(function () {
    Route::get('/job-seeker/jobs', function () {
        return view('job_seeker.jobs');
    })->name('job-seeker.jobs.index');
    Route::get('/job-seeker/profile', [\App\Http\Controllers\JobSeekerProfileController::class, 'edit'])->name('job-seeker.profile.edit');
    Route::patch('/job-seeker/profile', [\App\Http\Controllers\JobSeekerProfileController::class, 'update'])->name('job-seeker.profile.update');
    Route::post('/applications', [\App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
});

// Recruiter Routes (only accessible to recruiters)
Route::middleware(['auth', 'role:recruiter'])->group(function () {
    Route::get('/recruiter/dashboard', [DashboardController::class, 'index'])->name('recruiter.dashboard');
    Route::patch('job-offers/{jobOffer}/toggle-status', [\App\Http\Controllers\JobOfferController::class, 'toggleStatus'])->name('job-offers.toggle-status');
    Route::get('job-offers/{jobOffer}/applications', [\App\Http\Controllers\JobOfferController::class, 'showApplications'])->name('job-offers.applications');
    Route::patch('applications/{application}/status', [\App\Http\Controllers\ApplicationController::class, 'updateStatus'])->name('applications.update-status');
    Route::resource('job-offers', \App\Http\Controllers\JobOfferController::class);
});

require __DIR__ . '/auth.php';
