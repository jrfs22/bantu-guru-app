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
            $table->id('id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('kota_id');
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kode_pos');
            $table->rememberToken();
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
