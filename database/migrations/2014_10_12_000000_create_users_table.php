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
            $table->id('user_id');
            $table->text('user_email')->unique();
            $table->text('user_password');
            $table->string('user_npa_pgri')->unique();
            $table->string('user_registrasi_bantu_guru');
            $table->string('user_nik');
            $table->text('user_nama_lengkap');
            $table->string('user_nip');
            $table->string('user_nuptk');
            $table->text('user_gelar_depan');
            $table->text('user_gelar_belakang');
            $table->integer('user_status_pegawai_id');
            $table->integer('user_jenis_pegawai_id');
            $table->integer('user_golongan_id');
            $table->string('user_instansi');
            $table->string('user_no_hp');
            $table->integer('user_alamat_id');
            $table->string('user_nama_alamat');
            $table->integer('user_jenis_kelamin_id');
            $table->boolean('user_guru_or_masyarakat');
            $table->text('user_gambar');
            $table->boolean('status');
            $table->rememberToken();
            $table->timestamps();
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
