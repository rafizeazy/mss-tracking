<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified', 'super_admin'])->group(function () {
    Route::get('users', \App\Livewire\UserManagement::class)->name('users.index');
});

// Tracking
Route::middleware(['auth', 'verified', 'role:finance'])->group(function () {
    Route::get('finance/tracking', \App\Livewire\Finance\Tracking::class)->name('finance.tracking');
});

require __DIR__.'/settings.php';
