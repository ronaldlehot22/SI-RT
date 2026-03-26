<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $penduduk = Penduduk::when($q, function ($query) use ($q) {
                $query->where('nama_lengkap', 'like', "%{$q}%")
                      ->orWhere('nik', 'like', "%{$q}%");
            })
            ->orderBy('nama_lengkap')
            ->paginate(15)
            ->withQueryString();

        return view('penduduk.index', compact('penduduk', 'q'));
    }

    public function create()
    {
        return view('penduduk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'               => 'required|digits:16|unique:penduduk_tabel,nik',
            'nama_lengkap'      => 'required|string|max:100',
            'tempat_lahir'      => 'required|string|max:50',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|in:L,P',
            'agama'             => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pendidikan'        => 'required|string',
            'pekerjaan'         => 'required|string|max:50',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan'   => 'required|in:WNI,WNA',
            'no_paspor'         => 'nullable|string|max:20',
            'no_kitas'          => 'nullable|string|max:20',
            'nik_ayah'          => 'nullable|digits:16',
            'nik_ibu'           => 'nullable|digits:16',
            'golongan_darah'    => 'nullable|in:A,B,AB,O,-',
            'foto'              => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-penduduk', 'public');
        }

        Penduduk::create($validated);

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function show(Penduduk $penduduk)
    {
        $penduduk->load('anggota.keluarga');
        return view('penduduk.show', compact('penduduk'));
    }

    public function edit(Penduduk $penduduk)
    {
        return view('penduduk.edit', compact('penduduk'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik'               => 'required|digits:16|unique:penduduk_tabel,nik,' . $penduduk->id,
            'nama_lengkap'      => 'required|string|max:100',
            'tempat_lahir'      => 'required|string|max:50',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|in:L,P',
            'agama'             => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pendidikan'        => 'required|string',
            'pekerjaan'         => 'required|string|max:50',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan'   => 'required|in:WNI,WNA',
            'no_paspor'         => 'nullable|string|max:20',
            'no_kitas'          => 'nullable|string|max:20',
            'nik_ayah'          => 'nullable|digits:16',
            'nik_ibu'           => 'nullable|digits:16',
            'golongan_darah'    => 'nullable|in:A,B,AB,O,-',
            'foto'              => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-penduduk', 'public');
        }

        $penduduk->update($validated);

        return redirect()->route('penduduk.show', $penduduk)->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }
}
