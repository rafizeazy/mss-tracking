<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_services', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to customers table
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            
            // Service Details
            $table->string('service_type')->default('Internet Dedicated 1:1');
            $table->string('bandwidth');
            $table->integer('term_of_service');
            $table->decimal('monthly_fee', 15, 2)->nullable();
            $table->decimal('registration_fee', 15, 2)->nullable();
            $table->string('sla')->default('99.5%');
            $table->string('metro_link')->nullable();
            
            // Installation Address
            $table->text('installation_address')->nullable();
            
            // Marketing Data
            $table->string('marketing_name')->nullable();
            $table->string('marketing_phone')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_services');
    }
};
