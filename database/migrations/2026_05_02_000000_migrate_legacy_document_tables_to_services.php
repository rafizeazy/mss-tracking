<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('spks') && ! Schema::hasTable('spk')) {
            Schema::rename('spks', 'spk');
        }

        if (Schema::hasTable('baas') && ! Schema::hasTable('baa')) {
            Schema::rename('baas', 'baa');
        }

        if (Schema::hasTable('spk') && ! Schema::hasColumn('spk', 'service_id')) {
            Schema::table('spk', function (Blueprint $table) {
                $table->foreignId('service_id')->nullable()->after('id')->constrained('customer_services')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('baa') && ! Schema::hasColumn('baa', 'service_id')) {
            Schema::table('baa', function (Blueprint $table) {
                $table->foreignId('service_id')->nullable()->after('id')->constrained('customer_services')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('spk') && Schema::hasColumn('spk', 'customer_id') && Schema::hasColumn('spk', 'service_id')) {
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

        if (Schema::hasTable('baa') && Schema::hasColumn('baa', 'service_id')) {
            DB::table('baa')
                ->whereNull('service_id')
                ->whereNotNull('spk_id')
                ->orderBy('id')
                ->get(['id', 'spk_id'])
                ->each(function (object $baa): void {
                    $serviceId = DB::table('spk')
                        ->where('id', $baa->spk_id)
                        ->value('service_id');

                    if ($serviceId) {
                        DB::table('baa')
                            ->where('id', $baa->id)
                            ->update(['service_id' => $serviceId]);
                    }
                });
        }

        if (Schema::hasTable('baa') && ! Schema::hasColumn('baa', 'signed_baa_path')) {
            Schema::table('baa', function (Blueprint $table) {
                $table->string('signed_baa_path')->nullable()->after('speedtest_image_path');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('baa') && ! Schema::hasTable('baas')) {
            Schema::rename('baa', 'baas');
        }

        if (Schema::hasTable('spk') && ! Schema::hasTable('spks')) {
            Schema::rename('spk', 'spks');
        }
    }
};
