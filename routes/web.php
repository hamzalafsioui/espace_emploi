<?php

use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');

    // Friendships
    Route::get('/friendships', [FriendshipController::class, 'index'])->name('friendships.index');
    Route::post('/friendships', [FriendshipController::class, 'store'])->name('friendships.store');
    Route::patch('/friendships/{friendship}', [FriendshipController::class, 'update'])->name('friendships.update');
    Route::delete('/friendships/{friendship}', [FriendshipController::class, 'destroy'])->name('friendships.destroy');
});

require __DIR__ . '/auth.php';
