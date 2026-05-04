<?php

use App\Enums\Role;
use App\Models\Baa;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Spk;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdf;

function createServiceWithBaaForUser(User $user): CustomerService
{
    $customer = Customer::create([
        'user_id' => $user->id,
        'ktp_number' => '3273012345678901',
        'company_name' => 'PT Test Sejahtera',
        'company_address' => 'Jl. Test No. 1',
        'phone' => '08123456789',
        'status' => 'menunggu_baa',
    ]);

    $service = CustomerService::create([
        'customer_id' => $customer->id,
        'bandwidth' => '20 Mbps',
        'term_of_service' => 12,
        'monthly_fee' => 500000,
        'registration_fee' => 1000000,
    ]);

    $spk = Spk::create([
        'service_id' => $service->id,
        'spk_number' => 'SPK/TEST/'.$service->id,
    ]);

    Baa::create([
        'service_id' => $service->id,
        'spk_id' => $spk->id,
        'baa_number' => 'BAA/TEST/'.$service->id,
        'noc_name' => 'NOC Test',
        'noc_position' => 'NETWORK OPERATION CENTER',
        'noc_department' => 'OPERATION',
        'noc_location' => 'KARAWANG',
        'activation_date' => '2026-05-04',
    ]);

    return $service;
}

function mockBaaPdfStream(): void
{
    $pdf = \Mockery::mock(DomPdf::class);
    $pdf->shouldReceive('stream')
        ->once()
        ->andReturn(response('PDF BAA', 200, ['Content-Type' => 'application/pdf']));

    Pdf::shouldReceive('loadView')
        ->once()
        ->with('pdf.baa', \Mockery::on(fn (array $data): bool => isset($data['customer'], $data['service'], $data['baa'], $data['spk'])))
        ->andReturn($pdf);
}

it('allows a customer to stream their own baa', function () {
    $user = User::factory()->create(['role' => Role::Customer]);
    $service = createServiceWithBaaForUser($user);

    mockBaaPdfStream();

    $this->actingAs($user)
        ->get(route('noc.baa', $service->id))
        ->assertOk();
});

it('prevents a customer from streaming another customer baa', function () {
    $owner = User::factory()->create(['role' => Role::Customer]);
    $otherCustomer = User::factory()->create(['role' => Role::Customer]);
    $service = createServiceWithBaaForUser($owner);

    $this->actingAs($otherCustomer)
        ->get(route('noc.baa', $service->id))
        ->assertForbidden();
});

it('still allows internal users to stream customer baa', function () {
    $owner = User::factory()->create(['role' => Role::Customer]);
    $noc = User::factory()->create(['role' => Role::Noc]);
    $service = createServiceWithBaaForUser($owner);

    mockBaaPdfStream();

    $this->actingAs($noc)
        ->get(route('noc.baa', $service->id))
        ->assertOk();
});
