<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keluarga_tabel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('no_kk', 16)->unique();
            $table->uuid('kepala_keluarga_id')->nullable();
            $table->string('alamat', 255); // nomor rumah / detail lokasi
            $table->unsignedTinyInteger('rt')->default(12);
            $table->unsignedTinyInteger('rw')->default(5);
            $table->string('kelurahan', 50)->default('Liliba');
            $table->string('kecamatan', 50)->default('Oebobo');
            $table->string('kab_kota', 50)->default('Kota Kupang');
            $table->string('provinsi', 50)->default('Nusa Tenggara Timur');
            $table->char('kode_pos', 5)->nullable();
            $table->date('tanggal_dibuat');
            $table->timestamps();

            $table->foreign('kepala_keluarga_id')
                  ->references('id')
                  ->on('penduduk_tabel')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluarga_tabel');
    }
};
