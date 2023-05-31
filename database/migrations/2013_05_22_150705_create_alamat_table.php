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
        Schema::create('alamat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kecamatan_id');
            $table->uuid('kota_id');
            $table->uuid('provinsi_id');
            $table->integer('kode_pos');
            $table->timestamps();

            $table->foreign('kecamatan_id')->references('id')->on('kecamatan');
            $table->foreign('kota_id')->references('id')->on('kota');
            $table->foreign('provinsi_id')->references('id')->on('provinsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};
