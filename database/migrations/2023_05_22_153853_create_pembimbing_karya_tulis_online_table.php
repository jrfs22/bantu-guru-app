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
        Schema::create('pembimbing_karya_tulis_online', function (Blueprint $table) {
            $table->id('pembimbing_kto_id');
            $table->string('pembimbing_kto_unpa_pgri');
            $table->unsignedBigInteger('pembimbing_menu_id');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('pembimbing_kto_unpa_pgri')->references('user_npa_pgri')->on('users');
            $table->foreign('pembimbing_menu_id')->references('menu_pembimbing_karya_tulis_id')->on('menu_pembimbing_karya_tulis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbing_karya_tulis_online');
    }
};
