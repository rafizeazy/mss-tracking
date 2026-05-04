<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $legacyColumns = [
        'service_type',
        'bandwidth',
        'term_of_service',
        'monthly_fee',
        'registration_fee',
        'sla',
        'metro_link',
        'jalur_metro',
        'installation_address',
        'marketing_name',
        'marketing_phone',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('customers') || ! Schema::hasTable('customer_services')) {
            return;
        }

        $existingColumns = $this->existingLegacyColumns();

        if ($existingColumns === []) {
            return;
        }

        $this->copyLegacyServiceData($existingColumns);

        Schema::table('customers', function (Blueprint $table) use ($existingColumns): void {
            $table->dropColumn($existingColumns);
        });
    }

    public function down(): void
    {
        //
    }

    private function existingLegacyColumns(): array
    {
        return array_values(array_filter(
            $this->legacyColumns,
            fn (string $column): bool => Schema::hasColumn('customers', $column)
        ));
    }

    private function copyLegacyServiceData(array $existingColumns): void
    {
        DB::table('customers')
            ->orderBy('id')
            ->get(array_merge(['id'], $existingColumns))
            ->each(function (object $customer) use ($existingColumns): void {
                $serviceData = [
                    'customer_id' => $customer->id,
                    'service_type' => $this->legacyValue($customer, 'service_type', $existingColumns) ?: 'Internet Dedicated 1:1',
                    'bandwidth' => $this->legacyValue($customer, 'bandwidth', $existingColumns) ?: 'Belum Diisi',
                    'term_of_service' => (int) ($this->legacyValue($customer, 'term_of_service', $existingColumns) ?: 1),
                    'monthly_fee' => $this->legacyValue($customer, 'monthly_fee', $existingColumns),
                    'registration_fee' => $this->legacyValue($customer, 'registration_fee', $existingColumns),
                    'sla' => $this->legacyValue($customer, 'sla', $existingColumns) ?: '99.5%',
                    'metro_link' => $this->legacyValue($customer, 'metro_link', $existingColumns)
                        ?: $this->legacyValue($customer, 'jalur_metro', $existingColumns),
                    'installation_address' => $this->legacyValue($customer, 'installation_address', $existingColumns),
                    'marketing_name' => $this->legacyValue($customer, 'marketing_name', $existingColumns),
                    'marketing_phone' => $this->legacyValue($customer, 'marketing_phone', $existingColumns),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                DB::table('customer_services')->updateOrInsert(
                    ['customer_id' => $customer->id],
                    $serviceData
                );
            });
    }

    private function legacyValue(object $customer, string $column, array $existingColumns): mixed
    {
        if (! in_array($column, $existingColumns, true)) {
            return null;
        }

        return $customer->{$column};
    }
};
