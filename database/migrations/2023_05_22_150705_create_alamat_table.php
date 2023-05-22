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
            $table->id('alamat_id');
            $table->unsignedBigInteger('alamat_kecamatan_id');
            $table->unsignedBigInteger('alamat_kota_id');
            $table->unsignedBigInteger('alamat_provinsi_id');
            $table->unsignedBigInteger('alamat_kode_pos');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('alamat_kecamatan_id')->references('kecamatan_id')->on('kecamatan');
            $table->foreign('alamat_kota_id')->references('kota_id')->on('kota');
            $table->foreign('alamat_provinsi_id')->references('provinsi_id')->on('provinsi');
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
