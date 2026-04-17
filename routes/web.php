<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormUpgradeController;
use App\Http\Controllers\BauController;

Route::view('/', 'welcome')->name('home');
Route::get('register/customer', \App\Livewire\Customer\Register::class)->name('customer.register');

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('customer/dashboard', \App\Livewire\Customer\Dashboard::class)->name('customer.dashboard');
    Route::get('/customer/invoice/{id}/pdf', [InvoiceController::class, 'streamInvoice'])->name('customer.invoice.pdf');
    Route::get('/customer/request/{id}/pdf', [FormUpgradeController::class, 'previewRequestPdf'])->name('customer.request.pdf');
    Route::get('/customer/bau/{id}/pdf', [BauController::class, 'streamBau'])->name('customer.bau.pdf');
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
    Route::get('marketing/request', \App\Livewire\Marketing\Request\Index::class)->name('marketing.request.index');
    Route::get('marketing/request/{id}', \App\Livewire\Marketing\Request\Show::class)->name('marketing.request.show');
    Route::get('marketing/request/{id}/pdf', [FormUpgradeController::class, 'previewRequestPdf'])->name('marketing.request.pdf');
    Route::get('marketing/riwayat', \App\Livewire\Riwayat\Riwayat::class)->name('marketing.riwayat.index');
    Route::get('marketing/berhenti', \App\Livewire\Berhenti\Berhenti::class)->name('marketing.berhenti');
});

// ROUTE GABUNGAN MARKETING & NOC
Route::middleware(['auth', 'verified', 'role:marketing,noc,super_admin'])->group(function () {
    Route::get('marketing/request/{id}/spk-pdf', [FormUpgradeController::class, 'previewSpkPdf'])->name('marketing.request.spk.pdf');
    Route::get('noc/request/{id}/bau-pdf', [BauController::class, 'streamBau'])->name('noc.request.bau.pdf');
});

// ROUTE KHUSUS FINANCE
Route::middleware(['auth', 'verified', 'role:finance,super_admin'])->group(function () {
    Route::get('finance/tracking', \App\Livewire\Finance\Index::class)->name('finance.tracking.index');
    Route::get('finance/tracking/{id}', \App\Livewire\Finance\Show::class)->name('finance.tracking.show');
    Route::get('finance/request', \App\Livewire\Finance\Request\Index::class)->name('finance.request.index');
    Route::get('finance/request/{id}', \App\Livewire\Finance\Request\Show::class)->name('finance.request.show'); 
    Route::get('finance/riwayat', \App\Livewire\Riwayat\Riwayat::class)->name('finance.riwayat.index');
    Route::get('finance/berhenti', \App\Livewire\Berhenti\Berhenti::class)->name('finance.berhenti');
});

// ROUTE KHUSUS NOC
Route::middleware(['auth', 'verified', 'role:noc,super_admin'])->group(function () {
    Route::get('noc/tracking', \App\Livewire\Noc\Tracking\Index::class)->name('noc.tracking.index');
    Route::get('noc/tracking/{id}', \App\Livewire\Noc\Tracking\Show::class)->name('noc.tracking.show');
    Route::get('noc/request', \App\Livewire\Noc\Request\Index::class)->name('noc.request.index');
    Route::get('noc/request/{id}', \App\Livewire\Noc\Request\Show::class)->name('noc.request.show');
    Route::get('noc/riwayat', \App\Livewire\Riwayat\Riwayat::class)->name('noc.riwayat.index');
    Route::get('noc/berhenti', \App\Livewire\Berhenti\Berhenti::class)->name('noc.berhenti');
});

Route::middleware(['auth', 'verified', 'role:marketing,finance,super_admin'])->group(function () {
    Route::get('form/formulir-berlangganan/{id}', [\App\Http\Controllers\FormController::class, 'cetakFormulir'])->name('form.formulir');
});

require __DIR__.'/settings.php';