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
        Schema::create('materi_bimbel', function (Blueprint $table) {
            $table->id('materi_bimbel_id');
            $table->text('materi_bimbel_deskripsi');
            $table->unsignedBigInteger('materi_list_bimbel_id');
            $table->string('materi_bimbel_user_npa_pgri');
            $table->text('materi_bimbel_file');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('materi_list_bimbel_id')->references('list_bimbel_id')->on('list_bimbel');
            $table->foreign('materi_bimbel_user_npa_pgri')->references('user_npa_pgri')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_bimbel');
    }
};
