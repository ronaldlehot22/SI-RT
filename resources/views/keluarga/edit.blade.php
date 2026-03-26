@extends('layouts.app')

@section('title', 'Edit KK')
@section('header_title', 'Edit Kartu Keluarga')
@section('back')
@endsection
@section('back_url', route('keluarga.show', $keluarga))

@section('content')
<form action="{{ route('keluarga.update', $keluarga) }}" method="POST" class="px-4 pt-4 pb-8 space-y-5">
    @csrf @method('PUT')

    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-display font-bold text-hijau-700 text-sm border-b border-gray-100 pb-2">Nomor KK</h3>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">No. Kartu Keluarga <span class="text-red-400">*</span></label>
            <input type="text" name="no_kk" value="{{ old('no_kk', $keluarga->no_kk) }}" maxlength="16" inputmode="numeric"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-mono bg-gray-50 @error('no_kk') border-red-400 @enderror">
            @error('no_kk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

    </div>

    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-display font-bold text-hijau-700 text-sm border-b border-gray-100 pb-2">Alamat</h3>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Alamat <span class="text-red-400">*</span></label>
            <input type="text" name="alamat" value="{{ old('alamat', $keluarga->alamat) }}"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm @error('alamat') border-red-400 @enderror">
            @error('alamat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">RT</label>
                <input type="number" name="rt" value="{{ old('rt', $keluarga->rt) }}"
                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-hijau-50 text-hijau-700 font-bold">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">RW</label>
                <input type="number" name="rw" value="{{ old('rw', $keluarga->rw) }}"
                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-hijau-50 text-hijau-700 font-bold">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kelurahan</label>
            <input type="text" name="kelurahan" value="{{ old('kelurahan', $keluarga->kelurahan) }}"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kecamatan</label>
            <input type="text" name="kecamatan" value="{{ old('kecamatan', $keluarga->kecamatan) }}"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kab/Kota</label>
            <input type="text" name="kab_kota" value="{{ old('kab_kota', $keluarga->kab_kota) }}"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Provinsi</label>
            <input type="text" name="provinsi" value="{{ old('provinsi', $keluarga->provinsi) }}"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kode Pos</label>
            <input type="text" name="kode_pos" value="{{ old('kode_pos', $keluarga->kode_pos) }}" maxlength="5" inputmode="numeric"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-mono">
        </div>
    </div>

    <button type="submit"
            class="w-full bg-hijau-600 text-white font-bold py-4 rounded-2xl shadow-lg active:scale-95 transition-transform"
            style="box-shadow: 0 6px 20px rgba(26,92,56,0.35)">
        Simpan Perubahan
    </button>
    <a href="{{ route('keluarga.show', $keluarga) }}"
       class="block w-full text-center text-gray-400 text-sm font-medium py-2">Batal</a>
</form>
@endsection
