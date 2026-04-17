<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->date('upgrade_date');
            $table->string('noc_pic_name');
            $table->string('noc_signature_path');
            $table->string('speedtest_image_path');
            
            $table->string('unsigned_bau_path')->nullable(); 
            $table->string('signed_bau_path')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baus');
    }
};