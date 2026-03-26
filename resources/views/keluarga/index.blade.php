@extends('layouts.app')

@section('title', 'Data Keluarga')
@section('header_title', 'Data Keluarga (KK)')

@section('content')
<div class="px-4 pt-4 pb-6">

    {{-- Search Bar --}}
    <div class="relative mb-4">
        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
            </svg>
        </div>
        <form method="GET" action="{{ route('keluarga.index') }}">
            <input type="text" name="q" value="{{ $q }}"
                   placeholder="Cari No. KK atau nama kepala keluarga..."
                   class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-medium placeholder-gray-400 shadow-sm">
        </form>
    </div>

    {{-- Stats --}}
    <div class="flex gap-3 mb-5 overflow-x-auto no-scrollbar pb-1">
        <div class="flex-shrink-0 bg-hijau-600 text-white rounded-2xl px-4 py-3 min-w-[110px]">
            <p class="text-xs font-medium text-white/70">Total KK</p>
            <p class="text-2xl font-display font-bold">{{ $keluarga->total() }}</p>
            <p class="text-[10px] text-white/60 mt-0.5">Kartu Keluarga</p>
        </div>
        <div class="flex-shrink-0 bg-white rounded-2xl px-4 py-3 min-w-[120px] shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-400">RT / RW</p>
            <p class="text-xl font-display font-bold text-hijau-600">012 / 005</p>
            <p class="text-[10px] text-gray-400 mt-0.5">Nekamase</p>
        </div>
    </div>

    {{-- List --}}
    @if($keluarga->isEmpty())
    <div class="text-center py-16">
        <div class="w-16 h-16 bg-hijau-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-hijau-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <p class="text-gray-500 font-medium">{{ $q ? 'Tidak ada hasil untuk "'.$q.'"' : 'Belum ada data keluarga' }}</p>
        <p class="text-gray-400 text-sm mt-1">{{ $q ? 'Coba kata kunci lain' : 'Tambahkan KK pertama' }}</p>
    </div>
    @else
    <div class="space-y-3">
        @foreach($keluarga as $kk)
        <a href="{{ route('keluarga.show', $kk) }}"
           class="card-hover block bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between gap-3 mb-3">
                <div>
                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wide">No. KK</p>
                    <p class="font-mono font-bold text-gray-800 text-base mt-0.5">{{ $kk->no_kk }}</p>
                </div>
                <span class="flex-shrink-0 px-2.5 py-1 bg-hijau-50 text-hijau-600 rounded-full text-xs font-bold">
                    {{ $kk->anggota_count }} jiwa
                </span>
            </div>
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-hijau-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400">Kepala Keluarga</p>
                    <p class="text-sm font-semibold text-gray-800 truncate">
                        {{ $kk->kepalaKeluarga?->nama_lengkap ?? '-' }}
                    </p>
                </div>
                <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-50">
                <p class="text-xs text-gray-400 truncate">
                    <span class="font-medium">{{ $kk->alamat }}</span>,
                    RT {{ str_pad($kk->rt, 3, '0', STR_PAD_LEFT) }}/RW {{ str_pad($kk->rw, 3, '0', STR_PAD_LEFT) }}
                </p>
            </div>
        </a>
        @endforeach
    </div>

    @if($keluarga->hasPages())
    <div class="mt-6">
        {{ $keluarga->links('vendor.pagination.simple-tailwind') }}
    </div>
    @endif
    @endif
</div>

@endsection

@push('fab')
<a href="{{ route('keluarga.create') }}"
   class="fab-btn fixed bottom-24 right-4 w-14 h-14 text-white rounded-full shadow-xl flex items-center justify-center active:scale-95 transition-transform z-50"
   style="background-color:#1a5c38; box-shadow: 0 8px 24px rgba(26,92,56,0.4)">
    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
</a>
@endpush
