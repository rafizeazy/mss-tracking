<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\FormController;

Route::view('/', 'welcome')->name('home');
Route::get('register/customer', \App\Livewire\Customer\Register::class)->name('customer.register');

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('customer/dashboard', \App\Livewire\Customer\Dashboard::class)->name('customer.dashboard');
    Route::get('/customer/invoice/{id}/pdf', [InvoiceController::class, 'streamInvoice'])->name('customer.invoice.pdf');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('marketing/spk/{id}', [\App\Http\Controllers\SpkController::class, 'streamSpk'])->name('marketing.spk');
    Route::get('noc/baa/{id}', [\App\Http\Controllers\BaaController::class, 'streamBaa'])->name('noc.baa');
    Route::get('marketing/data-pelanggan', \App\Livewire\Marketing\Datapelanggan\Index::class)->name('marketing.datapelanggan.index');
    Route::get('finance/data-pelanggan', \App\Livewire\Finance\Datapelanggan\Index::class)->name('finance.datapelanggan.index');
    Route::get('noc/data-pelanggan', \App\Livewire\Noc\Datapelanggan\Index::class)->name('noc.datapelanggan.index');
    Route::get('customer/invoice/{id}', [\App\Http\Controllers\InvoiceController::class, 'streamCustomerInvoice'])->name('customer.invoice');
});

Route::middleware(['auth', 'verified', 'super_admin'])->group(function () {
    Route::get('users', \App\Livewire\UserManagement::class)->name('users.index');
});

// ROUTE KHUSUS MARKETING
Route::middleware(['auth', 'verified', 'role:marketing,super_admin'])->group(function () {
    Route::get('marketing/tracking', \App\Livewire\Marketing\Tracking\Index::class)->name('marketing.tracking.index');
    Route::get('marketing/tracking/{id}', \App\Livewire\Marketing\Tracking\Show::class)->name('marketing.tracking.show');
});

// ROUTE KHUSUS FINANCE
Route::middleware(['auth', 'verified', 'role:finance,super_admin'])->group(function () {
    Route::get('finance/tracking', \App\Livewire\Finance\Index::class)->name('finance.tracking.index');
    Route::get('finance/tracking/{id}', \App\Livewire\Finance\Show::class)->name('finance.tracking.show');
});

// ROUTE KHUSUS NOC
Route::middleware(['auth', 'verified', 'role:noc,super_admin'])->group(function () {
    Route::get('noc/tracking', \App\Livewire\Noc\Tracking\Index::class)->name('noc.tracking.index');
    Route::get('noc/tracking/{id}', \App\Livewire\Noc\Tracking\Show::class)->name('noc.tracking.show');
});

Route::middleware(['auth', 'verified', 'role:marketing,finance,super_admin'])->group(function () {
    Route::get('form/formulir-berlangganan/{id}', [\App\Http\Controllers\FormController::class, 'cetakFormulir'])->name('form.formulir');
});

require __DIR__.'/settings.php';