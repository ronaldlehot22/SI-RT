<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="#1a5c38">
    <title>@yield('title', 'Si-RT 12 Nekamase')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        hijau: {
                            50:  '#f0f9f4',
                            100: '#dcf0e5',
                            200: '#bbe1cc',
                            300: '#8acaab',
                            400: '#55ac84',
                            500: '#328f66',
                            600: '#1a5c38',
                            700: '#164d30',
                            800: '#133f27',
                            900: '#0f3420',
                        },
                        krem: '#faf8f4',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Sora', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        * { -webkit-tap-highlight-color: transparent; }
        body { background-color: #faf8f4; }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 16px); }

        /* Page enter animation */
        .page-enter { animation: pageIn 0.3s ease-out both; }
        @keyframes pageIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Card hover */
        .card-hover { transition: transform 0.15s ease, box-shadow 0.15s ease; }
        .card-hover:active { transform: scale(0.98); }

        /* FAB pulse */
        .fab-btn { animation: fabIn 0.4s cubic-bezier(0.34,1.56,0.64,1) both; }
        @keyframes fabIn {
            from { opacity: 0; transform: scale(0.5); }
            to   { opacity: 1; transform: scale(1); }
        }

        /* Toast slide */
        .toast-enter { animation: toastIn 0.35s cubic-bezier(0.34,1.56,0.64,1) both; }
        @keyframes toastIn {
            from { opacity: 0; transform: translateY(-20px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Scrollbar hidden */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Bottom nav active dot */
        .nav-active::after {
            content: '';
            display: block;
            width: 4px; height: 4px;
            background: #1a5c38;
            border-radius: 9999px;
            margin: 3px auto 0;
        }

        /* Input focus ring */
        input:focus, select:focus, textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 92, 56, 0.15);
            border-color: #1a5c38 !important;
        }

        /* Header pattern */
        .header-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M0 20 L20 0 L40 20 L20 40 Z'/%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans min-h-screen bg-krem text-gray-800">

    {{-- Header --}}
    <header class="fixed top-0 left-0 right-0 z-40 bg-hijau-600 header-pattern shadow-lg">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-3">
                @hasSection('back')
                    <a href="@yield('back_url', 'javascript:history.back()')"
                       class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 text-white active:bg-white/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                @else
                    <div class="w-9 h-9 bg-white/15 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                @endif
                <div>
                    <h1 class="font-display text-white font-bold text-base leading-tight">
                        @yield('header_title', 'Si-RT 12 Nekamase')
                    </h1>
                    <p class="text-white/60 text-xs">RT 012 / RW 005 · Kelurahan Liliba</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @yield('header_action')
                {{-- User info + logout --}}
                @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="w-9 h-9 flex items-center justify-center rounded-full bg-white/15 text-white active:bg-white/25 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 top-11 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
                         style="display:none">
                        <div class="px-4 py-3 border-b border-gray-50">
                            <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-hijau-600 font-semibold mt-0.5">{{ auth()->user()->role_label }}</p>
                        </div>
                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('users.index') }}"
                           class="flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 border-b border-gray-50">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Kelola Pengguna
                        </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div id="toast-success"
         class="toast-enter fixed top-16 left-4 right-4 z-50 bg-white border-l-4 border-hijau-600 rounded-xl shadow-xl px-4 py-3 flex items-center gap-3">
        <div class="w-8 h-8 bg-hijau-50 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-hijau-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <p class="text-sm font-medium text-gray-700 flex-1">{{ session('success') }}</p>
        <button onclick="document.getElementById('toast-success').remove()" class="text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <script>setTimeout(()=>{ const t=document.getElementById('toast-success'); if(t) t.remove(); }, 3500);</script>
    @endif

    @if(session('error'))
    <div id="toast-error"
         class="toast-enter fixed top-16 left-4 right-4 z-50 bg-white border-l-4 border-red-500 rounded-xl shadow-xl px-4 py-3 flex items-center gap-3">
        <div class="w-8 h-8 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <p class="text-sm font-medium text-gray-700 flex-1">{{ session('error') }}</p>
        <button onclick="document.getElementById('toast-error').remove()" class="text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <script>setTimeout(()=>{ const t=document.getElementById('toast-error'); if(t) t.remove(); }, 3500);</script>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
    <div id="toast-validation"
         class="toast-enter fixed top-16 left-4 right-4 z-50 bg-white border-l-4 border-red-500 rounded-xl shadow-xl px-4 py-3 flex items-start gap-3">
        <div class="w-8 h-8 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-red-600">Data gagal disimpan</p>
            <ul class="mt-1 space-y-0.5">
                @foreach($errors->all() as $error)
                <li class="text-xs text-gray-600">• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button onclick="document.getElementById('toast-validation').remove()" class="text-gray-400 flex-shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <script>setTimeout(()=>{ const t=document.getElementById('toast-validation'); if(t) t.remove(); }, 5000);</script>
    @endif

    {{-- Main Content --}}
    <main class="pt-[68px] pb-20 min-h-screen page-enter">
        @yield('content')
    </main>

    {{-- FAB (di luar main agar fixed tidak ter-clip oleh transform animasi) --}}
    @stack('fab')

    {{-- Bottom Navigation --}}
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-100 shadow-[0_-4px_24px_rgba(0,0,0,0.06)] safe-bottom">
        <div class="grid grid-cols-3 py-2">
            <a href="{{ url('/') }}"
               class="flex flex-col items-center py-1 px-2 {{ request()->is('/') ? 'nav-active' : '' }}">
                <div class="w-8 h-8 flex items-center justify-center rounded-xl {{ request()->is('/') ? 'bg-hijau-50' : '' }} transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->is('/') ? 'text-hijau-600' : 'text-gray-400' }}" fill="{{ request()->is('/') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold mt-0.5 {{ request()->is('/') ? 'text-hijau-600' : 'text-gray-400' }}">Beranda</span>
            </a>

            <a href="{{ route('penduduk.index') }}"
               class="flex flex-col items-center py-1 px-2 {{ request()->is('penduduk*') ? 'nav-active' : '' }}">
                <div class="w-8 h-8 flex items-center justify-center rounded-xl {{ request()->is('penduduk*') ? 'bg-hijau-50' : '' }} transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->is('penduduk*') ? 'text-hijau-600' : 'text-gray-400' }}" fill="{{ request()->is('penduduk*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold mt-0.5 {{ request()->is('penduduk*') ? 'text-hijau-600' : 'text-gray-400' }}">Penduduk</span>
            </a>

            <a href="{{ route('keluarga.index') }}"
               class="flex flex-col items-center py-1 px-2 {{ request()->is('keluarga*') ? 'nav-active' : '' }}">
                <div class="w-8 h-8 flex items-center justify-center rounded-xl {{ request()->is('keluarga*') ? 'bg-hijau-50' : '' }} transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->is('keluarga*') ? 'text-hijau-600' : 'text-gray-400' }}" fill="{{ request()->is('keluarga*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold mt-0.5 {{ request()->is('keluarga*') ? 'text-hijau-600' : 'text-gray-400' }}">Keluarga</span>
            </a>
        </div>
    </nav>

    @stack('scripts')
</body>
</html>
