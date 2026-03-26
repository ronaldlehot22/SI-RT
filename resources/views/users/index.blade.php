@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('header_title', 'Kelola Pengguna')

@section('content')
<div class="px-4 pt-4 pb-6 space-y-3">

    <p class="text-xs text-gray-400 font-medium mb-4">Hanya dapat diakses oleh Super Admin</p>

    @php
    $roleColors = [
        'superadmin'    => 'bg-purple-50 text-purple-600',
        'ketua_rt'      => 'bg-blue-50 text-blue-600',
        'sekretaris_rt' => 'bg-hijau-50 text-hijau-600',
        'bendahara_rt'  => 'bg-amber-50 text-amber-600',
    ];
    @endphp

    @foreach($users as $user)
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
        <div class="w-11 h-11 rounded-xl flex-shrink-0 flex items-center justify-center
            {{ $user->isSuperAdmin() ? 'bg-purple-100' : 'bg-hijau-50' }}">
            <span class="font-display font-bold text-base
                {{ $user->isSuperAdmin() ? 'text-purple-600' : 'text-hijau-600' }}">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </span>
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-gray-800 text-sm truncate">{{ $user->name }}</p>
            <p class="text-xs text-gray-400 truncate mt-0.5">{{ $user->email }}</p>
            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-500' }}">
                {{ $user->role_label }}
            </span>
        </div>
        <div class="flex flex-col gap-1.5 flex-shrink-0">
            <a href="{{ route('users.edit', $user) }}"
               class="w-8 h-8 flex items-center justify-center bg-gray-50 rounded-xl text-gray-500 active:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
            @if($user->id !== auth()->id())
            <form action="{{ route('users.destroy', $user) }}" method="POST"
                  onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-8 h-8 flex items-center justify-center bg-red-50 rounded-xl text-red-400 active:bg-red-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>

<a href="{{ route('users.create') }}"
   class="fab-btn fixed bottom-24 right-4 w-14 h-14 bg-hijau-600 text-white rounded-full shadow-xl flex items-center justify-center active:scale-95 transition-transform z-30"
   style="box-shadow: 0 8px 24px rgba(26,92,56,0.4)">
    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
</a>
@endsection
