@extends('layouts.app')

@section('title', 'Detail Penduduk')
@section('header_title', 'Detail Penduduk')
@section('back')
@endsection
@section('back_url', route('penduduk.index'))

@section('header_action')
<a href="{{ route('penduduk.edit', $penduduk) }}"
   class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 text-white active:bg-white/20">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
    </svg>
</a>
@endsection

@section('content')
<div class="pb-6">

    {{-- Hero Card --}}
    <div class="bg-hijau-600 pt-4 pb-6 px-4 header-pattern relative rounded-b-3xl">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-2xl overflow-hidden bg-white/20 flex items-center justify-center flex-shrink-0 border-2 border-white/30">
                @if($penduduk->foto)
                    <img src="{{ asset('storage/'.$penduduk->foto) }}" class="w-full h-full object-cover" alt="">
                @else
                    <span class="text-white font-display font-bold text-3xl">
                        {{ strtoupper(substr($penduduk->nama_lengkap, 0, 1)) }}
                    </span>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="font-display font-bold text-white text-lg leading-tight">{{ $penduduk->nama_lengkap }}</h2>
                <p class="text-white/70 text-xs font-mono mt-1">{{ $penduduk->nik }}</p>
                <div class="flex gap-2 mt-2 flex-wrap">
                    <span class="px-2.5 py-1 bg-white/20 rounded-full text-white text-xs font-semibold">
                        {{ $penduduk->jenis_kelamin === 'L' ? '♂ Laki-laki' : '♀ Perempuan' }}
                    </span>
                    @if($penduduk->golongan_darah)
                    <span class="px-2.5 py-1 bg-white/20 rounded-full text-white text-xs font-semibold">
                        Gol. {{ $penduduk->golongan_darah }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Content pulled up --}}
    <div class="px-4 mt-0 space-y-3">

        {{-- KK Aktif --}}
        @php $kkAktif = $penduduk->keluargaAktif(); @endphp
        @if($kkAktif)
        <a href="{{ route('keluarga.show', $kkAktif->keluarga) }}"
           class="card-hover flex items-center gap-3 bg-white rounded-2xl p-4 shadow-sm border border-hijau-100 block">
            <div class="w-10 h-10 bg-hijau-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-hijau-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-[10px] text-hijau-500 font-semibold uppercase tracking-wide">KK Aktif</p>
                <p class="text-sm font-bold text-gray-800 font-mono">{{ $kkAktif->keluarga->no_kk }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Sebagai: <span class="font-semibold text-hijau-600">{{ $kkAktif->hubungan_keluarga }}</span></p>
            </div>
            <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        @else
        <div class="flex items-center gap-3 bg-amber-50 rounded-2xl p-4 border border-amber-100">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-sm text-amber-700 font-medium">Belum terdaftar di KK manapun</p>
        </div>
        @endif

        {{-- Data Pribadi --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
            <h3 class="font-display font-bold text-hijau-700 text-sm mb-3">Data Pribadi</h3>
            <div class="space-y-3">
                @php
                $rows = [
                    ['Tempat, Tgl Lahir', $penduduk->tempat_lahir.', '.($penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d/m/Y') : '-')],
                    ['Agama', $penduduk->agama],
                    ['Pendidikan', $penduduk->pendidikan],
                    ['Pekerjaan', $penduduk->pekerjaan],
                    ['Status Perkawinan', $penduduk->status_perkawinan],
                    ['Kewarganegaraan', $penduduk->kewarganegaraan],
                ];
                @endphp
                @foreach($rows as [$label, $val])
                <div class="flex justify-between items-start gap-3">
                    <span class="text-xs text-gray-400 font-medium flex-shrink-0 w-36">{{ $label }}</span>
                    <span class="text-xs text-gray-700 font-semibold text-right">{{ $val ?? '-' }}</span>
                </div>
                @if(!$loop->last)<div class="border-b border-gray-50"></div>@endif
                @endforeach
            </div>
        </div>

        @if($penduduk->kewarganegaraan === 'WNA')
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
            <h3 class="font-display font-bold text-hijau-700 text-sm mb-3">Dokumen WNA</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">No. Paspor</span>
                    <span class="text-xs font-mono font-semibold text-gray-700">{{ $penduduk->no_paspor ?? '-' }}</span>
                </div>
                <div class="border-b border-gray-50"></div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">No. KITAS/KITAP</span>
                    <span class="text-xs font-mono font-semibold text-gray-700">{{ $penduduk->no_kitas ?? '-' }}</span>
                </div>
            </div>
        </div>
        @endif

        @if($penduduk->nik_ayah || $penduduk->nik_ibu)
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
            <h3 class="font-display font-bold text-hijau-700 text-sm mb-3">Data Orang Tua</h3>
            <div class="space-y-3">
                @if($penduduk->nik_ayah)
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">NIK Ayah</span>
                    <span class="text-xs font-mono font-semibold text-gray-700">{{ $penduduk->nik_ayah }}</span>
                </div>
                @endif
                @if($penduduk->nik_ibu)
                @if($penduduk->nik_ayah)<div class="border-b border-gray-50"></div>@endif
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">NIK Ibu</span>
                    <span class="text-xs font-mono font-semibold text-gray-700">{{ $penduduk->nik_ibu }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Delete --}}
        <button type="button"
                onclick="bukaModalHapus('{{ route('penduduk.destroy', $penduduk) }}', 'Data penduduk ini akan dihapus secara permanen dan tidak bisa dikembalikan.')"
                class="w-full py-3.5 rounded-2xl border-2 border-red-200 text-red-500 text-sm font-bold active:bg-red-50 transition-colors">
            Hapus Data Penduduk
        </button>

    </div>
</div>
@endsection
