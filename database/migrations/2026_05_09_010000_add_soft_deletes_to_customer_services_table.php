<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_services', function (Blueprint $table): void {
            if (! Schema::hasColumn('customer_services', 'deleted_at')) {
                $table->softDeletes()->after('updated_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_services', function (Blueprint $table): void {
            if (Schema::hasColumn('customer_services', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
