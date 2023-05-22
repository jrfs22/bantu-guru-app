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
        Schema::create('lowongan_kerja', function (Blueprint $table) {
            $table->id('lowongan_kerja_id');
            $table->text('lowongan_kerja_nama');
            $table->text('lowongan_kerja_file');
            $table->string('lowongan_kerja_user_npa_pgri');
            $table->integer('lowongan_kerja_view');
            $table->boolean('status');
            $table->string('lowongan_kerja_validasi_by');
            $table->timestamps();

            $table->foreign('lowongan_kerja_user_npa_pgri')->references('user_npa_pgri')->on('users');
            $table->foreign('lowongan_kerja_validasi_by')->references('user_npa_pgri')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan_kerja');
    }
};
