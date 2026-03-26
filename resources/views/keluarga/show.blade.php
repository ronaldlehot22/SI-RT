@extends('layouts.app')

@section('title', 'KK '.$keluarga->no_kk)
@section('header_title', 'Detail KK')
@section('back')
@endsection
@section('back_url', route('keluarga.index'))

@section('header_action')
<a href="{{ route('keluarga.edit', $keluarga) }}"
   class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 text-white active:bg-white/20">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
    </svg>
</a>
@endsection

@section('content')
<div class="pb-6">

    {{-- Hero --}}
    <div class="bg-hijau-600 header-pattern pt-4 pb-6 px-4 rounded-b-3xl">
        <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm border border-white/20">
            <p class="text-white/60 text-xs font-semibold uppercase tracking-wide mb-1">Nomor Kartu Keluarga</p>
            <p class="font-mono font-bold text-white text-xl tracking-wider">
                {{ chunk_split($keluarga->no_kk, 4, ' ') }}
            </p>
            <div class="flex items-center gap-2 mt-3">
                <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-white/70 text-xs">
                    {{ $keluarga->alamat }},
                    RT {{ str_pad($keluarga->rt, 3, '0', STR_PAD_LEFT) }}/RW {{ str_pad($keluarga->rw, 3, '0', STR_PAD_LEFT) }},
                    {{ $keluarga->kelurahan }}
                </p>
            </div>
        </div>
    </div>

    <div class="px-4 mt-0 space-y-3">

        {{-- Kepala Keluarga --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-display font-bold text-hijau-700 text-sm">Kepala Keluarga</h3>
                @if(!$keluarga->kepalaKeluarga)
                <span class="text-xs text-amber-500 font-semibold">Belum ditetapkan</span>
                @endif
            </div>
            @if($keluarga->kepalaKeluarga)
            <a href="{{ route('penduduk.show', $keluarga->kepalaKeluarga) }}"
               class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-hijau-50 flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if($keluarga->kepalaKeluarga->foto)
                        <img src="{{ asset('storage/'.$keluarga->kepalaKeluarga->foto) }}" class="w-full h-full object-cover" alt="">
                    @else
                        <span class="text-hijau-600 font-display font-bold text-lg">
                            {{ strtoupper(substr($keluarga->kepalaKeluarga->nama_lengkap, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-800 text-sm">{{ $keluarga->kepalaKeluarga->nama_lengkap }}</p>
                    <p class="text-xs text-gray-400 font-mono mt-0.5">{{ $keluarga->kepalaKeluarga->nik }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @else
            <p class="text-sm text-gray-400">Tambahkan anggota dengan hubungan "Kepala Keluarga"</p>
            @endif
        </div>

        {{-- Daftar Anggota --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <h3 class="font-display font-bold text-hijau-700 text-sm">
                    Anggota Keluarga
                    <span class="ml-1.5 px-2 py-0.5 bg-hijau-50 text-hijau-600 rounded-full text-xs font-bold">
                        {{ $keluarga->anggotaAktif->count() }}
                    </span>
                </h3>
                <button onclick="toggleModal()" class="flex items-center gap-1.5 text-xs font-bold text-hijau-600 py-1.5 px-3 bg-hijau-50 rounded-xl active:bg-hijau-100 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah
                </button>
            </div>

            @forelse($keluarga->anggotaAktif as $anggota)
            <div class="px-4 py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                <div class="flex items-center gap-3">
                    <a href="{{ route('penduduk.show', $anggota->penduduk) }}" class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-hijau-50 flex items-center justify-center flex-shrink-0 overflow-hidden">
                            @if($anggota->penduduk->foto)
                                <img src="{{ asset('storage/'.$anggota->penduduk->foto) }}" class="w-full h-full object-cover" alt="">
                            @else
                                <span class="text-hijau-600 font-bold text-sm">
                                    {{ strtoupper(substr($anggota->penduduk->nama_lengkap, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $anggota->penduduk->nama_lengkap }}</p>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="text-[10px] font-semibold text-hijau-600 bg-hijau-50 px-1.5 py-0.5 rounded-full">
                                    {{ $anggota->hubungan_keluarga }}
                                </span>
                                <span class="text-[10px] text-gray-400">
                                    {{ $anggota->penduduk->jenis_kelamin === 'L' ? '♂' : '♀' }}
                                    {{ $anggota->penduduk->tanggal_lahir ? $anggota->penduduk->tanggal_lahir->diffInYears(now()).' th' : '' }}
                                </span>
                            </div>
                        </div>
                    </a>
                    {{-- Keluar button --}}
                    <button onclick="showKeluarModal('{{ $anggota->id }}', '{{ $anggota->penduduk->nama_lengkap }}')"
                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-red-50 text-red-400 flex-shrink-0 active:bg-red-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="px-4 py-8 text-center">
                <p class="text-gray-400 text-sm">Belum ada anggota</p>
            </div>
            @endforelse
        </div>

        {{-- Delete KK --}}
        <form action="{{ route('keluarga.destroy', $keluarga) }}" method="POST"
              onsubmit="return confirm('Hapus KK {{ $keluarga->no_kk }}? Semua data anggota juga akan terhapus.')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="w-full py-3.5 rounded-2xl border-2 border-red-200 text-red-500 text-sm font-bold active:bg-red-50 transition-colors">
                Hapus Kartu Keluarga
            </button>
        </form>

    </div>
</div>

{{-- Modal Tambah Anggota --}}
<div id="modal-tambah" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="toggleModal()"></div>
    <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl"
         style="padding: 20px 20px calc(100px + env(safe-area-inset-bottom, 0px)) 20px; animation: slideUp 0.3s cubic-bezier(0.34,1.56,0.64,1) both">
        <div class="w-10 h-1 bg-gray-200 rounded-full mx-auto mb-5"></div>
        <h3 class="font-display font-bold text-hijau-700 text-base mb-4">Tambah Anggota</h3>

        <form action="{{ route('keluarga.tambah-anggota', $keluarga) }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Pilih Penduduk <span class="text-red-400">*</span></label>
                <select name="penduduk_id" required
                        class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50">
                    <option value="">Pilih penduduk...</option>
                    @foreach(\App\Models\Penduduk::orderBy('nama_lengkap')->get() as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_lengkap }} — {{ $p->nik }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Hubungan Keluarga <span class="text-red-400">*</span></label>
                <select name="hubungan_keluarga" required
                        class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50">
                    <option value="">Pilih hubungan...</option>
                    @foreach(['Kepala Keluarga','Istri','Suami','Anak','Menantu','Cucu','Orang Tua','Mertua','Famili Lain','Pembantu','Lainnya'] as $hub)
                    <option value="{{ $hub }}">{{ $hub }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tanggal Masuk <span class="text-red-400">*</span></label>
                <input type="date" name="tanggal_masuk" value="{{ date('Y-m-d') }}" required
                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
            </div>

            <button type="submit"
                    class="w-full bg-hijau-600 text-white font-bold py-3.5 rounded-2xl active:scale-95 transition-transform"
                    style="box-shadow: 0 6px 20px rgba(26,92,56,0.35)">
                Tambahkan
            </button>
        </form>
    </div>
</div>

{{-- Modal Keluar Anggota --}}
<div id="modal-keluar" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeKeluarModal()"></div>
    <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl"
         style="padding: 20px 20px calc(100px + env(safe-area-inset-bottom, 0px)) 20px; animation: slideUp 0.3s cubic-bezier(0.34,1.56,0.64,1) both">
        <div class="w-10 h-1 bg-gray-200 rounded-full mx-auto mb-5"></div>
        <h3 class="font-display font-bold text-gray-800 text-base mb-1">Keluarkan Anggota</h3>
        <p id="keluar-nama" class="text-sm text-gray-400 mb-4"></p>

        <form id="form-keluar" method="POST" class="space-y-4">
            @csrf @method('PATCH')

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Alasan Keluar</label>
                <div class="grid grid-cols-3 gap-2">
                    @foreach(['pindah' => 'Pindah KK', 'meninggal' => 'Meninggal', 'keluar' => 'Keluar RT'] as $val => $label)
                    <label class="status-opt flex flex-col items-center py-2.5 rounded-xl border-2 border-gray-200 cursor-pointer transition-all">
                        <input type="radio" name="status" value="{{ $val }}" required class="sr-only" onchange="updateStatusOpt(this)">
                        <span class="text-xs font-bold text-gray-500">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" value="{{ date('Y-m-d') }}" required
                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
            </div>

            <button type="submit"
                    class="w-full bg-red-500 text-white font-bold py-3.5 rounded-2xl active:scale-95 transition-transform">
                Konfirmasi Keluar
            </button>
        </form>
    </div>
</div>

@push('styles')
<style>
@keyframes slideUp {
    from { transform: translateY(100%); opacity: 0; }
    to   { transform: translateY(0); opacity: 1; }
}
</style>
@endpush

@push('scripts')
<script>
function toggleModal() {
    const m = document.getElementById('modal-tambah');
    m.classList.toggle('hidden');
}

function showKeluarModal(anggotaId, nama) {
    document.getElementById('keluar-nama').textContent = nama;
    const baseUrl = "{{ url('keluarga/".$keluarga->id."/anggota') }}/";
    document.getElementById('form-keluar').action = baseUrl + anggotaId + '/keluar';
    document.getElementById('modal-keluar').classList.remove('hidden');
}

function closeKeluarModal() {
    document.getElementById('modal-keluar').classList.add('hidden');
}

function updateStatusOpt(radio) {
    document.querySelectorAll('.status-opt').forEach(el => {
        const inp = el.querySelector('input'), span = el.querySelector('span');
        const active = inp.checked;
        el.classList.toggle('border-red-400', active);
        el.classList.toggle('bg-red-50', active);
        el.classList.toggle('border-gray-200', !active);
        span.classList.toggle('text-red-600', active);
        span.classList.toggle('text-gray-500', !active);
    });
}
</script>
@endpush
@endsection
