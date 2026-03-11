<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('register/customer', \App\Livewire\Customer\Register::class)->name('customer.register');

// ROUTE UMUM (Bisa diakses oleh semua role)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('customers', \App\Livewire\Customer\Index::class)->name('customers.index');
});

// ROUTE KHUSUS SUPER ADMIN
Route::middleware(['auth', 'verified', 'super_admin'])->group(function () {
    Route::get('users', \App\Livewire\UserManagement::class)->name('users.index');
});

// ROUTE FINANCE
Route::middleware(['auth', 'verified', 'role:finance'])->group(function () {
    Route::get('finance/tracking', \App\Livewire\Finance\Tracking::class)->name('finance.tracking');
});

require __DIR__.'/settings.php';