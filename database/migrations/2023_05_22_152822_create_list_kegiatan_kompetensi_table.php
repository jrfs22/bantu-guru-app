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
        Schema::create('list_kompetensi', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('kompetensi_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('status');
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
