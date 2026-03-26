<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk_tabel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('nik', 16)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->enum('pendidikan', [
                'Belum Sekolah', 'Tidak Sekolah', 'Tidak Tamat SD',
                'Tamat SD', 'Tamat SMP', 'Tamat SMA', 'SMK',
                'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3',
            ]);
            $table->string('pekerjaan', 50);
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->enum('kewarganegaraan', ['WNI', 'WNA'])->default('WNI');
            $table->string('no_paspor', 20)->nullable();
            $table->string('no_kitas', 20)->nullable();
            $table->char('nik_ayah', 16)->nullable();
            $table->char('nik_ibu', 16)->nullable();
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', '-'])->nullable();
            $table->string('foto', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk_tabel');
    }
};
