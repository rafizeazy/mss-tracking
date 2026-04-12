<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spk_id')->constrained()->cascadeOnDelete();
            
            $table->string('baa_number')->unique();
            
            // Data NOC
            $table->string('noc_name');
            $table->string('noc_position');
            $table->string('noc_department');
            $table->string('noc_location');
            $table->date('activation_date');
            
            // File Uploads
            $table->string('noc_signature_path')->nullable();
            $table->string('speedtest_image_path')->nullable();
            
            // Format JSON untuk input dinamis perangkat (Multi-row)
            $table->json('devices')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baas');
    }
};