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
            $table->uuid('id')->primary();
            $table->text('deskripsi');
            $table->uuid('list_bimbel_id');
            $table->uuid('user_id');
            $table->text('file');
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('list_bimbel_id')->references('id')->on('list_bimbel');
            $table->foreign('user_id')->references('id')->on('users');
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
