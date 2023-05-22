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
        Schema::create('list_kegiatan_kompetensi', function (Blueprint $table) {
            $table->id('list_kegiatan_kompetensi_id');
            $table->unsignedBigInteger('list_kegiatan_kompe_kegiatan_id');
            $table->string('list_kegiatan_user_npa_pgri');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('list_kegiatan_kompe_kegiatan_id')->references('kegiatan_kompetensi_id')->on('kegiatan_kompetensi');
            $table->foreign('list_kegiatan_user_npa_pgri')->references('user_npa_pgri')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_kegiatan_kompetensi');
    }
};
