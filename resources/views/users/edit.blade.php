@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('header_title', 'Edit Pengguna')
@section('back')
@endsection
@section('back_url', route('users.index'))

@section('content')
<form action="{{ route('users.update', $user) }}" method="POST" class="px-4 pt-4 pb-8 space-y-5">
    @csrf @method('PUT')

    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-display font-bold text-hijau-700 text-sm border-b border-gray-100 pb-2">Data Akun</h3>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm @error('name') border-red-400 @enderror">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Email <span class="text-red-400">*</span></label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   inputmode="email"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm @error('email') border-red-400 @enderror">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Password Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span></label>
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
                'superadmin'    => ['label' => 'Super Admin',   'desc' => 'Akses penuh ke semua fitur'],
                'ketua_rt'      => ['label' => 'Ketua RT',      'desc' => 'Kelola data warga & laporan'],
                'sekretaris_rt' => ['label' => 'Sekretaris RT', 'desc' => 'Input & kelola data penduduk'],
                'bendahara_rt'  => ['label' => 'Bendahara RT',  'desc' => 'Akses data keuangan RT'],
            ];
            $currentRole = old('role', $user->role);
            @endphp

            @foreach($roles as $val => $info)
            <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 cursor-pointer transition-all
                {{ $currentRole === $val ? 'border-hijau-400 bg-hijau-50' : 'border-gray-200' }}">
                <input type="radio" name="role" value="{{ $val }}"
                       {{ $currentRole === $val ? 'checked' : '' }}
                       class="sr-only">
                <div class="flex-1">
                    <p class="text-sm font-bold {{ $currentRole === $val ? 'text-hijau-700' : 'text-gray-700' }}">
                        {{ $info['label'] }}
                    </p>
                    <p class="text-xs {{ $currentRole === $val ? 'text-hijau-500' : 'text-gray-400' }} mt-0.5">
                        {{ $info['desc'] }}
                    </p>
                </div>
                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0
                    {{ $currentRole === $val ? 'border-hijau-500 bg-hijau-500' : 'border-gray-300' }}">
                    @if($currentRole === $val)
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
        Simpan Perubahan
    </button>
    <a href="{{ route('users.index') }}"
       class="block w-full text-center text-gray-400 text-sm font-medium py-2">Batal</a>
</form>
@endsection
