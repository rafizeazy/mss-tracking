<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('customer_number')->nullable();
            
            // 1. Data Pendaftar
            $table->string('ktp_number', 16);
            $table->string('gender', 1)->nullable();
            $table->string('position')->nullable();
            $table->string('phone', 20);
            
            // 2. Data Perusahaan
            $table->string('company_name');
            $table->string('business_type')->nullable();
            $table->string('npwp_number')->nullable();
            $table->text('company_address');
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('company_phone')->nullable();
            
            // 3. Kontak Finance & Teknis 
            $table->string('finance_name')->nullable();
            $table->string('finance_email')->nullable();
            $table->string('finance_phone')->nullable();
            $table->text('billing_address')->nullable();
            
            $table->string('technical_name')->nullable();
            $table->string('technical_email')->nullable(); 
            $table->string('technical_phone')->nullable();
            $table->text('installation_address')->nullable();
            
            // 4. Layanan & File Pendukung
            $table->string('service_type')->default('Internet Dedicated 1:1');
            $table->string('bandwidth');
            $table->integer('term_of_service');
            $table->string('ktp_file_path')->nullable();
            $table->string('npwp_file_path')->nullable();
            $table->string('nib_file_path')->nullable();
            $table->string('certificate_file_path')->nullable();

            $table->decimal('monthly_fee', 15, 2)->nullable();
            $table->decimal('registration_fee', 15, 2)->nullable();
            $table->string('sla')->default('99.5%');
            $table->string('marketing_name')->nullable();
            $table->string('marketing_phone')->nullable();
            $table->string('payment_proof_file_path')->nullable();
            
            // 5. Status Workflow
            $table->string('status')->default('menunggu_verifikasi'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};