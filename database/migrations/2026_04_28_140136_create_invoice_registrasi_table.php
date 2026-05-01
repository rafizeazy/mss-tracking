<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_registrasi', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to customer_services table
            $table->foreignId('service_id')->constrained('customer_services')->cascadeOnDelete();
            
            // Billing & Payment Data
            $table->string('invoice_number')->unique();
            $table->timestamp('invoice_generated_at')->nullable();
            $table->string('payment_proof_file_path')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_registrasi');
    }
};