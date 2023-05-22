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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->integer('laporan_judul');
            $table->integer('laporan_perihal');
            $table->string('laporan_user_nomor_pokok_anggota_pgri');
            $table->string('laporan_tujuan');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('laporan_user_nomor_pokok_anggota_pgri')->references('user_npa_pgri')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
