@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('header_title', 'Tambah Pengguna')
@section('back')
@endsection
@section('back_url', route('users.index'))

@section('content')
<form action="{{ route('users.store') }}" method="POST" class="px-4 pt-4 pb-8 space-y-5">
    @csrf

    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-display font-bold text-hijau-700 text-sm border-b border-gray-100 pb-2">Data Akun</h3>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}"
                   placeholder="Nama pengguna"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm @error('name') border-red-400 @enderror">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Email <span class="text-red-400">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}"
                   placeholder="nama@rt12.id" inputmode="email"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm @error('email') border-red-400 @enderror">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Password <span class="text-red-400">*</span></label>
            <input type="password" name="password"
                   placeholder="Minimal 8 karakter"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm @error('password') border-red-400 @enderror">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-display font-bold text-hijau-700 text-sm border-b border-gray-100 pb-2">Role / Jabatan</h3>

        <div class="space-y-2">
            @php
            $roles = [
                'superadmin'    => ['label' => 'Super Admin',    'desc' => 'Akses penuh ke semua fitur', 'color' => 'border-purple-400 bg-purple-50', 'text' => 'text-purple-700'],
                'ketua_rt'      => ['label' => 'Ketua RT',       'desc' => 'Kelola data warga & laporan', 'color' => 'border-blue-400 bg-blue-50', 'text' => 'text-blue-700'],
                'sekretaris_rt' => ['label' => 'Sekretaris RT',  'desc' => 'Input & kelola data penduduk', 'color' => 'border-hijau-400 bg-hijau-50', 'text' => 'text-hijau-700'],
                'bendahara_rt'  => ['label' => 'Bendahara RT',   'desc' => 'Akses data keuangan RT', 'color' => 'border-amber-400 bg-amber-50', 'text' => 'text-amber-700'],
            ];
            @endphp

            @foreach($roles as $val => $info)
            <label class="role-opt flex items-center gap-3 p-3.5 rounded-xl border-2 cursor-pointer transition-all
                {{ old('role') === $val ? $info['color'] : 'border-gray-200 bg-white' }}">
                <input type="radio" name="role" value="{{ $val }}"
                       {{ old('role') === $val ? 'checked' : '' }}
                       class="sr-only" onchange="updateRole(this)">
                <div class="flex-1">
                    <p class="text-sm font-bold {{ old('role') === $val ? $info['text'] : 'text-gray-700' }}">
                        {{ $info['label'] }}
                    </p>
                    <p class="text-xs {{ old('role') === $val ? $info['text'].' opacity-70' : 'text-gray-400' }} mt-0.5">
                        {{ $info['desc'] }}
                    </p>
                </div>
                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0
                    {{ old('role') === $val ? 'border-current bg-current' : 'border-gray-300' }}">
                    @if(old('role') === $val)
                    <div class="w-2 h-2 bg-white rounded-full"></div>
                    @endif
                </div>
            </label>
            @endforeach
        </div>
        @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <button type="submit"
            class="w-full bg-hijau-600 text-white font-bold py-4 rounded-2xl shadow-lg active:scale-95 transition-transform"
            style="box-shadow: 0 6px 20px rgba(26,92,56,0.35)">
        Buat Akun
    </button>
    <a href="{{ route('users.index') }}"
       class="block w-full text-center text-gray-400 text-sm font-medium py-2">Batal</a>
</form>
@endsection

@push('scripts')
<script>
const roleColors = {
    superadmin:    { border: 'border-purple-400', bg: 'bg-purple-50', text: 'text-purple-700' },
    ketua_rt:      { border: 'border-blue-400',   bg: 'bg-blue-50',   text: 'text-blue-700' },
    sekretaris_rt: { border: 'border-hijau-400',  bg: 'bg-hijau-50',  text: 'text-hijau-700' },
    bendahara_rt:  { border: 'border-amber-400',  bg: 'bg-amber-50',  text: 'text-amber-700' },
};

function updateRole(radio) {
    document.querySelectorAll('.role-opt').forEach(el => {
        const inp = el.querySelector('input');
        const texts = el.querySelectorAll('p');
        const dot = el.querySelector('.rounded-full');
        const c = roleColors[inp.value] || {};
        if (inp.checked) {
            el.className = el.className.replace(/border-\S+/, '').replace(/bg-\S+/, '');
            el.classList.add(c.border, c.bg);
            texts[0].className = texts[0].className.replace(/text-\S+/, '');
            texts[0].classList.add(c.text);
            dot.innerHTML = '<div class="w-2 h-2 bg-white rounded-full"></div>';
            dot.classList.add('bg-current');
        } else {
            el.classList.remove(c.border, c.bg);
            el.classList.add('border-gray-200', 'bg-white');
            texts[0].classList.remove(c.text);
            texts[0].classList.add('text-gray-700');
            dot.innerHTML = '';
            dot.classList.remove('bg-current');
        }
    });
}
</script>
@endpush
