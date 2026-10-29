@extends('pelamar.layouts.app')

@section('title', 'Pelatihan')

@php
    // CONTOH data — ganti dengan data pelatihan dari database
    $kategori = ['semua' => 'Semua Pelatihan', 'diikuti' => 'Sedang Diikuti', 'desain' => 'Desain & Kreatif',
                 'teknologi' => 'Teknologi & Coding', 'administrasi' => 'Administrasi Kantor', 'bahasa' => 'Bahasa & Literasi'];

    $kursus = [
        ['judul' => 'UI/UX & Visual Design Dasar hingga Menengah', 'penyelenggara' => 'Kelas Tuli Kreatif', 'kategori' => 'desain', 'level' => 'Pemula',
         'bnsp' => true, 'rating' => 4.9, 'modul' => 12, 'durasi' => '6 minggu', 'foto' => '1561070791-2526d30994b5', 'progres' => null,
         'deskripsi' => 'Kuasai prinsip desain antarmuka web dan mobile dengan Figma, langsung dari mentor Tuli.',
         'fitur' => ['100% video BISINDO + subtitle', 'Tugas portofolio nyata']],
        ['judul' => 'Data Entry & Otomasi Microsoft Excel', 'penyelenggara' => 'Disnaker Kota Bandung', 'kategori' => 'administrasi', 'level' => 'Pemula',
         'bnsp' => true, 'rating' => 4.8, 'modul' => 8, 'durasi' => '4 minggu', 'foto' => '1460925895917-afdab827c52f', 'progres' => null,
         'deskripsi' => 'Belajar mengelola data, rumus, dan laporan otomatis dengan Excel untuk pekerjaan kantor.',
         'fitur' => ['Mentor Tuli di setiap sesi', 'Latihan soal & studi kasus']],
        ['judul' => 'Video Editing & Animasi Motion dengan CapCut', 'penyelenggara' => 'Studio Visual Nusa', 'kategori' => 'desain', 'level' => 'Menengah',
         'bnsp' => false, 'rating' => 4.8, 'modul' => 10, 'durasi' => '5 minggu', 'foto' => '1551434678-e076c223a692', 'progres' => 40,
         'deskripsi' => 'Produksi konten video untuk media sosial lengkap dengan teks dan subtitle yang rapi.',
         'fitur' => ['Tutorial visual langkah demi langkah', 'Kurasi karya oleh praktisi']],
        ['judul' => 'Administrasi Perkantoran & Manajemen Arsip Digital', 'penyelenggara' => 'Akademi Inklusi Digital', 'kategori' => 'administrasi', 'level' => 'Pemula',
         'bnsp' => true, 'rating' => 4.7, 'modul' => 9, 'durasi' => '4 minggu', 'foto' => '1586281380349-632531db7ed4', 'progres' => null,
         'deskripsi' => 'Standar surat-menyurat, pengarsipan digital, dan etika kerja kantor yang inklusif.',
         'fitur' => ['Modul cetak & digital', 'Simulasi kerja kantor']],
        ['judul' => 'Pemrograman Web Dasar: HTML, CSS & JavaScript', 'penyelenggara' => 'Akademi Inklusi Digital', 'kategori' => 'teknologi', 'level' => 'Pemula',
         'bnsp' => false, 'rating' => 4.9, 'modul' => 14, 'durasi' => '8 minggu', 'foto' => '1531482615713-2afd69097998', 'progres' => null,
         'deskripsi' => 'Bangun website pertamamu dari nol dengan penjelasan kode yang visual dan bertahap.',
         'fitur' => ['Code review via chat', 'Proyek akhir untuk portofolio']],
        ['judul' => 'Literasi Komunikasi Tertulis di Tempat Kerja', 'penyelenggara' => 'Gerkatin Pusat', 'kategori' => 'bahasa', 'level' => 'Pemula',
         'bnsp' => false, 'rating' => 4.6, 'modul' => 6, 'durasi' => '3 minggu', 'foto' => '1600880292203-757bb62b4baf', 'progres' => null,
         'deskripsi' => 'Menulis email, laporan, dan pesan kerja yang jelas dan profesional.',
         'fitur' => ['Kamus istilah kerja', 'Latihan email & chat kantor']],
    ];

    $sertifikat = [
        ['Junior Graphic Designer', 'Badan Nasional Sertifikasi Profesi (BNSP)', 'Berlaku sampai 2027', '🏅'],
        ['Literasi Digital Perkantoran', 'Kementerian Ketenagakerjaan RI', 'Berlaku seumur hidup', '📜'],
    ];
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-pelamar.halaman.judul judul="Pelatihan & Sertifikasi Kerja Inklusif" badge="✓ Kurikulum Ramah Tunarungu Teruji"
                     deskripsi="Tingkatkan keterampilan kerja dengan pelatihan berbahasa isyarat (BISINDO), subtitle lengkap, dan sertifikat yang terakreditasi Kemnaker & BNSP.">
        <div class="rounded-2xl border border-slate-100 bg-white px-5 py-3 text-center shadow-sm">
            <p class="text-2xl font-extrabold text-navy-900">18</p>
            <p class="text-xs text-slate-500">Modul terbuka</p>
        </div>
        <div class="rounded-2xl border border-slate-100 bg-white px-5 py-3 text-center shadow-sm">
            <p class="text-2xl font-extrabold text-teal-600">{{ count($sertifikat) }}</p>
            <p class="text-xs text-slate-500">Tersertifikasi</p>
        </div>
    </x-pelamar.halaman.judul>

    {{-- ============ SEDANG DIPELAJARI ============ --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 p-6 text-white sm:p-8">
        <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-teal-500/25 blur-3xl" aria-hidden="true"></div>
        <div class="relative grid items-center gap-6 md:grid-cols-[1fr_auto]">
            <div>
                <div class="flex flex-wrap gap-2 text-xs font-bold">
                    <span class="rounded-full bg-teal-500 px-3 py-1">Sedang dipelajari</span>
                    <span class="rounded-full bg-white/10 px-3 py-1 ring-1 ring-white/20">Modul 4 dari 6 · 🤟 BISINDO</span>
                </div>
                <h2 class="mt-3 text-xl font-extrabold sm:text-2xl">Desain Grafis Komersial & Branding Visual</h2>
                <p class="mt-1 text-sm text-slate-300">Selanjutnya, Modul 4: membuat identitas merek, mockup kemasan, dan pitching portofolio.</p>
                <div class="mt-5 max-w-lg">
                    <div class="flex justify-between text-xs font-semibold">
                        <span>Progres belajar</span>
                        <span class="text-teal-500">75%</span>
                    </div>
                    <div class="mt-1.5 h-2.5 overflow-hidden rounded-full bg-white/15">
                        <div class="h-full rounded-full bg-gradient-to-r from-teal-500 to-emerald-400" style="width: 75%"></div>
                    </div>
                    <p class="mt-2 text-xs text-slate-300">Selesaikan 2 modul lagi untuk mendapat sertifikat BNSP.</p>
                </div>
            </div>
            <a href="#" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-500 px-6 py-3 text-sm font-bold transition hover:bg-teal-600">
                ▶ Lanjutkan Belajar
            </a>
        </div>
    </section>

    <div class="grid gap-6 xl:grid-cols-[1fr_20rem]">
        <div class="min-w-0">
            {{-- Kategori --}}
            <div class="flex gap-2 overflow-x-auto pb-1" role="tablist">
                @foreach ($kategori as $kunci => $teks)
                    @php
                        $jumlah = match ($kunci) {
                            'semua' => count($kursus),
                            'diikuti' => collect($kursus)->whereNotNull('progres')->count(),
                            default => collect($kursus)->where('kategori', $kunci)->count(),
                        };
                    @endphp
                    <button type="button" data-kategori="{{ $kunci }}"
                            class="kategori-btn shrink-0 rounded-full border px-4 py-2 text-xs font-semibold transition {{ $loop->first ? 'border-navy-900 bg-navy-900 text-white' : 'border-slate-200 bg-white text-slate-600 hover:border-teal-500' }}">
                        {{ $teks }} <span class="opacity-70" data-hitung="{{ $kunci }}">({{ $jumlah }})</span>
                    </button>
                @endforeach
            </div>

            {{-- Daftar kursus --}}
            <div id="daftar-kursus" class="mt-5 grid gap-5 md:grid-cols-2">
                @foreach ($kursus as $k)
                    <article class="kursus group flex flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                             data-id="{{ \Illuminate\Support\Str::slug($k['judul']) }}" data-kategori="{{ $k['kategori'] }}" data-diikuti="{{ $k['progres'] ? 1 : 0 }}">
                        <div class="relative aspect-[16/8] overflow-hidden bg-slate-100">
                            <img src="https://images.unsplash.com/photo-{{ $k['foto'] }}?auto=format&fit=crop&w=700&q=70" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute left-3 top-3 flex gap-1.5">
                                <span class="rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-bold text-navy-900 shadow">{{ $k['level'] }}</span>
                                @if ($k['bnsp'])
                                    <span class="rounded-full bg-emerald-500 px-2.5 py-1 text-[11px] font-bold text-white shadow">✓ BNSP</span>
                                @endif
                            </div>
                            <span class="absolute bottom-3 right-3 rounded-full bg-navy-900/85 px-2.5 py-1 text-[11px] font-bold text-white backdrop-blur">Video BISINDO</span>
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <div class="flex items-center justify-between gap-2 text-xs">
                                <span class="truncate font-semibold text-teal-600">{{ $k['penyelenggara'] }}</span>
                                <span class="shrink-0 font-bold text-amber-500">★ {{ $k['rating'] }}</span>
                            </div>
                            <h2 class="mt-1.5 font-extrabold leading-snug text-navy-900">{{ $k['judul'] }}</h2>
                            <p class="mt-1.5 text-sm leading-relaxed">{{ $k['deskripsi'] }}</p>
                            <ul class="mt-3 space-y-1 text-xs text-navy-900">
                                @foreach ($k['fitur'] as $f)
                                    <li class="flex gap-2"><span class="text-teal-500">✓</span> {{ $f }}</li>
                                @endforeach
                            </ul>
                            <div class="mt-auto pt-4">
                                @if ($k['progres'])
                                    <div class="flex justify-between text-xs font-semibold">
                                        <span class="text-navy-900">Progres</span>
                                        <span class="text-teal-600">{{ $k['progres'] }}%</span>
                                    </div>
                                    <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full rounded-full bg-gradient-to-r from-teal-500 to-navy-800" style="width: {{ $k['progres'] }}%"></div>
                                    </div>
                                @endif
                                <div class="mt-3 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                                    <p class="text-xs text-slate-500">📚 {{ $k['modul'] }} modul<br>🗓️ {{ $k['durasi'] }}</p>
                                    @if ($k['progres'])
                                        <a href="#" class="rounded-lg bg-teal-50 px-4 py-2.5 text-xs font-bold text-teal-600 transition hover:bg-teal-100">Lanjutkan</a>
                                    @else
                                        <button type="button" data-daftar-kursus class="rounded-lg bg-navy-900 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-teal-600"
                                                data-id="{{ \Illuminate\Support\Str::slug($k['judul']) }}" data-judul="{{ $k['judul'] }}" data-penyelenggara="{{ $k['penyelenggara'] }}"
                                                data-modul="{{ $k['modul'] }}" data-durasi="{{ $k['durasi'] }}" data-bnsp="{{ $k['bnsp'] ? 1 : 0 }}"
                                                data-fitur="{{ implode('|', $k['fitur']) }}" data-foto="{{ $k['foto'] }}">Daftar Gratis</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <p id="kursus-kosong" class="mt-5 hidden rounded-2xl border border-dashed border-slate-200 bg-white p-8 text-center text-sm">Belum ada pelatihan di kategori ini.</p>
        </div>

        {{-- ============ PANEL KANAN ============ --}}
        <aside class="space-y-4">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="font-extrabold text-navy-900">Sertifikasi Saya</p>
                    <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-bold text-emerald-600">{{ count($sertifikat) }} terverifikasi</span>
                </div>
                <p class="mt-1 text-xs text-slate-500">Sertifikat otomatis ditambahkan ke profil & CV-mu.</p>
                <ul class="mt-4 space-y-3">
                    @foreach ($sertifikat as [$nama, $penerbit, $masa, $emoji])
                        <li class="flex items-start gap-3 rounded-xl border border-slate-100 p-3">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-amber-50 text-xl" aria-hidden="true">{{ $emoji }}</span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-sm font-bold leading-snug text-navy-900">{{ $nama }}</span>
                                <span class="block text-[11px] text-slate-500">{{ $penerbit }}</span>
                                <span class="block text-[11px] font-semibold text-teal-600">{{ $masa }}</span>
                            </span>
                            <a href="#" class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-slate-400 hover:bg-surface hover:text-navy-900" aria-label="Unduh sertifikat {{ $nama }}">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('profil') }}" class="mt-4 block rounded-lg border border-slate-200 py-2.5 text-center text-xs font-bold text-navy-900 transition hover:border-navy-900">Tampilkan di Portofolio</a>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 p-5 text-white">
                <div class="absolute -bottom-10 -right-10 h-32 w-32 rounded-full bg-teal-500/30 blur-2xl" aria-hidden="true"></div>
                <span class="relative text-[11px] font-bold uppercase tracking-widest text-teal-500">Kamus Isyarat Kerja</span>
                <p class="relative mt-2 text-lg font-extrabold leading-snug">Kamus Isyarat Istilah Perkantoran</p>
                <p class="relative mt-1 text-sm text-slate-300">Pelajari isyarat untuk istilah seperti "rapat", "deadline", dan "kontrak kerja" dalam BISINDO.</p>
                <button type="button" class="video-btn relative mt-4 w-full rounded-lg bg-teal-500 py-2.5 text-sm font-bold transition hover:bg-teal-600"
                        data-video="" data-judul="Kamus isyarat istilah perkantoran">Buka Kamus Isyarat</button>
            </div>
        </aside>
    </div>
</div>

{{-- ============ POP UP DAFTAR PELATIHAN ============ --}}
@php
    $mulaiKelas = now()->locale('id')->next(\Carbon\Carbon::MONDAY);
    $jadwalPilihan = [
        ['Belajar mandiri', 'Mulai kapan saja, belajar sesuai waktumu', '🚀'],
        ['Angkatan 1 · ' . $mulaiKelas->translatedFormat('d M Y'), 'Kelas bersama, ada sesi tanya jawab', '📅'],
        ['Angkatan 2 · ' . $mulaiKelas->copy()->addWeeks(2)->translatedFormat('d M Y'), 'Cocok kalau butuh waktu persiapan', '🗓️'],
    ];
    $dukungan = ['Video BISINDO' => ['🤟', true], 'Subtitle lengkap' => ['🔡', true], 'Modul PDF cetak' => ['📝', false], 'Juru bahasa sesi live' => ['🧑‍🏫', false]];
    $kartuRadio = 'chip flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3.5 transition hover:border-teal-500 peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15';
@endphp
<div id="kursus-modal" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="km-judul">
    <div class="pop-in flex max-h-[92vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="relative flex items-start gap-4 overflow-hidden bg-navy-900 p-5 text-white sm:p-6">
            <img id="km-foto" src="" alt="" class="absolute inset-0 h-full w-full object-cover opacity-25" aria-hidden="true">
            <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-900/90 to-navy-800/70" aria-hidden="true"></div>
            <div class="relative min-w-0 flex-1">
                <p class="text-[11px] font-bold uppercase tracking-widest text-teal-500">Daftar Pelatihan · Gratis</p>
                <h2 id="km-judul" tabindex="-1" class="mt-1 text-lg font-extrabold leading-snug focus:outline-none"></h2>
                <p id="km-penyelenggara" class="text-sm text-slate-300"></p>
                <div class="mt-3 flex flex-wrap gap-2 text-xs font-bold">
                    <span id="km-modul" class="rounded-full bg-white/10 px-3 py-1 ring-1 ring-white/20"></span>
                    <span id="km-durasi" class="rounded-full bg-white/10 px-3 py-1 ring-1 ring-white/20"></span>
                    <span id="km-bnsp" class="hidden rounded-full bg-emerald-500 px-3 py-1">✓ Sertifikat BNSP</span>
                </div>
            </div>
            <button type="button" class="modal-close relative grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-300 hover:bg-white/10 hover:text-white" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-kursus" class="flex min-h-0 flex-1 flex-col" novalidate>
            <div class="flex-1 space-y-5 overflow-y-auto px-5 py-5 sm:px-6">
                <div class="rounded-xl bg-teal-50 p-3.5 ring-1 ring-teal-100">
                    <p class="text-xs font-bold uppercase tracking-wider text-teal-600">Yang kamu dapatkan</p>
                    <ul id="km-fitur" class="mt-2 space-y-1 text-sm text-navy-900"></ul>
                </div>

                <div class="field">
                    <span class="mb-1.5 block text-sm font-semibold text-navy-900">Pilih cara belajar</span>
                    <div class="space-y-2">
                        @foreach ($jadwalPilihan as [$nama, $ket, $emoji])
                            <label class="block">
                                <input type="radio" name="jadwal" value="{{ $nama }}" required @checked($loop->first) class="peer sr-only">
                                <span class="{{ $kartuRadio }}">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-white text-xl shadow-sm" aria-hidden="true">{{ $emoji }}</span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-bold text-navy-900">{{ $nama }}</span>
                                        <span class="block text-[11px] text-slate-500">{{ $ket }}</span>
                                    </span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="field">
                    <span class="mb-1.5 block text-sm font-semibold text-navy-900">Dukungan belajar <span class="font-normal text-slate-400">(boleh lebih dari satu)</span></span>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($dukungan as $nama => [$emoji, $default])
                            <label>
                                <input type="checkbox" name="dukungan" value="{{ $nama }}" @checked($default) class="peer sr-only">
                                <span class="chip inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-slate-200 px-3.5 py-2 text-sm font-medium transition hover:border-teal-500 peer-checked:border-teal-500 peer-checked:bg-teal-500 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15"><span aria-hidden="true">{{ $emoji }}</span> {{ $nama }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="field">
                    <span class="mb-1.5 block text-sm font-semibold text-navy-900">Pengingat jadwal belajar lewat</span>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach (['WhatsApp (teks)' => '📲', 'Email' => '📧'] as $cara => $emoji)
                            <label>
                                <input type="radio" name="pengingat" value="{{ $cara }}" @checked($loop->first) class="peer sr-only">
                                <span class="chip flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-slate-200 py-3 text-sm font-semibold text-navy-900 transition hover:border-teal-500 peer-checked:border-navy-900 peer-checked:bg-navy-900 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15"><span aria-hidden="true">{{ $emoji }}</span> {{ $cara }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="field">
                    <label class="chip flex cursor-pointer items-start gap-3 rounded-xl border border-transparent bg-surface p-3.5">
                        <input type="checkbox" name="setuju" required data-required-msg="Centang persetujuan ini untuk melanjutkan pendaftaran." class="mt-0.5 h-4 w-4 rounded border-slate-300 accent-teal-600">
                        <span class="text-sm">Saya setuju nama dan kemajuan belajar saya dibagikan kepada penyelenggara untuk keperluan sertifikat.</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 sm:px-6">
                <button type="button" class="modal-close rounded-lg px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Batal</button>
                <button type="submit" id="km-kirim" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-teal-600 disabled:pointer-events-none disabled:opacity-70">
                    <svg id="km-spin" class="hidden h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25"/><path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v3a5 5 0 0 0-5 5H4Z" class="opacity-75"/></svg>
                    <span id="km-kirim-teks">Daftar Sekarang</span>
                </button>
            </div>
        </form>

        {{-- Layar sukses --}}
        <div id="km-sukses" class="hidden overflow-y-auto p-6 text-center sm:p-8">
            <div class="mx-auto grid h-20 w-20 place-items-center rounded-full bg-teal-50 ring-8 ring-teal-50/50">
                <svg class="draw-check h-10 w-10 text-teal-500" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            </div>
            
            <h3 class="mt-5 text-2xl font-extrabold text-navy-900">Pendaftaran berhasil</h3>
            <p id="km-sukses-judul" class="mt-1 text-sm font-semibold text-teal-600"></p>
            <ol class="mx-auto mt-6 max-w-sm space-y-3 text-left text-sm">
                <li class="flex gap-3"><span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-teal-500 text-xs font-bold text-white">1</span><span>Cara belajar: <b id="km-sukses-jadwal" class="text-navy-900"></b>.</span></li>
                <li class="flex gap-3"><span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-teal-500 text-xs font-bold text-white">2</span><span>Pengingat dikirim lewat <b id="km-sukses-pengingat" class="text-navy-900"></b>. Materi: <b id="km-sukses-dukungan" class="text-navy-900"></b>.</span></li>
                <li class="flex gap-3"><span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-teal-500 text-xs font-bold text-white">3</span><span id="km-sukses-akhir">Selesaikan semua modul untuk mendapatkan sertifikat.</span></li>
            </ol>
            <div class="mt-7 grid gap-2 sm:grid-cols-2">
                <button type="button" id="km-lihat" class="modal-close rounded-lg bg-navy-900 py-3 text-sm font-semibold text-white transition hover:bg-teal-600">Lihat di "Sedang Diikuti"</button>
                <button type="button" class="modal-close rounded-lg border border-slate-200 py-3 text-sm font-semibold text-navy-900 transition hover:border-navy-900">Jelajahi Pelatihan Lain</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { toast } = window.TunakerUI;
        const kursus = document.querySelectorAll('.kursus');

        document.querySelectorAll('.kategori-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.kategori-btn').forEach((b) => {
                    const aktif = b === btn;
                    b.classList.toggle('border-navy-900', aktif);
                    b.classList.toggle('bg-navy-900', aktif);
                    b.classList.toggle('text-white', aktif);
                    b.classList.toggle('border-slate-200', !aktif);
                    b.classList.toggle('bg-white', !aktif);
                    b.classList.toggle('text-slate-600', !aktif);
                });
                const k = btn.dataset.kategori;
                let tampil = 0;
                kursus.forEach((el) => {
                    const show = k === 'semua' || (k === 'diikuti' ? el.dataset.diikuti === '1' : el.dataset.kategori === k);
                    el.classList.toggle('hidden', !show);
                    if (show) { tampil++; el.classList.remove('pop-in'); void el.offsetWidth; el.classList.add('pop-in'); }
                });
                document.getElementById('kursus-kosong').classList.toggle('hidden', tampil > 0);
            });
        });

        /* ---------- Hitungan tab "Sedang Diikuti" ---------- */
        const hitung = () => {
            const n = [...kursus].filter((el) => el.dataset.diikuti === '1').length;
            document.querySelectorAll('[data-hitung="diikuti"]').forEach((el) => { el.textContent = `(${n})`; });
        };

        /* ---------- Daftar pelatihan ---------- */
        // TODO: simpan pendaftaran ke backend — sementara hanya ditandai di browser
        const { storage, openModal, checkField } = window.TunakerUI;
        const KEY = 'tunaker_kursus_terdaftar';
        const terdaftar = new Set(storage.get(KEY) || []);
        const form = document.getElementById('form-kursus');
        const $ = (id) => document.getElementById(id);
        let aktif = null;

        const tandai = () => {
            kursus.forEach((card) => {
                if (!terdaftar.has(card.dataset.id)) return;
                card.dataset.diikuti = '1';
                const btn = card.querySelector('[data-daftar-kursus]');
                if (btn) {
                    btn.classList.add('is-terkirim');
                    btn.setAttribute('aria-disabled', 'true');
                    btn.textContent = '✓ Terdaftar';
                }
            });
            hitung();
        };

        const buka = (d) => {
            aktif = d;
            form.reset();
            form.querySelectorAll('.field.is-invalid').forEach((f) => f.classList.remove('is-invalid'));
            form.querySelectorAll('.field-error').forEach((p) => p.classList.add('hidden'));
            form.classList.remove('hidden');
            $('km-sukses').classList.add('hidden');

            $('km-foto').src = `https://images.unsplash.com/photo-${d.foto}?auto=format&fit=crop&w=800&q=60`;
            $('km-judul').textContent = d.judul;
            $('km-penyelenggara').textContent = d.penyelenggara;
            $('km-modul').textContent = `📚 ${d.modul} modul`;
            $('km-durasi').textContent = `🗓️ ${d.durasi}`;
            $('km-bnsp').classList.toggle('hidden', d.bnsp !== '1');
            $('km-fitur').replaceChildren(...[...d.fitur.split('|'), d.bnsp === '1' ? 'Sertifikat BNSP setelah lulus' : 'Sertifikat penyelesaian'].map((teks) => {
                const li = document.createElement('li');
                li.className = 'flex gap-2';
                li.innerHTML = '<span class="text-teal-500">✓</span>';
                li.append(teks);
                return li;
            }));
            openModal('kursus-modal');
            $('km-judul').focus();
        };

        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-daftar-kursus]');
            if (!btn) return;
            if (btn.classList.contains('is-terkirim')) {
                toast('Kamu sudah terdaftar di pelatihan ini.', '✅');
                return;
            }
            buka({ ...btn.dataset });
        });

        form.addEventListener('change', (e) => { if (e.target.closest('.field.is-invalid')) checkField(e.target); });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!checkField(form.setuju)) return;

            const fd = new FormData(form);
            const dukungan = fd.getAll('dukungan');
            const tombol = $('km-kirim');
            tombol.disabled = true;
            $('km-spin').classList.remove('hidden');
            $('km-kirim-teks').textContent = 'Mendaftarkan…';

            setTimeout(() => {
                terdaftar.add(aktif.id);
                storage.set(KEY, [...terdaftar]);
                tandai();

                $('km-sukses-judul').textContent = aktif.judul;
                $('km-sukses-jadwal').textContent = fd.get('jadwal');
                $('km-sukses-pengingat').textContent = fd.get('pengingat');
                $('km-sukses-dukungan').textContent = dukungan.length ? dukungan.join(', ') : 'standar';
                $('km-sukses-akhir').textContent = aktif.bnsp === '1'
                    ? 'Selesaikan semua modul untuk mendapatkan sertifikat BNSP.'
                    : 'Selesaikan semua modul untuk mendapatkan sertifikat penyelesaian.';

                form.classList.add('hidden');
                $('km-sukses').classList.remove('hidden');
                $('km-sukses').classList.add('pop-in');

                tombol.disabled = false;
                $('km-spin').classList.add('hidden');
                $('km-kirim-teks').textContent = 'Daftar Sekarang';
            }, 800);
        });

        $('km-lihat').addEventListener('click', () => document.querySelector('.kategori-btn[data-kategori="diikuti"]').click());

        tandai();
    })();
</script>
@endpush
