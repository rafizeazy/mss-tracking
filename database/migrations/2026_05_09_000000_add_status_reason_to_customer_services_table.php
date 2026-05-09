<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_services', function (Blueprint $table) {
            if (! Schema::hasColumn('customer_services', 'status')) {
                $table->string('status')->default('menunggu_verifikasi')->after('installation_address');
            }

            if (! Schema::hasColumn('customer_services', 'status_reason')) {
                $table->text('status_reason')->nullable()->after('status');
            }

            if (! Schema::hasColumn('customer_services', 'status_reason_at')) {
                $table->timestamp('status_reason_at')->nullable()->after('status_reason');
            }
        });

        if (Schema::hasColumn('customers', 'status')) {
            DB::table('customer_services')
                ->orderBy('id')
                ->get(['id', 'customer_id'])
                ->each(function (object $service): void {
                    $customer = DB::table('customers')->where('id', $service->customer_id)->first();

                    if (! $customer) {
                        return;
                    }

                    DB::table('customer_services')
                        ->where('id', $service->id)
                        ->update([
                            'status' => $customer->status,
                            'status_reason' => Schema::hasColumn('customers', 'status_reason') ? $customer->status_reason : null,
                            'status_reason_at' => Schema::hasColumn('customers', 'status_reason_at') ? $customer->status_reason_at : null,
                        ]);
                });
        }
    }

    public function down(): void
    {
        Schema::table('customer_services', function (Blueprint $table) {
            if (Schema::hasColumn('customer_services', 'status_reason_at')) {
                $table->dropColumn('status_reason_at');
            }

            if (Schema::hasColumn('customer_services', 'status_reason')) {
                $table->dropColumn('status_reason');
            }

            if (Schema::hasColumn('customer_services', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
