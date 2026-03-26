<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeluargaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $keluarga = Keluarga::with('kepalaKeluarga')
            ->withCount(['anggota' => fn($query) => $query->where('status', 'aktif')])
            ->when($q, function ($query) use ($q) {
                $query->where('no_kk', 'like', "%{$q}%")
                      ->orWhereHas('kepalaKeluarga', fn($sub) =>
                          $sub->where('nama_lengkap', 'like', "%{$q}%")
                      );
            })
            ->orderBy('no_kk')
            ->paginate(15)
            ->withQueryString();

        return view('keluarga.index', compact('keluarga', 'q'));
    }

    public function create()
    {
        $penduduk = Penduduk::orderBy('nama_lengkap')->get();
        return view('keluarga.create', compact('penduduk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk'       => 'required|digits:16|unique:keluarga_tabel,no_kk',
            'alamat'      => 'required|string|max:255',
            'rt'          => 'required|integer|min:1',
            'rw'          => 'required|integer|min:1',
            'kelurahan'   => 'required|string|max:50',
            'kecamatan'   => 'required|string|max:50',
            'kab_kota'    => 'required|string|max:50',
            'provinsi'    => 'required|string|max:50',
            'kode_pos'    => 'nullable|digits:5',
        ]);

        $validated['tanggal_dibuat'] = now()->toDateString();

        Keluarga::create($validated);

        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil ditambahkan.');
    }

    public function show(Keluarga $keluarga)
    {
        $keluarga->load('kepalaKeluarga', 'anggotaAktif.penduduk');
        return view('keluarga.show', compact('keluarga'));
    }

    public function edit(Keluarga $keluarga)
    {
        $penduduk = Penduduk::orderBy('nama_lengkap')->get();
        return view('keluarga.edit', compact('keluarga', 'penduduk'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'no_kk'       => 'required|digits:16|unique:keluarga_tabel,no_kk,' . $keluarga->id,
            'alamat'      => 'required|string|max:255',
            'rt'          => 'required|integer|min:1',
            'rw'          => 'required|integer|min:1',
            'kelurahan'   => 'required|string|max:50',
            'kecamatan'   => 'required|string|max:50',
            'kab_kota'    => 'required|string|max:50',
            'provinsi'    => 'required|string|max:50',
            'kode_pos'    => 'nullable|digits:5',
        ]);

        $keluarga->update($validated);

        return redirect()->route('keluarga.show', $keluarga)->with('success', 'Data keluarga berhasil diperbarui.');
    }

    public function destroy(Keluarga $keluarga)
    {
        $keluarga->delete();
        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil dihapus.');
    }

    // Tambah anggota ke KK
    public function tambahAnggota(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'penduduk_id'       => 'required|uuid|exists:penduduk_tabel,id',
            'hubungan_keluarga' => 'required|string',
            'tanggal_masuk'     => 'required|date',
        ]);

        DB::transaction(function () use ($keluarga, $validated, $request) {
            // Pastikan penduduk belum aktif di KK lain
            $sudahAktif = Anggota::where('penduduk_id', $validated['penduduk_id'])
                ->where('status', 'aktif')
                ->exists();

            abort_if($sudahAktif, 422, 'Penduduk ini sudah terdaftar aktif di KK lain.');

            $anggota = $keluarga->anggota()->create([
                'penduduk_id'       => $validated['penduduk_id'],
                'hubungan_keluarga' => $validated['hubungan_keluarga'],
                'status'            => 'aktif',
                'tanggal_masuk'     => $validated['tanggal_masuk'],
            ]);

            // Sync kepala keluarga
            if ($validated['hubungan_keluarga'] === 'Kepala Keluarga') {
                $keluarga->update(['kepala_keluarga_id' => $validated['penduduk_id']]);
            }
        });

        return redirect()->route('keluarga.show', $keluarga)->with('success', 'Anggota berhasil ditambahkan.');
    }

    // Pindahkan anggota keluar dari KK
    public function keluarAnggota(Request $request, Keluarga $keluarga, Anggota $anggota)
    {
        $validated = $request->validate([
            'status'         => 'required|in:pindah,meninggal,keluar',
            'tanggal_keluar' => 'required|date',
        ]);

        DB::transaction(function () use ($keluarga, $anggota, $validated) {
            $anggota->update([
                'status'         => $validated['status'],
                'tanggal_keluar' => $validated['tanggal_keluar'],
            ]);

            // Jika kepala keluarga yang keluar, kosongkan referensi
            if ($keluarga->kepala_keluarga_id === $anggota->penduduk_id) {
                $keluarga->update(['kepala_keluarga_id' => null]);
            }
        });

        return redirect()->route('keluarga.show', $keluarga)->with('success', 'Status anggota berhasil diperbarui.');
    }
}
