<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="#1a5c38">
    <title>Login — Si-RT 12 Nekamase</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        hijau: {
                            50:  '#f0f9f4',
                            100: '#dcf0e5',
                            200: '#bbe1cc',
                            400: '#55ac84',
                            500: '#328f66',
                            600: '#1a5c38',
                            700: '#164d30',
                            800: '#133f27',
                            900: '#0f3420',
                        },
                    },
                    fontFamily: {
                        sans:    ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Sora', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        * { -webkit-tap-highlight-color: transparent; }

        body {
            background: #0f3420;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Animated background blobs */
        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(80px);
            opacity: 0.25;
            animation: blobFloat 8s ease-in-out infinite;
        }
        .blob-1 { width: 300px; height: 300px; background: #328f66; top: -80px; right: -80px; animation-delay: 0s; }
        .blob-2 { width: 200px; height: 200px; background: #55ac84; bottom: 100px; left: -60px; animation-delay: 3s; }
        .blob-3 { width: 150px; height: 150px; background: #1a5c38; top: 40%; left: 50%; animation-delay: 5s; }

        @keyframes blobFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.05); }
        }

        /* Card slide up */
        .card-up { animation: cardUp 0.5s cubic-bezier(0.34,1.56,0.64,1) both; }
        @keyframes cardUp {
            from { opacity: 0; transform: translateY(40px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Logo bounce */
        .logo-anim { animation: logoBounce 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.1s both; }
        @keyframes logoBounce {
            from { opacity: 0; transform: scale(0.5) rotate(-10deg); }
            to   { opacity: 1; transform: scale(1) rotate(0deg); }
        }

        /* Input focus */
        input:focus { outline: none; box-shadow: 0 0 0 3px rgba(26,92,56,0.2); border-color: #1a5c38 !important; }

        /* Shake on error */
        .shake { animation: shake 0.4s ease both; }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        /* Geometric pattern */
        .geo-pattern {
            background-image: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 20px,
                rgba(255,255,255,0.02) 20px,
                rgba(255,255,255,0.02) 21px
            );
        }
    </style>
</head>
<body class="font-sans geo-pattern">

    {{-- Background blobs --}}
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="min-h-screen flex flex-col items-center justify-between px-5 py-10 relative z-10">

        {{-- Top: Logo & Title --}}
        <div class="flex flex-col items-center pt-6">
            <div class="logo-anim w-20 h-20 bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl flex items-center justify-center mb-5 shadow-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                </svg>
            </div>
            <h1 class="font-display font-extrabold text-white text-2xl text-center leading-tight">
                Si-RT 12
            </h1>
            <p class="text-white/50 text-sm mt-1 text-center">Nekamase · Liliba · Oebobo · Kupang</p>
        </div>

        {{-- Login Card --}}
        <div class="card-up w-full max-w-sm">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

                {{-- Card Header --}}
                <div class="bg-hijau-600 px-6 py-5">
                    <h2 class="font-display font-bold text-white text-lg">Masuk ke Sistem</h2>
                    <p class="text-white/60 text-xs mt-0.5">Gunakan akun yang telah diberikan</p>
                </div>

                {{-- Form --}}
                <div class="px-6 py-6 space-y-4">

                    @if($errors->any())
                    <div class="shake flex items-center gap-2.5 bg-red-50 border border-red-200 rounded-2xl px-4 py-3">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-red-600 text-sm font-medium">{{ $errors->first('email') }}</p>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}" id="login-form">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Email</label>
                                <div class="relative">
                                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           placeholder="nama@rt12.id"
                                           autocomplete="email"
                                           inputmode="email"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-2xl text-sm bg-gray-50 font-medium @error('email') border-red-400 @enderror">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Password</label>
                                <div class="relative">
                                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input type="password" name="password" id="pwd-input"
                                           placeholder="••••••••"
                                           autocomplete="current-password"
                                           class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-2xl text-sm bg-gray-50 font-medium">
                                    <button type="button" onclick="togglePwd()"
                                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 active:text-gray-600">
                                        <svg id="eye-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="remember"
                                           class="w-4 h-4 rounded border-gray-300 text-hijau-600 accent-hijau-600">
                                    <span class="text-xs text-gray-500 font-medium">Ingat saya</span>
                                </label>
                            </div>

                            <button type="submit"
                                    class="w-full bg-hijau-600 text-white font-bold py-3.5 rounded-2xl shadow-lg active:scale-95 transition-all mt-2 flex items-center justify-center gap-2"
                                    style="box-shadow: 0 6px 20px rgba(26,92,56,0.4)"
                                    id="submit-btn">
                                <span id="btn-text">Masuk</span>
                                <svg id="btn-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-white/30 text-xs text-center pb-2">
            RT 012 / RW 005 · Kelurahan Liliba · Kota Kupang
        </p>
    </div>

    <script>
    function togglePwd() {
        const inp = document.getElementById('pwd-input');
        const icon = document.getElementById('eye-icon');
        const show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        icon.innerHTML = show
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }

    document.getElementById('login-form').addEventListener('submit', function() {
        document.getElementById('btn-text').textContent = 'Memproses...';
        document.getElementById('btn-spinner').classList.remove('hidden');
        document.getElementById('submit-btn').disabled = true;
    });
    </script>
</body>
</html>
