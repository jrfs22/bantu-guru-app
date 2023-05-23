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
            $table->id('id');
            $table->text('email')->unique();
            $table->text('password');
            $table->string('npa_pgri')->unique();
            $table->string('registrasi_bantu_guru');
            $table->string('nik');
            $table->text('nama_lengkap');
            $table->string('nip');
            $table->string('nuptk');
            $table->text('gelar_depan');
            $table->text('gelar_belakang');
            $table->unsignedBigInteger('status_pegawai_id');
            $table->unsignedBigInteger('jenis_pegawai_id');
            $table->unsignedBigInteger('golongan_id');
            $table->string('instansi');
            $table->string('no_hp');
            $table->unsignedBigInteger('alamat_id');
            $table->string('nama_alamat');
            $table->unsignedBigInteger('jenis_kelamin_id');
            $table->unsignedBigInteger('role_id');
            $table->text('gambar');
            $table->boolean('status');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('status_pegawai_id')->references('id')->on('data_referensi');
            $table->foreign('jenis_pegawai_id')->references('id')->on('data_referensi');
            $table->foreign('golongan_id')->references('id')->on('data_referensi');
            $table->foreign('jenis_kelamin_id')->references('id')->on('data_referensi');
            $table->foreign('role_id')->references('id')->on('data_referensi');
            $table->foreign('alamat_id')->references('id')->on('alamat');
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
