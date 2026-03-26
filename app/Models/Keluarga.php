<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keluarga extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'keluarga_tabel';

    protected $fillable = [
        'no_kk', 'kepala_keluarga_id', 'alamat', 'rt', 'rw',
        'kelurahan', 'kecamatan', 'kab_kota', 'provinsi',
        'kode_pos', 'tanggal_dibuat',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'date',
    ];

    public function kepalaKeluarga(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'kepala_keluarga_id');
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(Anggota::class, 'keluarga_id');
    }

    public function anggotaAktif(): HasMany
    {
        return $this->hasMany(Anggota::class, 'keluarga_id')->where('status', 'aktif');
    }
}
