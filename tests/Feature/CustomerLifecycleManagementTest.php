<?php

use App\Enums\Role;
use App\Livewire\Customer\Register;
use App\Livewire\Marketing\DataPelanggan\Index as MarketingDataPelangganIndex;
use App\Livewire\Marketing\Tracking\Index as MarketingTrackingIndex;
use App\Livewire\Marketing\Tracking\Show as MarketingTrackingShow;
use App\Livewire\Noc\Tracking\Show as NocTrackingShow;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        'status' => $status,
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

it('shows bandwidth prices in register options while keeping clean bandwidth values', function () {
    Livewire::test(Register::class)
        ->set('currentStep', 4)
        ->assertSee('100 Mbps - Rp 1.225.000')
        ->assertSeeHtml('value="100 Mbps"')
        ->assertDontSeeHtml('value="100 Mbps - Rp 1.225.000"');
});

it('restores safe registration draft fields only', function () {
    Livewire::test(Register::class)
        ->call('restoreDraft', [
            'currentStep' => 3,
            'name' => 'Aditya Roma',
            'email' => 'aditya@example.com',
            'company_name' => 'PT Draft Aman',
            'accepted_terms' => true,
            'password' => 'jangan-disimpan',
        ])
        ->assertSet('currentStep', 3)
        ->assertSet('name', 'Aditya Roma')
        ->assertSet('email', 'aditya@example.com')
        ->assertSet('company_name', 'PT Draft Aman')
        ->assertSet('accepted_terms', true)
        ->assertSet('password', '');
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

    expect($service->refresh()->status)->toBe('berhenti');
    expect($service->status_reason)->toBe('Kontrak sudah selesai');

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
        ->call('confirmDeleteService', $service->id)
        ->set('deleteReason', 'Layanan sudah tidak digunakan')
        ->call('deleteService')
        ->assertHasNoErrors();

    $this->assertSoftDeleted('customer_services', ['id' => $service->id]);
    $this->assertDatabaseHas('customers', [
        'id' => $customer->id,
        'deleted_at' => null,
    ]);
    $this->assertDatabaseHas('activity_logs', [
        'customer_id' => $customer->id,
        'action' => 'service.soft_deleted',
        'reason' => 'Layanan sudah tidak digunakan',
    ]);
});

it('restores softly deleted customer services from marketing customer data', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('berhenti');
    $service->delete();

    Livewire::actingAs($admin)
        ->test(MarketingDataPelangganIndex::class)
        ->call('restoreService', $service->id)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('customer_services', [
        'id' => $service->id,
        'deleted_at' => null,
    ]);
    $this->assertDatabaseHas('activity_logs', [
        'customer_id' => $customer->id,
        'action' => 'service.restored',
    ]);
});

it('deletes cancelled registrations softly from marketing tracking', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('dibatalkan');

    Livewire::actingAs($admin)
        ->test(MarketingTrackingIndex::class)
        ->call('confirmDeleteCancelledRegistration', $service->id)
        ->set('deleteReason', 'Data pengajuan batal dirapihkan')
        ->call('deleteCancelledRegistration')
        ->assertHasNoErrors();

    $this->assertSoftDeleted('customer_services', ['id' => $service->id]);
    $this->assertDatabaseHas('customers', [
        'id' => $customer->id,
        'deleted_at' => null,
    ]);
    $this->assertDatabaseHas('activity_logs', [
        'customer_id' => $customer->id,
        'action' => 'registration.soft_deleted',
        'reason' => 'Data pengajuan batal dirapihkan',
    ]);
});

it('shows cancellation reason modal before cancelling a registration', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['service' => $service] = createLifecycleCustomer('menunggu_verifikasi');

    Livewire::actingAs($admin)
        ->test(MarketingTrackingShow::class, ['id' => $service->id])
        ->assertSet('showCancellationModal', false)
        ->call('openCancellationModal')
        ->assertSet('showCancellationModal', true)
        ->assertSee('Alasan Pembatalan')
        ->call('closeCancellationModal')
        ->assertSet('showCancellationModal', false);
});

it('creates spk from service id without requiring legacy customer id', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['service' => $service] = createLifecycleCustomer('pembayaran_disetujui');

    Livewire::actingAs($admin)
        ->test(MarketingTrackingShow::class, ['id' => $service->id])
        ->set('customer_type', 'Government')
        ->set('due_date', now()->addDay()->format('Y-m-d'))
        ->set('spk_notes', 'Instruksi pekerjaan untuk tim NOC.')
        ->call('saveSpkData')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('spk', [
        'service_id' => $service->id,
        'customer_type' => 'Government',
        'job_type' => 'Aktivasi Baru',
    ]);
});

