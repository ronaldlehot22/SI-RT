@extends('layouts.app')

@section('title', 'Data Penduduk')
@section('header_title', 'Data Penduduk')

@section('content')
<div class="px-4 pt-4 pb-6">

    {{-- Search Bar --}}
    <div class="relative mb-4">
        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
            </svg>
        </div>
        <form method="GET" action="{{ route('penduduk.index') }}">
            <input type="text" name="q" value="{{ $q }}"
                   placeholder="Cari nama atau NIK..."
                   class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-medium placeholder-gray-400 shadow-sm">
        </form>
    </div>

    {{-- Stats Strip --}}
    <div class="flex gap-3 mb-5 overflow-x-auto no-scrollbar pb-1">
        <div class="flex-shrink-0 bg-hijau-600 text-white rounded-2xl px-4 py-3 min-w-[110px]">
            <p class="text-xs font-medium text-white/70">Total</p>
            <p class="text-2xl font-display font-bold">{{ $penduduk->total() }}</p>
            <p class="text-[10px] text-white/60 mt-0.5">Penduduk</p>
        </div>
        <div class="flex-shrink-0 bg-white rounded-2xl px-4 py-3 min-w-[110px] shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-400">Laki-laki</p>
            <p class="text-2xl font-display font-bold text-hijau-600">
                {{ \App\Models\Penduduk::where('jenis_kelamin','L')->count() }}
            </p>
            <p class="text-[10px] text-gray-400 mt-0.5">Jiwa</p>
        </div>
        <div class="flex-shrink-0 bg-white rounded-2xl px-4 py-3 min-w-[110px] shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-400">Perempuan</p>
            <p class="text-2xl font-display font-bold text-pink-500">
                {{ \App\Models\Penduduk::where('jenis_kelamin','P')->count() }}
            </p>
            <p class="text-[10px] text-gray-400 mt-0.5">Jiwa</p>
        </div>
    </div>

    {{-- List --}}
    @if($penduduk->isEmpty())
    <div class="text-center py-16">
        <div class="w-16 h-16 bg-hijau-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-hijau-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <p class="text-gray-500 font-medium">{{ $q ? 'Tidak ada hasil untuk "'.$q.'"' : 'Belum ada data penduduk' }}</p>
        <p class="text-gray-400 text-sm mt-1">{{ $q ? 'Coba kata kunci lain' : 'Tambahkan penduduk pertama' }}</p>
    </div>
    @else
    <div class="space-y-3">
        @foreach($penduduk as $p)
        <a href="{{ route('penduduk.show', $p) }}"
           class="card-hover flex items-center gap-3 bg-white rounded-2xl p-3.5 shadow-sm border border-gray-100 block">
            {{-- Avatar --}}
            <div class="w-12 h-12 rounded-xl flex-shrink-0 overflow-hidden bg-hijau-50 flex items-center justify-center">
                @if($p->foto)
                    <img src="{{ asset('storage/'.$p->foto) }}" class="w-full h-full object-cover" alt="">
                @else
                    <span class="text-hijau-600 font-display font-bold text-lg">
                        {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                    </span>
                @endif
            </div>
            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-800 text-sm truncate">{{ $p->nama_lengkap }}</p>
                <p class="text-xs text-gray-400 mt-0.5 font-mono">{{ $p->nik }}</p>
                <div class="flex items-center gap-2 mt-1.5">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold
                        {{ $p->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-500' }}">
                        {{ $p->jenis_kelamin === 'L' ? '♂ Laki-laki' : '♀ Perempuan' }}
                    </span>
                    @if($p->keluargaAktif())
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-hijau-50 text-hijau-600">
                        KK Aktif
                    </span>
                    @endif
                </div>
            </div>
            {{-- Arrow --}}
            <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($penduduk->hasPages())
    <div class="mt-6">
        {{ $penduduk->links('vendor.pagination.simple-tailwind') }}
    </div>
    @endif
    @endif
</div>

@endsection

@push('fab')
<a href="{{ route('penduduk.create') }}"
   class="fab-btn fixed bottom-24 right-4 w-14 h-14 text-white rounded-full shadow-xl flex items-center justify-center active:scale-95 transition-transform z-50"
   style="background-color:#1a5c38; box-shadow: 0 8px 24px rgba(26,92,56,0.4)">
    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
</a>
@endpush
