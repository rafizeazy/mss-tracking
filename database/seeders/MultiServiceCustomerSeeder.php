<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MultiServiceCustomerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'multi.service@mss.test'],
            [
                'name' => 'Customer Multi Layanan',
                'password' => Hash::make('Password123'),
                'role' => Role::Customer,
                'email_verified_at' => now(),
            ]
        );

        $customer = Customer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'customer_number' => 'MULTI-001',
                'ktp_number' => '3273012345678901',
                'gender' => 'L',
                'position' => 'Direktur',
                'phone' => '081234567890',
                'company_name' => 'PT Multi Layanan Testing',
                'business_type' => 'Corporate',
                'npwp_number' => '012345678901234',
                'company_address' => 'Jl. Testing Multi Layanan No. 1',
                'city' => 'KARAWANG',
                'province' => 'JAWA BARAT',
                'postal_code' => '41361',
                'company_phone' => '0267123456',
                'finance_name' => 'Finance Multi',
                'finance_email' => 'finance.multi@mss.test',
                'finance_phone' => '081234567891',
                'billing_address' => 'Jl. Billing Multi Layanan No. 1',
                'technical_name' => 'Teknis Multi',
                'technical_email' => 'teknis.multi@mss.test',
                'technical_phone' => '081234567892',
                'status' => 'selesai',
                'status_reason' => null,
                'status_reason_at' => null,
            ]
        );

        $services = [
            [
                'bandwidth' => '100 Mbps',
                'monthly_fee' => 1225000,
                'installation_address' => 'Jl. Instalasi Kantor Pusat No. 10',
                'spk_number' => 'SPK/MULTI-001',
                'baa_number' => 'BAA/MULTI-001',
                'invoice_number' => 'INV/MULTI-001',
                'device_sn' => 'MULTI-SN-001',
            ],
            [
                'bandwidth' => '300 Mbps',
                'monthly_fee' => 3500000,
                'installation_address' => 'Jl. Instalasi Cabang No. 20',
                'spk_number' => 'SPK/MULTI-002',
                'baa_number' => 'BAA/MULTI-002',
                'invoice_number' => 'INV/MULTI-002',
                'device_sn' => 'MULTI-SN-002',
            ],
        ];

        foreach ($services as $index => $serviceData) {
            $service = $customer->services()->updateOrCreate(
                ['bandwidth' => $serviceData['bandwidth']],
                [
                    'service_type' => 'Internet Dedicated 1:1',
                    'term_of_service' => 1,
                    'monthly_fee' => $serviceData['monthly_fee'],
                    'registration_fee' => 0,
                    'sla' => '99.5%',
                    'metro_link' => 'Metro Testing '.($index + 1),
                    'installation_address' => $serviceData['installation_address'],
                    'marketing_name' => 'Marketing Seeder',
                    'marketing_phone' => '08120000000'.($index + 1),
                    'status' => 'selesai',
                    'status_reason' => null,
                    'status_reason_at' => null,
                ]
            );

            $spk = $service->spk()->updateOrCreate(
                ['service_id' => $service->id],
                [
                    'spk_number' => $serviceData['spk_number'],
                    'job_type' => 'Aktivasi Baru',
                    'customer_type' => 'Corporate',
                    'due_date' => now()->addDays($index + 1)->toDateString(),
                    'notes' => 'Data testing untuk validasi satu customer memiliki lebih dari satu layanan aktif.',
                ]
            );

            $service->invoiceRegistrasi()->updateOrCreate(
                ['service_id' => $service->id],
                [
                    'invoice_number' => $serviceData['invoice_number'],
                    'invoice_generated_at' => now(),
                    'payment_proof_file_path' => null,
                ]
            );

            $service->baa()->updateOrCreate(
                ['service_id' => $service->id],
                [
                    'spk_id' => $spk->id,
                    'baa_number' => $serviceData['baa_number'],
                    'noc_name' => 'NOC Seeder',
                    'noc_position' => 'NETWORK OPERATION CENTER',
                    'noc_department' => 'OPERATION',
                    'noc_location' => 'KARAWANG',
                    'activation_date' => now()->subDays($index + 1)->toDateString(),
                    'devices' => [
                        [
                            'name' => 'Router Testing',
                            'qty' => 1,
                            'sn' => $serviceData['device_sn'],
                        ],
                    ],
                ]
            );
        }
    }
}
