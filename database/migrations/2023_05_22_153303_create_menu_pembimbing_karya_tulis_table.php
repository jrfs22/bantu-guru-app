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
        Schema::create('menu_pembimbing_karya_tulis', function (Blueprint $table) {
            $table->id('menu_pembimbing_karya_tulis_id');
            $table->string('menu_pembimbing_karya_tulis_nama');
            $table->text('menu_pembimbing_karya_tulis_gambar');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_pembimbing_karya_tulis');
    }
};
