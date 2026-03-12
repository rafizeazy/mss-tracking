<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('register/customer', \App\Livewire\Customer\Register::class)->name('customer.register');

// Route Khusus Pelanggan
Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::get('customer/dashboard', \App\Livewire\Customer\Dashboard::class)->name('customer.dashboard');
});

// ROUTE UMUM (Bisa diakses oleh semua role)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('customers', \App\Livewire\Customer\Index::class)->name('customers.index');
});

// ROUTE KHUSUS SUPER ADMIN
Route::middleware(['auth', 'verified', 'super_admin'])->group(function () {
    Route::get('users', \App\Livewire\UserManagement::class)->name('users.index');
});

// ROUTE MARKETING
Route::middleware(['auth', 'verified', 'role:marketing'])->group(function () {
    Route::get('marketing/tracking', \App\Livewire\Marketing\Tracking\Index::class)->name('marketing.tracking.index');
    Route::get('marketing/tracking/{id}', \App\Livewire\Marketing\Tracking\Show::class)->name('marketing.tracking.show');
});

// ROUTE FINANCE
Route::middleware(['auth', 'verified', 'role:finance'])->group(function () {
    Route::get('finance/tracking', \App\Livewire\Finance\Tracking::class)->name('finance.tracking');
});

require __DIR__.'/settings.php';