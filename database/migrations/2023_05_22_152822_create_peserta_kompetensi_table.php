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
        Schema::create('peserta_kompetensi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kompetensi_id');
            $table->uuid('user_id');
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('kompetensi_id')->references('id')->on('kompetensi');
            $table->foreign('user_id')->references('id')->on('users');
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
