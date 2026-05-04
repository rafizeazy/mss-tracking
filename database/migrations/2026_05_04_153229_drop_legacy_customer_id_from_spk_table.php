<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('spk') || ! Schema::hasColumn('spk', 'customer_id')) {
            return;
        }

        if (Schema::hasColumn('spk', 'service_id')) {
            DB::table('spk')
                ->whereNull('service_id')
                ->whereNotNull('customer_id')
                ->orderBy('id')
                ->get(['id', 'customer_id'])
                ->each(function (object $spk): void {
                    $serviceId = DB::table('customer_services')
                        ->where('customer_id', $spk->customer_id)
                        ->value('id');

                    if ($serviceId) {
                        DB::table('spk')
                            ->where('id', $spk->id)
                            ->update(['service_id' => $serviceId]);
                    }
                });
        }

        $this->dropCustomerForeignKeys();

        Schema::table('spk', function (Blueprint $table): void {
            $table->dropColumn('customer_id');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('spk') || Schema::hasColumn('spk', 'customer_id')) {
            return;
        }

        Schema::table('spk', function (Blueprint $table): void {
            $table->foreignId('customer_id')->nullable()->after('service_id')->constrained()->nullOnDelete();
        });

        DB::table('spk')
            ->whereNotNull('service_id')
            ->orderBy('id')
            ->get(['id', 'service_id'])
            ->each(function (object $spk): void {
                $customerId = DB::table('customer_services')
                    ->where('id', $spk->service_id)
                    ->value('customer_id');

                if ($customerId) {
                    DB::table('spk')
                        ->where('id', $spk->id)
                        ->update(['customer_id' => $customerId]);
                }
            });
    }

    private function dropCustomerForeignKeys(): void
    {
        if (DB::getDriverName() === 'mysql') {
            collect(DB::select(
                "select constraint_name from information_schema.key_column_usage where table_schema = database() and table_name = 'spk' and column_name = 'customer_id' and referenced_table_name is not null"
            ))->each(function (object $foreignKey): void {
                $constraintName = str_replace('`', '``', $foreignKey->constraint_name ?? $foreignKey->CONSTRAINT_NAME);

                DB::statement("alter table `spk` drop foreign key `{$constraintName}`");
            });

            return;
        }

        try {
            Schema::table('spk', function (Blueprint $table): void {
                $table->dropForeign(['customer_id']);
            });
        } catch (Throwable) {
        }
    }
};
