@extends('layouts.app')

@section('title', 'Edit Penduduk')
@section('header_title', 'Edit Penduduk')
@section('back')
@endsection
@section('back_url', route('penduduk.show', $penduduk))

@section('content')
<form action="{{ route('penduduk.update', $penduduk) }}" method="POST" enctype="multipart/form-data" class="px-4 pt-4 pb-8 space-y-5">
    @csrf @method('PUT')

    {{-- Foto --}}
    <div class="flex flex-col items-center gap-3">
        <div id="foto-preview"
             class="w-20 h-20 rounded-2xl overflow-hidden bg-hijau-50 border-2 border-dashed border-hijau-200 flex items-center justify-center">
            @if($penduduk->foto)
                <img src="{{ asset('storage/'.$penduduk->foto) }}" class="w-full h-full object-cover" alt="">
            @else
                <span class="text-hijau-600 font-display font-bold text-2xl">
                    {{ strtoupper(substr($penduduk->nama_lengkap, 0, 1)) }}
                </span>
            @endif
        </div>
        <label class="text-sm font-semibold text-hijau-600 cursor-pointer">
            Ganti Foto
            <input type="file" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
        </label>
    </div>

    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-display font-bold text-hijau-700 text-sm border-b border-gray-100 pb-2">Data Identitas</h3>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">NIK <span class="text-red-400">*</span></label>
            <input type="text" name="nik" value="{{ old('nik', $penduduk->nik) }}" maxlength="16" inputmode="numeric"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-mono bg-gray-50">
            @error('nik')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
            @error('nama_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}"
                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir?->format('Y-m-d')) }}"
                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-2">Jenis Kelamin</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach(['L' => '♂ Laki-laki', 'P' => '♀ Perempuan'] as $val => $label)
                <label class="jk-option flex items-center justify-center gap-2 py-2.5 rounded-xl border-2 cursor-pointer transition-all
                    {{ old('jenis_kelamin', $penduduk->jenis_kelamin) === $val ? 'border-hijau-600 bg-hijau-50' : 'border-gray-200' }}">
                    <input type="radio" name="jenis_kelamin" value="{{ $val }}"
                           {{ old('jenis_kelamin', $penduduk->jenis_kelamin) === $val ? 'checked' : '' }}
                           class="sr-only" onchange="updateJK(this)">
                    <span class="text-sm font-semibold {{ old('jenis_kelamin', $penduduk->jenis_kelamin) === $val ? 'text-hijau-700' : 'text-gray-500' }}">
                        {{ $label }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-2">Golongan Darah</label>
            <div class="grid grid-cols-5 gap-2">
                @foreach(['A','B','AB','O','-'] as $gol)
                <label class="gol-option flex items-center justify-center py-2 rounded-xl border-2 cursor-pointer transition-all
                    {{ old('golongan_darah', $penduduk->golongan_darah) === $gol ? 'border-hijau-600 bg-hijau-50' : 'border-gray-200' }}">
                    <input type="radio" name="golongan_darah" value="{{ $gol }}"
                           {{ old('golongan_darah', $penduduk->golongan_darah) === $gol ? 'checked' : '' }}
                           class="sr-only" onchange="updateGol(this)">
                    <span class="text-xs font-bold {{ old('golongan_darah', $penduduk->golongan_darah) === $gol ? 'text-hijau-700' : 'text-gray-500' }}">{{ $gol }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-display font-bold text-hijau-700 text-sm border-b border-gray-100 pb-2">Data Sosial</h3>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Agama</label>
            <select name="agama" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50">
                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                <option value="{{ $ag }}" {{ old('agama', $penduduk->agama) === $ag ? 'selected' : '' }}>{{ $ag }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Pendidikan</label>
            <select name="pendidikan" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50">
                @foreach(['Belum Sekolah','Tidak Sekolah','Tidak Tamat SD','Tamat SD','Tamat SMP','Tamat SMA','SMK','D1','D2','D3','D4','S1','S2','S3'] as $pend)
                <option value="{{ $pend }}" {{ old('pendidikan', $penduduk->pendidikan) === $pend ? 'selected' : '' }}>{{ $pend }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Pekerjaan</label>
            <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}"
                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status Perkawinan</label>
            <select name="status_perkawinan" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm bg-gray-50">
                @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $stat)
                <option value="{{ $stat }}" {{ old('status_perkawinan', $penduduk->status_perkawinan) === $stat ? 'selected' : '' }}>{{ $stat }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-display font-bold text-hijau-700 text-sm border-b border-gray-100 pb-2">Kewarganegaraan</h3>
        <div class="grid grid-cols-2 gap-2">
            @foreach(['WNI','WNA'] as $val)
            <label class="wna-option flex items-center justify-center py-2.5 rounded-xl border-2 cursor-pointer transition-all
                {{ old('kewarganegaraan', $penduduk->kewarganegaraan) === $val ? 'border-hijau-600 bg-hijau-50' : 'border-gray-200' }}">
                <input type="radio" name="kewarganegaraan" value="{{ $val }}"
                       {{ old('kewarganegaraan', $penduduk->kewarganegaraan) === $val ? 'checked' : '' }}
                       class="sr-only" onchange="toggleWNA(this)">
                <span class="text-sm font-bold {{ old('kewarganegaraan', $penduduk->kewarganegaraan) === $val ? 'text-hijau-700' : 'text-gray-500' }}">{{ $val }}</span>
            </label>
            @endforeach
        </div>

        <div id="wna-fields" class="{{ old('kewarganegaraan', $penduduk->kewarganegaraan) === 'WNA' ? '' : 'hidden' }} space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">No. Paspor</label>
                <input type="text" name="no_paspor" value="{{ old('no_paspor', $penduduk->no_paspor) }}"
                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-mono">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">No. KITAS/KITAP</label>
                <input type="text" name="no_kitas" value="{{ old('no_kitas', $penduduk->no_kitas) }}"
                       class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-mono">
            </div>
        </div>
    </div>


    <button type="submit"
            class="w-full bg-hijau-600 text-white font-bold py-4 rounded-2xl shadow-lg active:scale-95 transition-transform"
            style="box-shadow: 0 6px 20px rgba(26,92,56,0.35)">
        Simpan Perubahan
    </button>
    <a href="{{ route('penduduk.show', $penduduk) }}"
       class="block w-full text-center text-gray-400 text-sm font-medium py-2">Batal</a>
</form>
@endsection

@push('scripts')
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('foto-preview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function updateJK(radio) {
    document.querySelectorAll('.jk-option').forEach(el => {
        const inp = el.querySelector('input'), span = el.querySelector('span');
        const active = inp.checked;
        el.classList.toggle('border-hijau-600', active);
        el.classList.toggle('bg-hijau-50', active);
        el.classList.toggle('border-gray-200', !active);
        span.classList.toggle('text-hijau-700', active);
        span.classList.toggle('text-gray-500', !active);
    });
}
function updateGol(radio) {
    document.querySelectorAll('.gol-option').forEach(el => {
        const inp = el.querySelector('input'), span = el.querySelector('span');
        const active = inp.checked;
        el.classList.toggle('border-hijau-600', active);
        el.classList.toggle('bg-hijau-50', active);
        el.classList.toggle('border-gray-200', !active);
        span.classList.toggle('text-hijau-700', active);
        span.classList.toggle('text-gray-500', !active);
    });
}
function toggleWNA(radio) {
    document.querySelectorAll('.wna-option').forEach(el => {
        const inp = el.querySelector('input'), span = el.querySelector('span');
        const active = inp.checked;
        el.classList.toggle('border-hijau-600', active);
        el.classList.toggle('bg-hijau-50', active);
        el.classList.toggle('border-gray-200', !active);
        span.classList.toggle('text-hijau-700', active);
        span.classList.toggle('text-gray-500', !active);
    });
    document.getElementById('wna-fields').classList.toggle('hidden', radio.value !== 'WNA');
}
</script>
@endpush
