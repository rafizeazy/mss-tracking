<?php

use App\Enums\Role;
use App\Livewire\AuditLog\Index as AuditLogIndex;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\User;
use Livewire\Livewire;

function createAuditLogCustomer(): Customer
{
    $user = User::factory()->create(['role' => Role::Customer]);

    return Customer::create([
        'user_id' => $user->id,
        'ktp_number' => '3273012345678901',
        'company_name' => 'PT Audit Log Test',
        'company_address' => 'Jl. Audit No. 1',
        'phone' => '08123456789',
        'status' => 'menunggu_verifikasi',
    ]);
}

it('restricts audit log page to super admin', function () {
    $user = User::factory()->create(['role' => Role::Marketing]);

    $this->actingAs($user)
        ->get(route('audit-log.index'))
        ->assertForbidden();
});

it('shows audit logs with pagination for super admin', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    $customer = createAuditLogCustomer();

    ActivityLog::create([
        'user_id' => $admin->id,
        'customer_id' => $customer->id,
        'action' => 'registration.cancelled',
        'description' => 'Registrasi dibatalkan oleh Marketing.',
        'reason' => 'Pelanggan minta jadwal ulang',
        'ip_address' => '127.0.0.1',
    ]);

    $this->actingAs($admin)
        ->get(route('audit-log.index'))
        ->assertOk()
        ->assertSee('Audit Log Aktivitas')
        ->assertSee('Registrasi dibatalkan')
        ->assertSee('Registrasi dibatalkan oleh Marketing.')
        ->assertSee('Pelanggan minta jadwal ulang');
});

it('filters audit logs by search and action', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    $customer = createAuditLogCustomer();

    ActivityLog::create([
        'user_id' => $admin->id,
        'customer_id' => $customer->id,
        'action' => 'customer.stopped',
        'description' => 'Pelanggan diberhentikan.',
        'reason' => 'Kontrak selesai',
    ]);

    ActivityLog::create([
        'user_id' => $admin->id,
        'customer_id' => $customer->id,
        'action' => 'registration.approved',
        'description' => 'Registrasi disetujui.',
    ]);

    Livewire::actingAs($admin)
        ->test(AuditLogIndex::class)
        ->set('search', 'Kontrak')
        ->set('action', 'customer.stopped')
        ->assertSee('Pelanggan diberhentikan.')
        ->assertSee('Kontrak selesai')
        ->assertDontSee('Registrasi disetujui.');
});
