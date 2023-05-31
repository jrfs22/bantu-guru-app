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
            $table->uuid('id')->primary();
            $table->text('nama');
            $table->text('gambar');
            $table->uuid('user_id');
            $table->integer('view')->nullable();
            $table->boolean('status')->default(0);
            $table->uuid('validasi_by')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('validasi_by')->references('id')->on('users');
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
