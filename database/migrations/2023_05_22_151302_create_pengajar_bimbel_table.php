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
        Schema::create('pengajar_bimbel', function (Blueprint $table) {
            $table->id('pengajar_bimbel_id');
            $table->string('pengajar_bimbel_user_npa_pgri');
            $table->unsignedBigInteger('pengajar_bimbel_list_bimbel_id');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('pengajar_bimbel_user_npa_pgri')->references('user_npa_pgri')->on('users');
            $table->foreign('pengajar_bimbel_list_bimbel_id')->references('list_bimbel_id')->on('list_bimbel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajar_bimbel');
    }
};
