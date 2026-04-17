<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('request_number')->unique();
            $table->enum('request_type', ['Upgrade', 'Downgrade', 'Terminate']);
            
            $table->string('old_bandwidth')->nullable();
            $table->string('new_bandwidth')->nullable();
            $table->decimal('new_monthly_fee', 15, 2)->nullable(); 
            
            $table->string('metro_vendor')->nullable();
            $table->date('deadline_date')->nullable();
            
            $table->date('stop_date')->nullable();
            $table->text('reason')->nullable();
            
            $table->string('status')->default('menunggu_pelanggan'); 
            
            $table->string('unsigned_pdf_path')->nullable(); 
            $table->string('signed_pdf_path')->nullable(); 
            $table->string('spk_pdf_path')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};