@extends('pelamar.layouts.app')

@section('title', 'Profil Saya')

@php
    // Data contoh ada di config/profil.php — ganti dengan auth()->user() & relasinya
    $profil = config('profil.profil');
    $komunikasi = config('profil.komunikasi');
    $pendidikan = config('profil.pendidikan');
    $keahlian = config('profil.keahlian');
    $bahasa = config('profil.bahasa');
    $berkas = config('profil.berkas');
    $privasi = config('profil.privasi');

    // Pola kotak hiasan untuk Smart Pass (bukan QR code sungguhan)
    $ukuran = 21;
    $titik = [];
    for ($r = 0; $r < $ukuran; $r++) {
        for ($c = 0; $c < $ukuran; $c++) {
            $diPojok = fn ($r0, $c0) => $r >= $r0 && $r < $r0 + 7 && $c >= $c0 && $c < $c0 + 7;
            if ($diPojok(0, 0) || $diPojok(0, 14) || $diPojok(14, 0)) {
                $rr = $r % 14 < 7 ? $r % 14 : $r; $cc = $c % 14 < 7 ? $c % 14 : $c;
                $tepi = in_array($rr, [0, 6]) || in_array($cc, [0, 6]);
                $tengah = $rr >= 2 && $rr <= 4 && $cc >= 2 && $cc <= 4;
                if ($tepi || $tengah) $titik[] = [$c, $r];
            } elseif (crc32($profil['id'] . "$r-$c") % 2) {
                $titik[] = [$c, $r];
            }
        }
    }
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-pelamar.halaman.judul judul="Profil Saya & Identitas Inklusif" badge="Smart Pass Aktif"
                     deskripsi="Kelola data pribadi, preferensi komunikasi, dan dokumen yang akan dilihat perusahaan saat kamu melamar.">
        <button type="button" id="unduh-cv" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">
            ⬇️ Unduh CV Inklusif (PDF)
        </button>
        <a href="{{ route('profil.edit') }}" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
            Edit Profil
        </a>
    </x-pelamar.halaman.judul>

    {{-- ============ KARTU IDENTITAS ============ --}}
    <section class="overflow-hidden rounded-3xl bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 text-white">
        <div class="relative grid items-center gap-6 p-6 sm:p-8 lg:grid-cols-[1fr_auto]">
            <div class="absolute -left-16 -top-16 h-56 w-56 rounded-full bg-teal-500/20 blur-3xl" aria-hidden="true"></div>
            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center">
                <span class="relative grid h-24 w-24 shrink-0 place-items-center rounded-3xl bg-gradient-to-br from-teal-500 to-navy-700 text-3xl font-extrabold shadow-xl ring-4 ring-white/15">
                    <span data-profil="inisial">{{ $profil['inisial'] }}</span>
                    <span class="absolute -bottom-1.5 -right-1.5 grid h-8 w-8 place-items-center rounded-full bg-emerald-500 text-sm ring-4 ring-navy-800" title="Terverifikasi">✓</span>
                </span>
                <div>
                    <h2 class="text-2xl font-extrabold sm:text-3xl" data-profil="nama">{{ $profil['nama'] }}</h2>
                    <p class="mt-1 text-sm text-slate-300" data-profil="peran">{{ $profil['peran'] }}</p>
                    <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                        <span class="rounded-full bg-white/10 px-3 py-1 ring-1 ring-white/20">Tuli · BISINDO</span>
                        <span class="rounded-full bg-white/10 px-3 py-1 ring-1 ring-white/20">📍 <span data-profil="lokasi">{{ $profil['lokasi'] }}</span></span>
                        <span class="rounded-full bg-emerald-500/20 px-3 py-1 text-emerald-200 ring-1 ring-emerald-400/40">● Siap bekerja</span>
                    </div>
                </div>
            </div>

            {{-- Smart Pass --}}
            <div class="relative flex items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-teal-500">TUNAKER Smart Pass</p>
                    <p class="mt-1 font-mono text-lg font-bold tracking-wider">{{ $profil['id'] }}</p>
                    <p class="text-xs text-slate-300">Tempel kartu atau tunjukkan kode<br>untuk masuk & melamar cepat.</p>
                </div>
                <svg class="h-24 w-24 shrink-0 rounded-lg bg-white p-1.5" viewBox="0 0 {{ $ukuran }} {{ $ukuran }}" shape-rendering="crispEdges" aria-label="Kode Smart Pass">
                    @foreach ($titik as [$x, $y])<rect x="{{ $x }}" y="{{ $y }}" width="1" height="1" fill="#0b2545"/>@endforeach
                </svg>
            </div>
        </div>
        <div class="flex flex-wrap gap-x-6 gap-y-2 border-t border-white/10 bg-navy-950/30 px-6 py-3 text-xs text-slate-300 sm:px-8">
            <span>Terdaftar sejak <b class="text-white">{{ $profil['terdaftar'] }}</b></span>
            <span>Verifikasi identitas: <b class="text-white">Sesuai KTP</b></span>
            <span>Kartu Penyandang Disabilitas: <b class="text-white">Terverifikasi</b></span>
        </div>
    </section>

    <div class="grid gap-6 xl:grid-cols-[1fr_22rem]">
        <div class="min-w-0 space-y-6">
            {{-- Preferensi komunikasi --}}
            <section class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-extrabold text-navy-900">Preferensi Komunikasi & Akomodasi Kerja</h2>
                        <p class="text-sm">Ditampilkan ke perusahaan agar mereka bisa menyiapkan dukungan yang tepat.</p>
                    </div>
                    <a href="{{ route('profil.edit') }}#komunikasi" class="shrink-0 text-sm font-semibold text-teal-600 hover:underline">Ubah</a>
                </div>
                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    @foreach ($komunikasi as [$emoji, $label, $nilai])
                        <div class="flex items-center gap-3 rounded-2xl border border-slate-100 p-4">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-teal-50 text-xl" aria-hidden="true">{{ $emoji }}</span>
                            <div>
                                <p class="text-xs font-semibold text-slate-500">{{ $label }}</p>
                                <p class="text-sm font-bold text-navy-900">{{ $nilai }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <blockquote class="mt-4 rounded-2xl border-l-4 border-teal-500 bg-surface p-4 text-sm leading-relaxed text-navy-900">
                    <p class="text-xs font-bold uppercase tracking-wider text-teal-600">Catatan akomodasi</p>
                    <p class="mt-1" data-profil="catatan">"{{ config('profil.form.catatan') }}"</p>
                </blockquote>
            </section>

            {{-- Pendidikan --}}
            <section class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-lg font-extrabold text-navy-900">Pendidikan & Pelatihan Bersertifikat</h2>
                    <a href="{{ route('pelatihan') }}" class="shrink-0 text-sm font-semibold text-teal-600 hover:underline">+ Tambah</a>
                </div>
                <ol class="mt-5 space-y-4">
                    @foreach ($pendidikan as [$emoji, $judul, $lembaga, $periode, $ket])
                        <li class="flex gap-4">
                            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-navy-900 text-xl text-white" aria-hidden="true">{{ $emoji }}</span>
                            <div class="min-w-0 flex-1 border-b border-slate-100 pb-4">
                                <div class="flex flex-wrap items-start justify-between gap-x-3">
                                    <p class="font-bold text-navy-900">{{ $judul }}</p>
                                    <p class="text-xs font-semibold text-slate-400">{{ $periode }}</p>
                                </div>
                                <p class="text-xs font-semibold text-teal-600">{{ $lembaga }}</p>
                                <p class="mt-1 text-sm">{{ $ket }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </section>

            {{-- Keahlian & bahasa --}}
            <section class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-lg font-extrabold text-navy-900">Keterampilan Teknis & Bahasa</h2>
                <p class="mt-4 text-xs font-bold uppercase tracking-wider text-slate-500">Keahlian teknis</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach ($keahlian as $nama => $level)
                        <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $level === 'Mahir' ? 'border-navy-900 bg-navy-900 text-white' : 'border-slate-200 text-navy-900' }}">
                            {{ $nama }} <span class="opacity-60">· {{ $level }}</span>
                        </span>
                    @endforeach
                </div>
                <p class="mt-6 text-xs font-bold uppercase tracking-wider text-slate-500">Bahasa & komunikasi</p>
                <div class="mt-3 grid gap-4 sm:grid-cols-3">
                    @foreach ($bahasa as [$nama, $level, $persen])
                        <div class="rounded-2xl border border-slate-100 p-4">
                            <p class="text-sm font-bold text-navy-900">{{ $nama }}</p>
                            <p class="text-xs font-semibold text-teal-600">{{ $level }}</p>
                            <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-gradient-to-r from-teal-500 to-navy-800" style="width: {{ $persen }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        {{-- ============ PANEL KANAN ============ --}}
        <aside class="space-y-4">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="font-extrabold text-navy-900">Berkas & Dokumen</p>
                    <span class="text-xs font-semibold text-slate-500">{{ collect($berkas)->where(3, true)->count() }}/{{ count($berkas) }} lengkap</span>
                </div>
                <ul class="mt-4 space-y-2">
                    @foreach ($berkas as [$emoji, $nama, $ket, $ada])
                        <li class="flex items-center gap-3 rounded-xl border p-3 {{ $ada ? 'border-slate-100' : 'border-dashed border-amber-300 bg-amber-50/50' }}">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-surface text-lg" aria-hidden="true">{{ $emoji }}</span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-sm font-bold text-navy-900">{{ $nama }}</span>
                                <span class="block text-[11px] {{ $ada ? 'text-emerald-600' : 'text-amber-600' }}">{{ $ada ? '✓ ' : '⚠ ' }}{{ $ket }}</span>
                            </span>
                            <a href="#" class="shrink-0 text-xs font-bold text-teal-600 hover:underline">{{ $ada ? 'Lihat' : 'Unggah' }}</a>
                        </li>
                    @endforeach
                </ul>
                <label class="mt-3 flex cursor-pointer flex-col items-center gap-1 rounded-xl border-2 border-dashed border-slate-200 p-4 text-center transition hover:border-teal-500 hover:bg-teal-50/50">
                    <span class="text-2xl" aria-hidden="true">⬆️</span>
                    <span id="unggah-nama" class="text-xs font-semibold text-navy-900">Unggah dokumen baru</span>
                    <span class="text-[11px] text-slate-400">PDF / JPG, maks. 5 MB</span>
                    <input id="unggah" type="file" accept=".pdf,image/*" class="sr-only">
                </label>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="font-extrabold text-navy-900">Kelengkapan & Kunjungan</p>
                <div class="mt-4 flex items-center gap-4">
                    <span class="relative grid h-16 w-16 shrink-0 place-items-center">
                        <svg class="h-16 w-16 -rotate-90" viewBox="0 0 36 36"><circle cx="18" cy="18" r="15" fill="none" stroke="#eefafa" stroke-width="4"/><circle cx="18" cy="18" r="15" fill="none" stroke="#14a3a6" stroke-width="4" stroke-linecap="round" stroke-dasharray="{{ round(94.2 * $profil['kelengkapan'] / 100, 1) }} 94.2"/></svg>
                        <span class="absolute text-sm font-extrabold text-navy-900">{{ $profil['kelengkapan'] }}%</span>
                    </span>
                    <p class="text-sm">Unggah <b class="text-navy-900">sertifikat tambahan</b> untuk mencapai 86%.</p>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-surface p-3 text-center">
                        <p class="text-2xl font-extrabold text-navy-900">48</p>
                        <p class="text-[11px] text-slate-500">Dilihat perusahaan</p>
                    </div>
                    <div class="rounded-xl bg-surface p-3 text-center">
                        <p class="text-2xl font-extrabold text-teal-600">4</p>
                        <p class="text-[11px] text-slate-500">Undangan melamar</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="font-extrabold text-navy-900">Pengaturan & Privasi</p>
                <div class="mt-3 divide-y divide-slate-100">
                    @foreach ($privasi as [$kunci, $judul, $ket, $aktif])
                        <label class="flex cursor-pointer items-center justify-between gap-3 py-3">
                            <span>
                                <span class="block text-sm font-semibold text-navy-900">{{ $judul }}</span>
                                <span class="block text-[11px] text-slate-500">{{ $ket }}</span>
                            </span>
                            <input type="checkbox" class="privasi peer sr-only" data-kunci="{{ $kunci }}" @checked($aktif)>
                            <span class="relative h-6 w-11 shrink-0 rounded-full bg-slate-200 transition after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:bg-teal-500 peer-checked:after:translate-x-5 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/20"></span>
                        </label>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { toast, storage } = window.TunakerUI;
        const PRIVASI_KEY = 'tunaker_privasi';
        const tersimpan = storage.get(PRIVASI_KEY) || {};

        // Hasil simpan dari halaman Edit Profil (sementara dari browser, sampai backend siap)
        const hasilEdit = storage.get('tunaker_profil_edit')?.simple;
        if (hasilEdit) {
            const set = (kunci, teks) => document.querySelectorAll(`[data-profil="${kunci}"]`).forEach((el) => { el.textContent = teks; });
            if (hasilEdit.nama) {
                set('nama', hasilEdit.nama);
                set('inisial', hasilEdit.nama.trim().split(/\s+/).slice(0, 2).map((k) => k[0].toUpperCase()).join(''));
            }
            if (hasilEdit.headline) set('peran', hasilEdit.headline);
            if (hasilEdit.kota) set('lokasi', hasilEdit.kota);
            if (hasilEdit.catatan) set('catatan', `"${hasilEdit.catatan}"`);
        }

        // TODO: simpan pengaturan privasi ke backend; sementara di browser
        document.querySelectorAll('.privasi').forEach((t) => {
            if (t.dataset.kunci in tersimpan) t.checked = tersimpan[t.dataset.kunci];
            t.addEventListener('change', () => {
                tersimpan[t.dataset.kunci] = t.checked;
                storage.set(PRIVASI_KEY, tersimpan);
                toast(`${t.closest('label').querySelector('.text-sm').textContent} ${t.checked ? 'diaktifkan' : 'dimatikan'}`, t.checked ? '✅' : '⏸️');
            });
        });

        document.getElementById('unggah').addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;
            document.getElementById('unggah-nama').textContent = file.name;
            toast('Unggah dokumen belum tersimpan. Backend belum disambungkan.', '📁');
        });
        document.getElementById('unduh-cv').addEventListener('click', () => toast('Pembuatan CV PDF akan tersedia setelah backend siap.', '📄'));
    })();
</script>
@endpush
