<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('customers', 'sla') && ! Schema::hasColumn('customers', 'jalur_metro')) {
            Schema::table('customers', function (Blueprint $table): void {
                $table->string('jalur_metro')->nullable()->after('sla');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('customers', 'jalur_metro')) {
            Schema::table('customers', function (Blueprint $table): void {
                $table->dropColumn('jalur_metro');
            });
        }
    }
};
