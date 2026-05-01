<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // baa
        Schema::create('baa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('customer_services')->cascadeOnDelete();
            $table->foreignId('spk_id')->constrained('spk')->cascadeOnDelete();
            $table->string('baa_number')->unique();
            
            // NOC Data
            $table->string('noc_name');
            $table->string('noc_position');
            $table->string('noc_department');
            $table->string('noc_location');
            $table->date('activation_date');
            
            // File Uploads
            $table->string('noc_signature_path')->nullable();
            $table->string('speedtest_image_path')->nullable();
            $table->string('signed_baa_path')->nullable();
            
            // Device Data (multi-row JSON)
            $table->json('devices')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baa');
    }
};