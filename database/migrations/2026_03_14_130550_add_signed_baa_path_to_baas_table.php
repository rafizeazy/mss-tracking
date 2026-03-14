<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baas', function (Blueprint $table) {
            $table->string('signed_baa_path')->nullable()->after('speedtest_image_path');
        });
    }

    public function down(): void
    {
        Schema::table('baas', function (Blueprint $table) {
            $table->dropColumn('signed_baa_path');
        });
    }
};