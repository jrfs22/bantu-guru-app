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
        Schema::create('kegiatan_donasi', function (Blueprint $table) {
            $table->id('kegiatan_donasi_id');
            $table->string('kegiatan_donasi_nama');
            $table->text('kegiatan_donasi_deskripsi');
            $table->date('kegiatan_donasi_tanggal');
            $table->text('kegiatan_donasi_gambar');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_donasi');
    }
};
