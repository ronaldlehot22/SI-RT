<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_tabel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('keluarga_id');
            $table->uuid('penduduk_id');
            $table->enum('hubungan_keluarga', [
                'Kepala Keluarga', 'Istri', 'Suami', 'Anak',
                'Menantu', 'Cucu', 'Orang Tua', 'Mertua',
                'Famili Lain', 'Pembantu', 'Lainnya',
            ]);
            $table->enum('status', ['aktif', 'pindah', 'meninggal', 'keluar'])->default('aktif');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->timestamps();

            $table->foreign('keluarga_id')
                  ->references('id')
                  ->on('keluarga_tabel')
                  ->cascadeOnDelete();

            $table->foreign('penduduk_id')
                  ->references('id')
                  ->on('penduduk_tabel')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_tabel');
    }
};
