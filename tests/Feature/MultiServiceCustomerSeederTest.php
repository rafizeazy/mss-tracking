<?php

use App\Enums\Role;
use App\Livewire\Marketing\DataPelanggan\Index as MarketingDataPelangganIndex;
use App\Models\Customer;
use App\Models\User;
use Database\Seeders\MultiServiceCustomerSeeder;
use Livewire\Livewire;

it('seeds one customer with two active services and separate documents', function () {
    $this->seed(MultiServiceCustomerSeeder::class);

    $customer = Customer::with(['user', 'services.spk', 'services.baa', 'services.invoiceRegistrasi'])
        ->whereHas('user', fn ($query) => $query->where('email', 'multi.service@mss.test'))
        ->firstOrFail();

    expect($customer->services)->toHaveCount(2);

    $customer->services->each(function ($service): void {
        expect($service->status)->toBe('selesai')
            ->and($service->spk)->not->toBeNull()
            ->and($service->baa)->not->toBeNull()
            ->and($service->invoiceRegistrasi)->not->toBeNull();
    });
});

it('shows every active service on the customer dashboard', function () {
    $this->seed(MultiServiceCustomerSeeder::class);

    $user = User::where('email', 'multi.service@mss.test')->firstOrFail();

    $component = Livewire::actingAs($user)
        ->test(\App\Livewire\Customer\Dashboard::class)
        ->assertSee('100 Mbps')
        ->assertSee('300 Mbps')
        ->assertSee('Arsip Dokumen Layanan 100 Mbps')
        ->assertSee('Arsip Dokumen Layanan 300 Mbps');

    expect(substr_count($component->html(), 'data-service-summary-card'))->toBe(2);
});

it('opens customer dashboard detail modal for the selected service', function () {
    $this->seed(MultiServiceCustomerSeeder::class);

    $user = User::where('email', 'multi.service@mss.test')->firstOrFail();
    $customer = Customer::with('services')
        ->where('user_id', $user->id)
        ->firstOrFail();

    $service100 = $customer->services->firstWhere('bandwidth', '100 Mbps');
    $service300 = $customer->services->firstWhere('bandwidth', '300 Mbps');

    Livewire::actingAs($user)
        ->test(\App\Livewire\Customer\Dashboard::class)
        ->call('openDetailModal', $service100->id)
        ->assertSet('selectedDetailServiceId', $service100->id)
        ->assertSeeHtml('data-detail-service-bandwidth="100 Mbps"')
        ->call('openDetailModal', $service300->id)
        ->assertSet('selectedDetailServiceId', $service300->id)
        ->assertSeeHtml('data-detail-service-bandwidth="300 Mbps"');
});

it('groups multiple services under one customer in marketing customer data', function () {
    $this->seed(MultiServiceCustomerSeeder::class);

    $admin = User::factory()->create(['role' => Role::SuperAdmin]);

    $component = Livewire::actingAs($admin)
        ->test(MarketingDataPelangganIndex::class)
        ->assertSee('PT Multi Layanan Testing')
        ->assertSee('100 Mbps')
        ->assertSee('300 Mbps');

    expect(substr_count($component->html(), 'data-customer-group-id="MULTI-001"'))->toBe(1);
});

it('searches marketing customer data by service bandwidth', function () {
    $this->seed(MultiServiceCustomerSeeder::class);

    $admin = User::factory()->create(['role' => Role::SuperAdmin]);

    Livewire::actingAs($admin)
        ->test(MarketingDataPelangganIndex::class)
        ->set('search', '100 Mbps')
        ->assertSee('100 Mbps')
        ->assertDontSee('300 Mbps');
});
