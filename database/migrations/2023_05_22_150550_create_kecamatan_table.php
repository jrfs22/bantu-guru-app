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
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->id('kecamatan_id');
            $table->string('kecamatan_nama');
            $table->unsignedBigInteger('kecamatan_kota_id');
            $table->timestamps();

            $table->foreign('kecamatan_kota_id')->references('kota_id')->on('kota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
    }
};
