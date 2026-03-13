<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('register/customer', \App\Livewire\Customer\Register::class)->name('customer.register');

// Route Khusus Pelanggan (tanpa 'verified' agar langsung bisa akses usai daftar)
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('customer/dashboard', \App\Livewire\Customer\Dashboard::class)->name('customer.dashboard');
    Route::get('customer/invoice/{id}', [\App\Http\Controllers\InvoiceController::class, 'streamCustomerInvoice'])->name('customer.invoice');
});

// ROUTE UMUM (Semua role internal)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('customers', \App\Livewire\Customer\Index::class)->name('customers.index');
});

// ROUTE KHUSUS SUPER ADMIN
Route::middleware(['auth', 'verified', 'super_admin'])->group(function () {
    Route::get('users', \App\Livewire\UserManagement::class)->name('users.index');
});

// ROUTE MARKETING
Route::middleware(['auth', 'verified', 'role:marketing,super_admin'])->group(function () {
    Route::get('marketing/tracking', \App\Livewire\Marketing\Tracking\Index::class)->name('marketing.tracking.index');
    Route::get('marketing/tracking/{id}', \App\Livewire\Marketing\Tracking\Show::class)->name('marketing.tracking.show');
});

// ROUTE FINANCE
Route::middleware(['auth', 'verified', 'role:finance,super_admin'])->group(function () {
    Route::get('finance/tracking', \App\Livewire\Finance\Index::class)->name('finance.tracking.index');
    Route::get('finance/tracking/{id}', \App\Livewire\Finance\Show::class)->name('finance.tracking.show');
});

// ROUTE NOC
Route::middleware(['auth', 'verified', 'role:noc,super_admin'])->group(function () {
    Route::get('noc/activations', \App\Livewire\Noc\Activations::class)->name('noc.activations');
});

require __DIR__.'/settings.php';
