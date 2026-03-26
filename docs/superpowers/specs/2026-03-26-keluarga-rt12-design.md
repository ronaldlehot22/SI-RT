# Desain Sistem Data Keluarga RT 12

**Tanggal:** 2026-03-26
**Proyek:** Si-RT (Sistem Informasi RT)
**Scope:** Struktur tabel untuk menampung data keluarga di RT 12, mengikuti format Kartu Keluarga (KK) resmi Indonesia.

---

## Ringkasan

Sistem menggunakan 3 tabel yang sudah ada di project:
- `penduduk_tabel` — master data semua individu
- `keluarga_tabel` — header Kartu Keluarga (KK)
- `anggota_tabel` — tabel pivot yang menghubungkan individu ke KK beserta hubungan keluarganya

Semua tabel menggunakan UUID sebagai primary key.

---

## Struktur Tabel

### 1. `penduduk_tabel` (Master Individu)

Master data untuk semua individu, baik kepala keluarga maupun anggota keluarga.

| Kolom | Tipe | Nullable | Keterangan |
|---|---|---|---|
| `id` | uuid PK | No | Primary key UUID |
| `nik` | char(16) UNIQUE | No | NIK 16 digit |
| `nama_lengkap` | varchar(100) | No | Nama lengkap sesuai KK |
| `tempat_lahir` | varchar(50) | No | Kota/kabupaten tempat lahir |
| `tanggal_lahir` | date | No | |
| `jenis_kelamin` | enum('L','P') | No | L = Laki-laki, P = Perempuan |
| `agama` | enum | No | Islam/Kristen/Katolik/Hindu/Buddha/Konghucu |
| `pendidikan` | enum | No | Belum Sekolah/Tidak Sekolah/Tidak Tamat SD/Tamat SD/Tamat SMP/Tamat SMU/SMK/D1/D2/D3/D4/S1/S2/S3 |
| `pekerjaan` | varchar(50) | No | |
| `status_perkawinan` | enum | No | Belum Kawin/Kawin/Cerai Hidup/Cerai Mati (Belum Kawin berlaku untuk anak/remaja) |
| `kewarganegaraan` | enum('WNI','WNA') | No | Default: WNI |
| `no_paspor` | varchar(20) | Yes | Untuk WNA |
| `no_kitas` | varchar(20) | Yes | Nomor KITAS/KITAP untuk WNA |
| `nik_ayah` | char(16) | Yes | Merujuk ke kolom `nik` (bukan `id`) — bisa diisi meski ayah belum terdaftar |
| `nik_ibu` | char(16) | Yes | Merujuk ke kolom `nik` (bukan `id`) — bisa diisi meski ibu belum terdaftar |
| `golongan_darah` | enum('A','B','AB','O','-') | Yes | Golongan darah (nullable jika tidak diketahui) |
| `foto` | varchar(255) | Yes | Path file foto |
| `created_at` | timestamp | — | Dikelola otomatis oleh `$table->timestamps()` |
| `updated_at` | timestamp | — | Dikelola otomatis oleh `$table->timestamps()` |

---

### 2. `keluarga_tabel` (Header Kartu Keluarga)

Satu record = satu KK. Menyimpan nomor KK, informasi alamat, dan referensi langsung ke kepala keluarga.

| Kolom | Tipe | Nullable | Keterangan |
|---|---|---|---|
| `id` | uuid PK | No | Primary key UUID |
| `no_kk` | char(16) UNIQUE | No | Nomor Kartu Keluarga 16 digit |
| `kepala_keluarga_id` | uuid FK | Yes | → `penduduk_tabel.id` (nullable saat KK baru dibuat, sebelum anggota ditambahkan) |
| `alamat` | varchar(255) | No | Alamat lengkap |
| `rt` | tinyint unsigned | No | Default: 12 (`unsignedTinyInteger`) |
| `rw` | tinyint unsigned | No | Default: 5 (`unsignedTinyInteger`) |
| `kelurahan` | varchar(50) | No | Default: 'Liliba' |
| `kecamatan` | varchar(50) | No | Default: 'Oebobo' |
| `kab_kota` | varchar(50) | No | Default: 'Kota Kupang' |
| `provinsi` | varchar(50) | No | Default: 'Nusa Tenggara Timur' |
| `kode_pos` | char(5) | Yes | |
| `tanggal_dibuat` | date | No | Tanggal penerbitan KK |
| `created_at` | timestamp | — | Dikelola otomatis oleh `$table->timestamps()` |
| `updated_at` | timestamp | — | Dikelola otomatis oleh `$table->timestamps()` |

