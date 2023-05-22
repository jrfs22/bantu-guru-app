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
        Schema::create('data_referensi', function (Blueprint $table) {
            $table->id('data_referensi');
            $table->string('data_referensi_key');
            $table->string('data_referensi_value');
            $table->string('data_referensi_deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_referensi');
    }
};
