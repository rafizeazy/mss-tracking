<?php

use App\Enums\Role;
use App\Models\Baa;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Spk;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

function createPdfPreviewService(): CustomerService
{
    $user = User::factory()->create(['role' => Role::Customer]);

    $customer = Customer::create([
        'user_id' => $user->id,
        'ktp_number' => '3273012345678901',
        'company_name' => 'PT Preview PDF',
        'company_address' => 'Jl. Preview No. 1',
        'phone' => '08123456789',
        'status' => 'menunggu_baa',
    ]);

    $service = CustomerService::create([
        'customer_id' => $customer->id,
        'service_type' => 'Internet Dedicated 1:1',
        'bandwidth' => '100 Mbps',
        'term_of_service' => 1,
        'monthly_fee' => 500000,
        'registration_fee' => 1000000,
    ]);

    $spk = Spk::create([
        'service_id' => $service->id,
        'spk_number' => 'SPK/PREVIEW/'.$service->id,
        'job_type' => 'Aktivasi Baru',
        'customer_type' => 'Corporate',
        'due_date' => now()->addDay(),
    ]);

    Baa::create([
        'service_id' => $service->id,
        'spk_id' => $spk->id,
        'baa_number' => 'BAA/PREVIEW/'.$service->id,
        'noc_name' => 'NOC Preview',
        'noc_position' => 'NETWORK OPERATION CENTER',
        'noc_department' => 'OPERATION',
        'noc_location' => 'KARAWANG',
        'activation_date' => now(),
    ]);

    $service->invoiceRegistrasi()->create([
        'invoice_number' => 'INV/PREVIEW/'.$service->id,
        'invoice_generated_at' => now(),
    ]);

    return $service->fresh(['customer.user', 'spk', 'baa', 'invoiceRegistrasi']);
}

it('previews generated documents inline in a browser tab', function (string $routeName, string $cachePathPrefix, Role $role) {
    $service = createPdfPreviewService();
    $user = $role === Role::Customer
        ? $service->customer->user
        : User::factory()->create(['role' => $role]);

    $cachePath = "{$cachePathPrefix}-{$service->id}.pdf";
    Storage::disk('local')->put($cachePath, 'PDF PREVIEW CACHE');

    $response = $this->actingAs($user)
        ->get(route($routeName, $service->id))
        ->assertOk()
        ->assertHeader('content-type', 'application/pdf');

    expect($response->headers->get('content-disposition'))->toStartWith('inline;');
})->with([
    'baa' => ['noc.baa', 'generated/baa/baa', Role::Noc],
    'spk' => ['marketing.spk', 'generated/spk/spk', Role::Marketing],
    'formulir' => ['form.formulir', 'generated/forms/formulir', Role::Marketing],
    'invoice' => ['customer.invoice.pdf', 'generated/invoices/invoice', Role::Customer],
]);
