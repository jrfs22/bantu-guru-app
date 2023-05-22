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
        Schema::create('kegiatan_kompetensi', function (Blueprint $table) {
            $table->id('kegiatan_kompetensi_id');
            $table->string('kegiatan_kompetensi_nama');
            $table->date('kegiatan_kompetensi_tanggal_mulai');
            $table->date('kegiatan_kompetensi_tanggal_selesai');
            $table->time('kegiatan_kompetensi_jam_mulai');
            $table->time('kegiatan_kompetensi_jam_selesai');
            $table->string('kegiatan_kompetensi_tipe');
            $table->integer('kegiatan_kompetensi_max_peserta');
            $table->text('kegiatan_kompetensi_deskripsi');
            $table->text('kegiatan_kompetensi_foto');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_kompetensi');
    }
};
