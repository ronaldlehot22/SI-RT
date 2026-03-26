<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $namaLaki = [
            'Agus Salim', 'Budi Santoso', 'Candra Wijaya', 'Dani Pratama', 'Eko Susanto',
            'Fauzi Ramdan', 'Gunawan Hidayat', 'Hendra Kusuma', 'Irwan Setiawan', 'Joko Widodo',
            'Karel Neno', 'Lukas Banu', 'Mario Fernandez', 'Niko Saudale', 'Otto Pello',
            'Petrus Lende', 'Ricky Tae', 'Samuel Bana', 'Thomas Kase', 'Umbu Dima',
            'Viktor Lado', 'Willy Tefa', 'Yakob Rihi', 'Zacharias Elu', 'Abraham Djo',
            'Benediktus Sole', 'Constantinus Mau', 'Dominikus Beli', 'Eduardus Tadu', 'Florianus Ama',
        ];

        $namaPerempuan = [
            'Agustina Sari', 'Bertha Wulandari', 'Cecilia Ningrum', 'Dewi Lestari', 'Endang Rahayu',
            'Fatima Zahra', 'Grace Ndun', 'Helena Bano', 'Indah Permata', 'Juliana Kolo',
            'Katerina Nino', 'Lince Benu', 'Maria Magdalena', 'Natalia Tefa', 'Olivia Hana',
            'Paula Rihi', 'Rosa Lusi', 'Susana Dima', 'Theresia Elo', 'Ursula Bana',
            'Veronica Lado', 'Winda Saudale', 'Yolanda Kase', 'Zita Pello', 'Anna Beli',
            'Brigita Mau', 'Cornelia Sole', 'Dorothea Tadu', 'Elisabeth Ama', 'Fransiska Djo',
        ];

        $pekerjaan = [
            'Petani', 'Wiraswasta', 'PNS', 'Buruh Harian', 'Guru',
            'Pedagang', 'Nelayan', 'Honorer', 'Ibu Rumah Tangga', 'Pelajar/Mahasiswa',
            'TNI/Polri', 'Pensiunan', 'Tukang Bangunan', 'Sopir', 'Tidak Bekerja',
        ];

        $agama     = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];
        $pendidikan = ['Tidak Sekolah', 'Tamat SD', 'Tamat SMP', 'Tamat SMA', 'D3', 'S1'];
        $golDarah  = ['A', 'B', 'AB', 'O', '-'];
        $hubungan  = ['Istri', 'Anak', 'Anak', 'Anak', 'Orang Tua']; // weighted agar banyak anak

        $nikBase = 5371120101;
        $kkBase  = 5371121234;

        // Buat 50 penduduk kepala keluarga (laki-laki)
        $kepalaPenduduk = [];
        for ($i = 0; $i < 50; $i++) {
            $nama = $namaLaki[$i % count($namaLaki)];
            $tglLahir = now()->subYears(rand(30, 60))->subDays(rand(0, 365))->format('Y-m-d');

            $p = Penduduk::create([
                'nik'               => str_pad($nikBase + $i, 16, '0', STR_PAD_LEFT),
                'nama_lengkap'      => $nama,
                'tempat_lahir'      => collect(['Kupang', 'Rote', 'Timor', 'Flores', 'Sabu'])->random(),
                'tanggal_lahir'     => $tglLahir,
                'jenis_kelamin'     => 'L',
                'agama'             => collect($agama)->random(),
                'pendidikan'        => collect($pendidikan)->random(),
                'pekerjaan'         => collect($pekerjaan)->random(),
                'status_perkawinan' => 'Kawin',
                'kewarganegaraan'   => 'WNI',
                'golongan_darah'    => collect($golDarah)->random(),
            ]);
            $kepalaPenduduk[] = $p;
        }

        // Buat 50 KK, masing-masing punya 2-5 anggota
        foreach ($kepalaPenduduk as $idx => $kepala) {
            $kk = Keluarga::create([
                'no_kk'               => str_pad($kkBase + $idx, 16, '0', STR_PAD_LEFT),
                'kepala_keluarga_id'  => $kepala->id,
                'alamat'              => 'Jl. Nekamase No. ' . ($idx + 1),
                'rt'                  => 12,
                'rw'                  => 5,
                'kelurahan'           => 'Liliba',
                'kecamatan'           => 'Oebobo',
                'kab_kota'            => 'Kota Kupang',
                'provinsi'            => 'Nusa Tenggara Timur',
                'tanggal_dibuat'      => now()->subYears(rand(1, 10))->format('Y-m-d'),
            ]);

            // Tambah kepala ke anggota
            Anggota::create([
                'keluarga_id'       => $kk->id,
                'penduduk_id'       => $kepala->id,
                'hubungan_keluarga' => 'Kepala Keluarga',
                'status'            => 'aktif',
                'tanggal_masuk'     => $kk->tanggal_dibuat,
            ]);

            // Tambah istri
            $nikIstri = str_pad($nikBase + 1000 + $idx, 16, '0', STR_PAD_LEFT);
            $namaIstri = $namaPerempuan[$idx % count($namaPerempuan)];
            $istri = Penduduk::create([
                'nik'               => $nikIstri,
                'nama_lengkap'      => $namaIstri,
                'tempat_lahir'      => collect(['Kupang', 'Rote', 'Timor', 'Flores', 'Sabu'])->random(),
                'tanggal_lahir'     => now()->subYears(rand(25, 55))->subDays(rand(0, 365))->format('Y-m-d'),
                'jenis_kelamin'     => 'P',
                'agama'             => $kepala->agama,
                'pendidikan'        => collect($pendidikan)->random(),
                'pekerjaan'         => collect(['Ibu Rumah Tangga', 'Pedagang', 'Guru', 'PNS', 'Wiraswasta'])->random(),
                'status_perkawinan' => 'Kawin',
                'kewarganegaraan'   => 'WNI',
                'golongan_darah'    => collect($golDarah)->random(),
            ]);

            Anggota::create([
                'keluarga_id'       => $kk->id,
                'penduduk_id'       => $istri->id,
                'hubungan_keluarga' => 'Istri',
                'status'            => 'aktif',
                'tanggal_masuk'     => $kk->tanggal_dibuat,
            ]);

            // Tambah 1-3 anak
            $jumlahAnak = rand(1, 3);
            for ($j = 0; $j < $jumlahAnak; $j++) {
                $isLaki = rand(0, 1);
                $nikAnak = str_pad($nikBase + 2000 + ($idx * 3) + $j, 16, '0', STR_PAD_LEFT);
                $namaAnak = $isLaki
                    ? $namaLaki[($idx + $j + 5) % count($namaLaki)]
                    : $namaPerempuan[($idx + $j + 5) % count($namaPerempuan)];

                $anak = Penduduk::create([
                    'nik'               => $nikAnak,
                    'nama_lengkap'      => $namaAnak,
                    'tempat_lahir'      => 'Kupang',
                    'tanggal_lahir'     => now()->subYears(rand(1, 20))->subDays(rand(0, 365))->format('Y-m-d'),
                    'jenis_kelamin'     => $isLaki ? 'L' : 'P',
                    'agama'             => $kepala->agama,
                    'pendidikan'        => collect(['Belum Sekolah', 'Tamat SD', 'Tamat SMP', 'Tamat SMA'])->random(),
                    'pekerjaan'         => 'Pelajar/Mahasiswa',
                    'status_perkawinan' => 'Belum Kawin',
                    'kewarganegaraan'   => 'WNI',
                    'golongan_darah'    => collect($golDarah)->random(),
                ]);

                Anggota::create([
                    'keluarga_id'       => $kk->id,
                    'penduduk_id'       => $anak->id,
                    'hubungan_keluarga' => 'Anak',
                    'status'            => 'aktif',
                    'tanggal_masuk'     => $kk->tanggal_dibuat,
                ]);
            }
        }

        $this->command->info('✓ 50 KK dengan ±200 penduduk berhasil dibuat.');
    }
}
