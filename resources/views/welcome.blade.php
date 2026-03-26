@extends('layouts.app')

@section('title', 'Si-RT 12 Nekamase')
@section('header_title', 'Si-RT 12 Nekamase')

@section('content')
<div class="px-4 pt-4 pb-6">

    {{-- Welcome Banner --}}
    <div class="bg-hijau-600 rounded-2xl p-5 mb-5 relative overflow-hidden header-pattern"
         style="box-shadow: 0 8px 32px rgba(26,92,56,0.3)">
        <div class="relative z-10">
            <p class="text-white/70 text-xs font-semibold uppercase tracking-widest">Selamat Datang di</p>
            <h2 class="font-display font-bold text-white text-2xl mt-1 leading-tight">
                Sistem Informasi<br>RT 12 Nekamase
            </h2>
            <p class="text-white/60 text-xs mt-2">Kel. Liliba · Kec. Oebobo · Kota Kupang · NTT</p>
        </div>
        <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-white/5 rounded-full"></div>
        <div class="absolute -right-8 -top-8 w-36 h-36 bg-white/5 rounded-full"></div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-2 gap-3 mb-5">
        <a href="{{ route('penduduk.index') }}"
           class="card-hover bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-display font-bold text-gray-800">{{ \App\Models\Penduduk::count() }}</p>
                <p class="text-xs text-gray-400 font-medium">Penduduk</p>
            </div>
        </a>

        <a href="{{ route('keluarga.index') }}"
           class="card-hover bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-hijau-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-hijau-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-display font-bold text-gray-800">{{ \App\Models\Keluarga::count() }}</p>
                <p class="text-xs text-gray-400 font-medium">Kartu Keluarga</p>
            </div>
        </a>
    </div>

    {{-- Quick Actions --}}
    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Aksi Cepat</p>
    <div class="grid grid-cols-2 gap-3">
        <a href="{{ route('penduduk.create') }}"
           class="card-hover bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col gap-3">
            <div class="w-10 h-10 bg-hijau-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Tambah Penduduk</p>
                <p class="text-xs text-gray-400 mt-0.5">Daftarkan warga baru</p>
            </div>
        </a>

        <a href="{{ route('keluarga.create') }}"
           class="card-hover bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col gap-3">
            <div class="w-10 h-10 bg-hijau-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Tambah KK</p>
                <p class="text-xs text-gray-400 mt-0.5">Buat Kartu Keluarga</p>
            </div>
        </a>
    </div>

    {{-- Info strip --}}
    <div class="mt-5 bg-hijau-50 rounded-2xl p-4 border border-hijau-100">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-hijau-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-xs font-bold text-hijau-700">Wilayah RT 012 / RW 005</p>
                <p class="text-xs text-hijau-600 mt-0.5">Kel. Liliba, Kec. Oebobo, Kota Kupang, Nusa Tenggara Timur</p>
            </div>
        </div>
    </div>
</div>
@endsection
