<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->after('marketing_phone');
            $table->timestamp('invoice_generated_at')->nullable()->after('invoice_number');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['invoice_number', 'invoice_generated_at']);
        });
    }
};