---

### 3. `anggota_tabel` (Pivot KK ↔ Penduduk)

Menghubungkan individu ke KK. Satu individu hanya boleh memiliki satu record dengan status `aktif` di satu KK pada satu waktu.

| Kolom | Tipe | Nullable | Keterangan |
|---|---|---|---|
| `id` | uuid PK | No | Primary key UUID |
| `keluarga_id` | uuid FK | No | → `keluarga_tabel.id` |
| `penduduk_id` | uuid FK | No | → `penduduk_tabel.id` |
| `hubungan_keluarga` | enum | No | Kepala Keluarga/Istri/Suami/Anak/Menantu/Cucu/Orang Tua/Mertua/Famili Lain/Pembantu/Lainnya |
| `status` | enum | No | aktif/pindah/meninggal/keluar — Default: aktif |
| `tanggal_masuk` | date | No | Tanggal bergabung ke KK ini |
| `tanggal_keluar` | date | Yes | Tanggal keluar/pindah/meninggal (diisi saat status berubah dari aktif) |
| `created_at` | timestamp | — | Dikelola otomatis oleh `$table->timestamps()` |
| `updated_at` | timestamp | — | Dikelola otomatis oleh `$table->timestamps()` |

**Keterangan status:**
- `aktif` — terdaftar aktif di KK ini
- `pindah` — sudah pindah ke KK lain (record lama dipertahankan untuk riwayat)
- `meninggal` — anggota telah meninggal dunia
- `keluar` — keluar dari RT tanpa dokumen pindah resmi

---

## Relasi Antar Tabel

```
keluarga_tabel (1) ──── (N) anggota_tabel (N) ──── (1) penduduk_tabel
      │
      └── kepala_keluarga_id ──────────────────────── (1) penduduk_tabel
```

- Satu KK memiliki banyak anggota (`keluarga_tabel` → `anggota_tabel`)
- Satu penduduk bisa terdaftar di banyak KK dengan status berbeda (`penduduk_tabel` → `anggota_tabel`)
- Kepala Keluarga disimpan di dua tempat: sebagai FK langsung `kepala_keluarga_id` di `keluarga_tabel`, dan sebagai record `hubungan_keluarga = 'Kepala Keluarga'` di `anggota_tabel`

---

## Aturan Bisnis

1. **Satu KK aktif per penduduk:** Satu `penduduk_id` hanya boleh memiliki satu record `status = 'aktif'` di `anggota_tabel`. Validasi dilakukan di application layer dalam sebuah database transaction sebelum insert untuk mencegah race condition. MySQL tidak mendukung partial unique index, sehingga tidak ada constraint database-level untuk ini.
2. **Pindah KK:** Ubah status record lama menjadi `pindah` dan isi `tanggal_keluar`, lalu buat record baru di KK tujuan dengan status `aktif` dan `tanggal_masuk` baru. Lakukan dalam satu transaction.
3. **Alamat default:** Semua keluarga berada di RT 012/RW 005, Kel. Liliba, Kec. Oebobo, Kota Kupang, Prov. Nusa Tenggara Timur. Kolom-kolom ini sudah diisi default value di migration. Kolom `alamat` tetap wajib diisi (nomor rumah / detail lokasi spesifik).
4. **Konsistensi kepala keluarga:** `keluarga_tabel.kepala_keluarga_id` dan record `hubungan_keluarga = 'Kepala Keluarga'` di `anggota_tabel` harus selalu menunjuk ke orang yang sama. Setiap kali salah satu diupdate, keduanya harus diupdate bersamaan dalam satu transaction.

---

## Catatan Implementasi Laravel

- **UUID di migration:** `$table->uuid('id')->primary()`
- **UUID di Model:** Setiap Model wajib menggunakan trait `HasUuids` (Laravel 9+). Trait ini secara otomatis mengatur `$keyType = 'string'` dan `$incrementing = false`, sehingga keduanya tidak perlu ditulis manual.
  ```php
  use Illuminate\Database\Eloquent\Concerns\HasUuids;

  class NamaModel extends Model {
      use HasUuids;
  }
  ```
- **Timestamps:** Gunakan `$table->timestamps()` di migration (bukan kolom manual). Eloquent mengisi otomatis.
- **Self-reference NIK:** `nik_ayah` dan `nik_ibu` di `penduduk_tabel` merujuk ke kolom `nik` (bukan `id`) agar tetap bisa diisi meskipun orang tua belum terdaftar di sistem.
