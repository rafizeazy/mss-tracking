<?php

use App\Enums\Role;
use App\Livewire\Customer\Register;
use App\Livewire\Marketing\DataPelanggan\Index as MarketingDataPelangganIndex;
use App\Livewire\Marketing\Tracking\Index as MarketingTrackingIndex;
use App\Livewire\Marketing\Tracking\Show as MarketingTrackingShow;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

function createLifecycleCustomer(string $status): array
{
    $user = User::factory()->create(['role' => Role::Customer]);

    $customer = Customer::create([
        'user_id' => $user->id,
        'ktp_number' => '3273012345678901',
        'company_name' => 'PT Lifecycle Test',
        'company_address' => 'Jl. Lifecycle No. 1',
        'phone' => '08123456789',
        'status' => $status,
    ]);

    $service = CustomerService::create([
        'customer_id' => $customer->id,
        'bandwidth' => '100 Mbps',
        'term_of_service' => 1,
        'monthly_fee' => 500000,
        'registration_fee' => 0,
    ]);

    return compact('user', 'customer', 'service');
}

it('limits register supporting documents to five megabytes', function () {
    Livewire::test(Register::class)
        ->set('service_type', 'Internet Dedicated 1:1')
        ->set('bandwidth', '100 Mbps')
        ->set('term_of_service', '1')
        ->set('installation_address', 'Jl. Instalasi No. 1')
        ->set('ktp_file', UploadedFile::fake()->create('ktp.pdf', 5121, 'application/pdf'))
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('accepted_terms', true)
        ->call('submit')
        ->assertHasErrors(['ktp_file' => 'max']);
});

it('reactivates stopped customers from marketing customer data', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('berhenti');

    Livewire::actingAs($admin)
        ->test(MarketingDataPelangganIndex::class)
        ->call('aktifkanKembaliPelanggan', $service->id)
        ->assertHasNoErrors();

    expect($customer->refresh()->status)->toBe('selesai');
});

it('deletes stopped customers from marketing customer data', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('berhenti');

    Livewire::actingAs($admin)
        ->test(MarketingDataPelangganIndex::class)
        ->call('confirmBerhentikanPelanggan', $service->id)
        ->set('stopReason', 'Kontrak sudah selesai')
        ->call('berhentikanPelanggan')
        ->assertHasNoErrors();

    expect($customer->refresh()->status)->toBe('berhenti');
    expect($customer->status_reason)->toBe('Kontrak sudah selesai');

    $this->assertDatabaseHas('activity_logs', [
        'customer_id' => $customer->id,
        'action' => 'customer.stopped',
        'reason' => 'Kontrak sudah selesai',
    ]);
});

it('deletes stopped customers softly from marketing customer data', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('berhenti');

    Livewire::actingAs($admin)
        ->test(MarketingDataPelangganIndex::class)
        ->call('hapusPelangganBerhenti', $service->id)
        ->assertHasNoErrors();

    $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    $this->assertDatabaseHas('customer_services', ['id' => $service->id]);
});

it('deletes cancelled registrations softly from marketing tracking', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('dibatalkan');

    Livewire::actingAs($admin)
        ->test(MarketingTrackingIndex::class)
        ->call('deleteCancelledRegistration', $customer->id)
        ->assertHasNoErrors();

    $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    $this->assertDatabaseHas('customer_services', ['id' => $service->id]);
});

it('requires a reason when rejecting a registration', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('menunggu_verifikasi');

    Livewire::actingAs($admin)
        ->test(MarketingTrackingShow::class, ['id' => $service->id])
        ->call('reject')
        ->assertHasErrors(['rejectionReason' => 'required'])
        ->set('rejectionReason', 'Dokumen legal tidak valid')
        ->call('reject')
        ->assertHasNoErrors();

    expect($customer->refresh()->status)->toBe('ditolak');
    expect($customer->status_reason)->toBe('Dokumen legal tidak valid');

    $this->assertDatabaseHas('activity_logs', [
        'customer_id' => $customer->id,
        'action' => 'registration.rejected',
        'reason' => 'Dokumen legal tidak valid',
    ]);
});

it('shows overdue process customers in dashboard sla alerts', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer] = createLifecycleCustomer('menunggu_invoice');
    $customer->forceFill(['updated_at' => now()->subHours(50)])->save();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Dashboard::class)
        ->assertSet('stats.sla_overdue.total', 1);
});