it('caches generated spk pdf for faster repeat views', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['service' => $service] = createLifecycleCustomer('pembayaran_disetujui');

    Livewire::actingAs($admin)
        ->test(MarketingTrackingShow::class, ['id' => $service->id])
        ->set('customer_type', 'Government')
        ->set('due_date', now()->addDay()->format('Y-m-d'))
        ->set('spk_notes', 'Instruksi pekerjaan untuk tim NOC.')
        ->call('saveSpkData');

    $cachePath = "generated/spk/spk-{$service->id}.pdf";
    Storage::disk('local')->delete($cachePath);

    $this->actingAs($admin)
        ->get(route('marketing.spk', $service->id))
        ->assertOk()
        ->assertHeader('content-type', 'application/pdf');

    expect(Storage::disk('local')->exists($cachePath))->toBeTrue();
    $lastModified = Storage::disk('local')->lastModified($cachePath);

    $this->actingAs($admin)
        ->get(route('marketing.spk', $service->id))
        ->assertOk();

    expect(Storage::disk('local')->lastModified($cachePath))->toBe($lastModified);
});

it('uses local confirmation modal before sending spk to noc', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['service' => $service] = createLifecycleCustomer('pembayaran_disetujui');

    Livewire::actingAs($admin)
        ->test(MarketingTrackingShow::class, ['id' => $service->id])
        ->set('customer_type', 'Government')
        ->set('due_date', now()->addDay()->format('Y-m-d'))
        ->set('spk_notes', 'Instruksi pekerjaan untuk tim NOC.')
        ->call('saveSpkData')
        ->assertSet('showSendToNocModal', false)
        ->call('openSendToNocModal')
        ->assertSet('showSendToNocModal', true)
        ->assertSee('Kirim SPK ke NOC')
        ->call('closeSendToNocModal')
        ->assertSet('showSendToNocModal', false)
        ->assertDontSee('wire:confirm="Pastikan PDF SPK sudah sesuai. Lanjutkan kirim ke Dashboard NOC?', false);
});

it('uses local confirmation modal before finishing noc installation', function () {
    $noc = User::factory()->create(['role' => Role::Noc]);
    ['service' => $service] = createLifecycleCustomer('proses_instalasi');
    $service->spk()->create([
        'spk_number' => '001/SPK/TEST/V/2026',
        'job_type' => 'Aktivasi Baru',
        'customer_type' => 'Government',
        'due_date' => now()->addDay()->format('Y-m-d'),
        'notes' => 'Instruksi pekerjaan NOC.',
    ]);

    Livewire::actingAs($noc)
        ->test(NocTrackingShow::class, ['id' => $service->id])
        ->assertSet('showFinishInstallationModal', false)
        ->call('openFinishInstallationModal')
        ->assertSet('showFinishInstallationModal', true)
        ->assertSee('Instalasi Selesai')
        ->call('closeFinishInstallationModal')
        ->assertSet('showFinishInstallationModal', false)
        ->assertDontSee('wire:confirm="Pastikan perangkat fisik sudah terpasang. Lanjut Aktivasi?', false);
});

it('creates baa from service id without requiring legacy customer id', function () {
    Storage::fake('public');

    $noc = User::factory()->create(['role' => Role::Noc]);
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('proses_aktivasi');
    $spk = $service->spk()->create([
        'spk_number' => '002/SPK/TEST/V/2026',
        'job_type' => 'Aktivasi Baru',
        'customer_type' => 'Government',
        'due_date' => now()->addDay()->format('Y-m-d'),
        'notes' => 'Instruksi pekerjaan NOC.',
    ]);

    Livewire::actingAs($noc)
        ->test(NocTrackingShow::class, ['id' => $service->id])
        ->set('customer_number', 'GTEST001')
        ->set('noc_signature', UploadedFile::fake()->image('signature.png'))
        ->set('speedtest_image', UploadedFile::fake()->image('speedtest.png'))
        ->set('devices', [
            ['name' => 'Router', 'qty' => 1, 'sn' => 'SN-001'],
        ])
        ->call('finishActivation')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('baa', [
        'service_id' => $service->id,
        'spk_id' => $spk->id,
        'baa_number' => '001/BAA-MSS/V/2026',
    ]);

    expect($service->refresh()->status)->toBe('review_baa');
});

