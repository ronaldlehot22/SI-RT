<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penduduk extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'penduduk_tabel';

    protected $fillable = [
        'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'agama', 'pendidikan', 'pekerjaan',
        'status_perkawinan', 'kewarganegaraan', 'no_paspor',
        'no_kitas', 'nik_ayah', 'nik_ibu', 'golongan_darah', 'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function anggota(): HasMany
    {
        return $this->hasMany(Anggota::class, 'penduduk_id');
    }

    public function keluargaAktif()
    {
        return $this->anggota()
            ->where('status', 'aktif')
            ->with('keluarga')
            ->first();
    }
}
