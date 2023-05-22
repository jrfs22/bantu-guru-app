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
        Schema::create('donasi', function (Blueprint $table) {
            $table->id('donasi_id');
            $table->string('donasi_user_npa_pgri');
            $table->unsignedBigInteger('donasi_kegiatan_donasi_id');
            $table->text('donasi_catatan');
            $table->integer('donasi_nominal');
            $table->text('donasi_bukti_pembayaran');
            $table->boolean('donasi_valid');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('donasi_user_npa_pgri')->references('user_npa_pgri')->on('users');
            $table->foreign('donasi_kegiatan_donasi_id')->references('kegiatan_donasi_id')->on('kegiatan_donasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