it('uses local confirmation modal before sending baa to customer', function () {
    $noc = User::factory()->create(['role' => Role::Noc]);
    ['service' => $service] = createLifecycleCustomer('review_baa');
    $spk = $service->spk()->create([
        'spk_number' => '003/SPK/TEST/V/2026',
        'job_type' => 'Aktivasi Baru',
        'customer_type' => 'Government',
        'due_date' => now()->addDay()->format('Y-m-d'),
        'notes' => 'Instruksi pekerjaan NOC.',
    ]);
    $service->baa()->create([
        'spk_id' => $spk->id,
        'baa_number' => '003/BAA-MSS/V/2026',
        'noc_name' => 'NOC Test',
        'noc_position' => 'NETWORK OPERATION CENTER',
        'noc_department' => 'OPERATION',
        'noc_location' => 'KARAWANG',
        'activation_date' => now(),
        'devices' => [['name' => 'Router', 'qty' => 1, 'sn' => 'SN-003']],
    ]);

    Livewire::actingAs($noc)
        ->test(NocTrackingShow::class, ['id' => $service->id])
        ->assertSet('showSendBaaModal', false)
        ->call('openSendBaaModal')
        ->assertSet('showSendBaaModal', true)
        ->assertSee('Kirim BAA ke Pelanggan')
        ->call('closeSendBaaModal')
        ->assertSet('showSendBaaModal', false)
        ->assertDontSee('wire:confirm="Pastikan BAA sudah benar karena akan langsung dikirim ke pelanggan. Lanjutkan?', false);
});

it('uses local confirmation modal before marketing approves final baa', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['service' => $service] = createLifecycleCustomer('verifikasi_baa');
    $spk = $service->spk()->create([
        'spk_number' => '004/SPK/TEST/V/2026',
        'job_type' => 'Aktivasi Baru',
        'customer_type' => 'Government',
        'due_date' => now()->addDay()->format('Y-m-d'),
        'notes' => 'Instruksi pekerjaan NOC.',
    ]);
    $service->baa()->create([
        'spk_id' => $spk->id,
        'baa_number' => '004/BAA-MSS/V/2026',
        'noc_name' => 'NOC Test',
        'noc_position' => 'NETWORK OPERATION CENTER',
        'noc_department' => 'OPERATION',
        'noc_location' => 'KARAWANG',
        'activation_date' => now(),
        'signed_baa_path' => 'baa/signed/customer-baa.pdf',
        'devices' => [['name' => 'Router', 'qty' => 1, 'sn' => 'SN-004']],
    ]);

    Livewire::actingAs($admin)
        ->test(MarketingTrackingShow::class, ['id' => $service->id])
        ->assertSet('showApproveBaaModal', false)
        ->call('openApproveBaaModal')
        ->assertSet('showApproveBaaModal', true)
        ->assertSee('Setujui BAA')
        ->assertSee('Setujui')
        ->call('closeApproveBaaModal')
        ->assertSet('showApproveBaaModal', false)
        ->assertDontSee('wire:confirm="Setujui BAA ini dan nyatakan layanan selesai 100%?', false)
        ->assertDontSee('Setujui Final');
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

    expect($service->refresh()->status)->toBe('ditolak');
    expect($service->status_reason)->toBe('Dokumen legal tidak valid');

    $this->assertDatabaseHas('activity_logs', [
        'customer_id' => $customer->id,
        'action' => 'registration.rejected',
        'reason' => 'Dokumen legal tidak valid',
    ]);
});

it('renders invoice template without emoji glyphs', function () {
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('menunggu_pembayaran');
    $customer->load('user');

    $html = view('customer.invoice', [
        'customer' => $customer,
        'service' => $service,
        'subtotal' => 500000,
        'ppn' => 0,
        'grandTotal' => 500000,
    ])->render();

    expect($html)
        ->not->toContain('🖨️')
        ->not->toContain('📞')
        ->not->toContain('📋')
        ->not->toContain('📅')
        ->not->toContain('💳')
        ->not->toContain('✔️')
        ->toContain('Cetak / Simpan PDF (A4 Portrait)')
        ->toContain('Informasi Pembayaran');
});

it('lets super admin update registration created date from marketing tracking', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer, 'service' => $service] = createLifecycleCustomer('menunggu_invoice');

    Livewire::actingAs($admin)
        ->test(MarketingTrackingIndex::class)
        ->call('editRegistrationDate', $service->id)
        ->assertSet('editingRegistrationDateServiceId', $service->id)
        ->set('registrationDate', '2026-05-07T02:48')
        ->call('updateRegistrationDate')
        ->assertHasNoErrors()
        ->assertSet('editingRegistrationDateServiceId', null);

    expect($customer->refresh()->created_at->format('Y-m-d H:i'))->toBe('2026-05-07 02:48');
    expect($service->refresh()->created_at->format('Y-m-d H:i'))->toBe('2026-05-07 02:48');

    $this->assertDatabaseHas('activity_logs', [
        'customer_id' => $customer->id,
        'action' => 'registration.date_updated',
    ]);
});

it('removes sla alerts from dashboard and tracking queue', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    ['customer' => $customer] = createLifecycleCustomer('menunggu_invoice');
    $customer->forceFill(['updated_at' => now()->subHours(50)])->save();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Dashboard::class)
        ->assertDontSee('SLA Proses')
        ->assertDontSee('Terlewat');

    Livewire::actingAs($admin)
        ->test(MarketingTrackingIndex::class)
        ->assertDontSee('SLA');
});
