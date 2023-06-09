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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('email')->unique();
            $table->text('password')->nullable();
            $table->string('npa_pgri')->nullable();
            $table->string('nik')->nullable();
            $table->text('nama_lengkap');
            $table->string('nip')->nullable();
            $table->string('nuptk')->nullable();
            $table->text('gelar_depan')->nullable();
            $table->text('gelar_belakang')->nullable();
            $table->uuid('status_pegawai_id')->nullable();
            $table->uuid('jenis_pegawai_id')->nullable();
            $table->uuid('golongan_id')->nullable();
            $table->string('instansi')->nullable();
            $table->string('no_hp')->nullable();
            $table->uuid('jenis_kelamin_id')->nullable();
            $table->uuid('role_id')->nullable();
            $table->text('gambar');
            $table->boolean('status')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('status_pegawai_id')->references('id')->on('data_referensi');
            $table->foreign('jenis_pegawai_id')->references('id')->on('data_referensi');
            $table->foreign('golongan_id')->references('id')->on('data_referensi');
            $table->foreign('jenis_kelamin_id')->references('id')->on('data_referensi');
            $table->foreign('role_id')->references('id')->on('data_referensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
