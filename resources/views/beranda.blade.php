@extends('layouts.app')

@section('title', 'Beranda')

@php
    // CONTOH data — ganti dengan data dari database setelah backend siap
    $statistik = [
        ['Rekomendasi Pekerjaan', 12, '+3 minggu ini', 'bg-teal-50 text-teal-600', 'M11.48 3.5a.56.56 0 0 1 1.04 0l2.13 5.11a.56.56 0 0 0 .48.35l5.52.44c.5.04.7.66.32.99l-4.2 3.6a.56.56 0 0 0-.18.56l1.28 5.38a.56.56 0 0 1-.84.61l-4.72-2.88a.56.56 0 0 0-.59 0l-4.72 2.88a.56.56 0 0 1-.84-.61l1.28-5.38a.56.56 0 0 0-.18-.56l-4.2-3.6a.56.56 0 0 1 .32-.99l5.52-.44a.56.56 0 0 0 .47-.35l2.13-5.11Z'],
        ['Pelatihan Tersedia', 8, '2 sedang diikuti', 'bg-violet-50 text-violet-600', 'M4.26 10.15A50.6 50.6 0 0 0 2.25 9.5 59.9 59.9 0 0 1 12 3.5a59.9 59.9 0 0 1 9.75 6 50.6 50.6 0 0 0-2 .65m-15.5 0a50.7 50.7 0 0 1 7.75 4.35 50.7 50.7 0 0 1 7.75-4.35m-15.5 0V15m15.5-4.85V15M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.68'],
        ['Lowongan Terbaru', 25, 'Semua ramah Tuli', 'bg-blue-50 text-blue-600', 'M20.25 14.15v4.25c0 1.1-.78 2.04-1.86 2.18-2.08.28-4.21.42-6.39.42s-4.31-.14-6.39-.42c-1.08-.14-1.86-1.09-1.86-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.66V8.71c0-1.08-.77-2.01-1.84-2.17a48.4 48.4 0 0 0-3.41-.39M20.25 14.15a2.2 2.2 0 0 1-1.42.53H5.17c-.54 0-1.04-.2-1.42-.53m0 0A2.18 2.18 0 0 1 3 12.49V8.71c0-1.08.77-2.01 1.84-2.17a48.5 48.5 0 0 1 3.41-.39m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.89m7.5 0a48.7 48.7 0 0 0-7.5 0'],
        ['Lamaran Saya', 3, '1 tahap wawancara', 'bg-amber-50 text-amber-600', 'M19.5 14.25v-2.63a3.38 3.38 0 0 0-3.38-3.37h-1.5A1.13 1.13 0 0 1 13.5 7.13v-1.5a3.38 3.38 0 0 0-3.38-3.38H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.63c-.62 0-1.13.5-1.13 1.13v17.25c0 .62.5 1.12 1.13 1.12h12.75c.62 0 1.12-.5 1.12-1.12V11.25a9 9 0 0 0-9-9Z'],
    ];

    // Data lowongan contoh ada di config/lowongan.php
    $aksesLabel = config('tunaker.akses');
    $rekomendasi = collect(config('lowongan.data'))->sortByDesc('cocok')->take(3);

    $pelatihan = [
        ['Microsoft Office Dasar', 'Disnaker Kota Bandung', 'Online · 4 minggu', '📊', 'bg-blue-50', 72],
        ['Desain Grafis Pemula', 'Kelas Tuli Kreatif', 'Hybrid · 6 minggu', '🎨', 'bg-pink-50', null],
        ['Pemrograman Web Dasar', 'Akademi Inklusi Digital', 'Online · 8 minggu', '💻', 'bg-teal-50', null],
    ];

    $lowonganBaru = collect(config('lowongan.data'))->sortBy('hari')->take(4);

    $kelengkapan = 78;
    $checklistProfil = [['Data diri', true], ['Keahlian', true], ['CV', true], ['Sertifikat', false], ['Portofolio', false]];
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">

    {{-- ============ SAMBUTAN ============ --}}
    <section class="grid gap-4 xl:grid-cols-[1fr_15rem]">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 text-white">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-teal-500/25 blur-3xl" aria-hidden="true"></div>
            <div class="relative grid items-center gap-6 p-6 sm:p-8 md:grid-cols-[1fr_15rem]">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-teal-500/20 px-3 py-1 text-xs font-bold text-teal-100 ring-1 ring-teal-500/40">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Profil Terverifikasi
                    </span>
                    <h1 class="mt-4 text-2xl font-extrabold sm:text-3xl">Halo, Andi Saputra</h1>
                    <p class="mt-2 max-w-xl text-sm leading-relaxed text-slate-300 sm:text-base">
                        Ada <b class="text-teal-500">6 lowongan baru</b> yang cocok dengan keahlianmu. Semuanya bisa dijalani lewat komunikasi tertulis atau bahasa isyarat.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="#rekomendasi" class="inline-flex items-center gap-2 rounded-lg bg-teal-500 px-5 py-2.5 text-sm font-semibold transition hover:bg-teal-600">
                            Lihat Rekomendasi
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <a href="{{ route('profil') }}" class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-5 py-2.5 text-sm font-semibold transition hover:bg-white/10">Perbarui CV</a>
                    </div>
                </div>
                <div class="relative hidden md:block">
                    <img src="https://images.unsplash.com/photo-1787647562374-97652f245581?auto=format&fit=crop&w=600&q=80" alt=""
                         class="aspect-[4/3] w-full rounded-2xl object-cover shadow-2xl ring-4 ring-white/10">
                    <div class="absolute -bottom-3 -left-4 flex items-center gap-2 rounded-xl bg-white px-3 py-2 text-xs font-bold text-navy-900 shadow-lg">
                        <span class="relative grid h-9 w-9 place-items-center">
                            <svg class="h-9 w-9 -rotate-90" viewBox="0 0 36 36"><circle cx="18" cy="18" r="15" fill="none" stroke="#e2e8f0" stroke-width="4"/><circle cx="18" cy="18" r="15" fill="none" stroke="#14a3a6" stroke-width="4" stroke-linecap="round" stroke-dasharray="{{ round(94.2 * $kelengkapan / 100, 1) }} 94.2"/></svg>
                            <span class="absolute text-[9px]">{{ $kelengkapan }}%</span>
                        </span>
                        Profil lengkap
                    </div>
                </div>
            </div>
        </div>

        {{-- Panduan video --}}
        <button type="button" class="video-btn group flex flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white text-left shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg sm:flex-row xl:flex-col"
                data-video="" data-judul="Panduan penggunaan sistem TUNAKER">
            <span class="relative block aspect-video shrink-0 overflow-hidden bg-navy-900 sm:w-56 xl:w-full">
                <img src="https://images.unsplash.com/photo-1789654246425-3c06dc5e2b4c?auto=format&fit=crop&w=500&q=70" alt="" class="h-full w-full object-cover opacity-70 transition group-hover:scale-105">
                <span class="absolute inset-0 grid place-items-center">
                    <span class="grid h-12 w-12 place-items-center rounded-full bg-teal-500 text-white shadow-xl ring-8 ring-teal-500/25 transition group-hover:scale-110">
                        <svg class="ml-0.5 h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5.14v13.72a1 1 0 0 0 1.52.85l10.79-6.86a1 1 0 0 0 0-1.7L9.52 4.29A1 1 0 0 0 8 5.14Z"/></svg>
                    </span>
                </span>
                <span class="absolute bottom-2 right-2 rounded bg-black/60 px-1.5 text-[11px] font-semibold text-white">2:30</span>
            </span>
            <span class="flex flex-1 flex-col justify-center p-5">
                <span class="text-xs font-bold uppercase tracking-widest text-teal-600">Bahasa Isyarat</span>
                <span class="mt-1 block font-extrabold leading-snug text-navy-900">Panduan Penggunaan Sistem TUNAKER</span>
                <span class="mt-1 block text-xs text-slate-500">Video BISINDO dengan teks lengkap.</span>
            </span>
        </button>
    </section>

    {{-- ============ STATISTIK ============ --}}
    <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ($statistik as [$label, $angka, $ket, $warna, $ikon])
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $label }}</p>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl {{ $warna }}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}"/></svg>
                    </span>
                </div>
                <p class="mt-2 text-3xl font-extrabold text-navy-900">{{ $angka }}</p>
                <p class="mt-1 text-xs font-semibold text-teal-600">{{ $ket }}</p>
            </div>
        @endforeach
    </section>

    {{-- ============ REKOMENDASI + KONSULTASI AI ============ --}}
    <section class="grid gap-6 xl:grid-cols-[1fr_22rem]">
        <div id="rekomendasi" class="scroll-mt-28 rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="flex items-center gap-2 text-lg font-extrabold text-navy-900">Rekomendasi Pekerjaan untuk Anda</h2>
                    <p class="text-sm">Dipilih berdasarkan keahlian dan cara komunikasimu.</p>
                </div>
                <a href="{{ route('rekomendasi') }}" class="text-sm font-semibold text-teal-600 hover:underline">Lihat Semua →</a>
            </div>

            <div class="mt-4 flex flex-wrap gap-2" role="tablist">
                @foreach (['Semua', 'Interview BISINDO', 'Remote / Hybrid'] as $filter)
                    <button type="button" class="job-filter rounded-full border px-3.5 py-1.5 text-xs font-semibold transition {{ $loop->first ? 'border-navy-900 bg-navy-900 text-white' : 'border-slate-200 text-slate-600 hover:border-teal-500' }}"
                            data-filter="{{ $loop->index }}">{{ $filter }}</button>
                @endforeach
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2 2xl:grid-cols-3">
                @foreach ($rekomendasi as $slug => $job)
                    <article class="job-card group flex flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white transition hover:-translate-y-1 hover:shadow-xl"
                             data-slug="{{ $slug }}" data-posisi="{{ $job['posisi'] }}"
                             data-bisindo="{{ in_array('bisindo', $job['akses']) ? 1 : 0 }}"
                             data-remote="{{ in_array($job['tipe'], ['Remote', 'Hybrid']) ? 1 : 0 }}">
                        <div class="relative aspect-[16/9] overflow-hidden bg-slate-100">
                            <img src="https://images.unsplash.com/photo-{{ $job['foto'] }}?auto=format&fit=crop&w=600&q=70" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <span class="absolute left-3 top-3 rounded-full bg-emerald-500 px-2.5 py-1 text-xs font-bold text-white shadow">{{ $job['cocok'] }}% Cocok</span>
                            <button type="button" class="bookmark absolute right-3 top-3 grid h-8 w-8 place-items-center rounded-full bg-white/90 text-slate-500 shadow transition hover:text-navy-900" aria-label="Simpan lowongan" aria-pressed="false">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.59 3.32c1.1.13 1.91 1.08 1.91 2.19V21L12 17.25 4.5 21V5.51c0-1.11.81-2.06 1.91-2.19a48.5 48.5 0 0 1 11.18 0Z"/></svg>
                            </button>
                        </div>
                        <div class="flex flex-1 flex-col p-4">
                            <h3 class="font-extrabold text-navy-900">{{ $job['posisi'] }}</h3>
                            <p class="text-sm">{{ $job['perusahaan'] }}</p>
                            <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-xs text-slate-500">
                                <span>📍 {{ $job['lokasi'] }}</span>
                                <span>🕒 {{ $job['tipe'] }}</span>
                            </div>
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach ($job['akses'] as $kunciAkses)
                                    <span class="rounded-md bg-teal-50 px-2 py-1 text-[11px] font-semibold text-teal-600">{{ $aksesLabel[$kunciAkses] }}</span>
                                @endforeach
                            </div>
                            <p class="mt-3 text-sm font-extrabold text-navy-900">Rp {{ str_replace('.', ',', $job['gaji'][0]) }} – {{ str_replace('.', ',', $job['gaji'][1]) }} jt <span class="text-xs font-medium text-slate-400">/ bulan</span></p>
                            <div class="mt-auto grid grid-cols-2 gap-2 pt-4">
                                <a href="{{ route('lowongan.detail', $slug) }}" class="rounded-lg border border-slate-200 py-2 text-center text-xs font-semibold text-navy-900 transition hover:border-navy-900">Lihat Detail</a>
                                <x-lowongan.lamar :job="$job" class="rounded-lg bg-navy-900 py-2 text-xs font-semibold text-white transition hover:bg-teal-600">Lamar Sekarang</x-lowongan.lamar>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <p id="job-empty" class="mt-5 hidden rounded-xl bg-surface p-6 text-center text-sm">Belum ada lowongan untuk filter ini.</p>
        </div>

        {{-- Konsultasi AI --}}
        <aside data-chat class="flex flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
            <div class="flex items-center gap-3 bg-gradient-to-br from-navy-900 to-navy-700 p-5 text-white">
                <span class="relative grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-white/10 text-2xl ring-1 ring-white/20" aria-hidden="true">
                    🤖
                    <span class="absolute -bottom-0.5 -right-0.5 h-3.5 w-3.5 rounded-full bg-emerald-400 ring-2 ring-navy-800"></span>
                </span>
                <div class="flex-1">
                    <h2 class="font-extrabold">Konsultasi AI</h2>
                    <p class="text-xs text-slate-300">Virtual Job Counselor · Online</p>
                </div>
                <a href="{{ route('konsultasi') }}" class="rounded-lg bg-white/10 px-3 py-1.5 text-xs font-bold ring-1 ring-white/20 transition hover:bg-white/20">Buka ↗</a>
            </div>

            <div data-chat-log class="flex max-h-80 min-h-56 flex-1 flex-col gap-3 overflow-y-auto bg-surface p-4">
                <div class="max-w-[85%] rounded-2xl rounded-tl-sm bg-white p-3 text-sm text-navy-900 shadow-sm">
                    Halo Andi, silakan tanya soal lowongan, CV, atau persiapan wawancara.
                </div>
            </div>

            <div class="space-y-3 border-t border-slate-100 p-4">
                <div class="flex flex-wrap gap-1.5">
                    @foreach (['Pekerjaan cocok untukku?', 'Cara membuat CV', 'Tips wawancara'] as $saran)
                        <button type="button" data-chat-ask class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold text-navy-900 transition hover:border-teal-500 hover:bg-teal-50">{{ $saran }}</button>
                    @endforeach
                </div>
                <form data-chat-form class="flex gap-2">
                    <input type="text" autocomplete="off" placeholder="Tulis pertanyaanmu…" aria-label="Pertanyaan untuk AI"
                           class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15">
                    <button type="submit" class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-navy-900 text-white transition hover:bg-teal-600" aria-label="Kirim">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.27 3.13A59.8 59.8 0 0 1 21.49 12 59.8 59.8 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/></svg>
                    </button>
                </form>
            </div>
        </aside>
    </section>

    {{-- ============ PELATIHAN + LOWONGAN TERBARU ============ --}}
    <section class="grid gap-6 xl:grid-cols-[1fr_22rem]">
        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="flex items-center gap-2 text-lg font-extrabold text-navy-900">Pelatihan yang Disarankan</h2>
                    <p class="text-sm">Tingkatkan keahlian dengan kelas yang menyediakan juru bahasa isyarat.</p>
                </div>
                <a href="{{ route('pelatihan') }}" class="text-sm font-semibold text-teal-600 hover:underline">Lihat Semua →</a>
            </div>
            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @foreach ($pelatihan as [$judul, $penyelenggara, $format, $emoji, $warna, $progres])
                    <div class="flex flex-col rounded-2xl border border-slate-100 p-4 transition hover:border-teal-500 hover:shadow-md">
                        <div class="flex items-start gap-3">
                            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl {{ $warna }} text-2xl" aria-hidden="true">{{ $emoji }}</span>
                            <div class="min-w-0">
                                <h3 class="text-sm font-extrabold leading-snug text-navy-900">{{ $judul }}</h3>
                                <p class="text-xs text-slate-500">{{ $penyelenggara }}</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">🗓️ {{ $format }} · <span class="font-semibold text-teal-600">Juru bahasa</span></p>
                        <div class="mt-auto pt-4">
                            @if ($progres)
                                <div class="flex items-center justify-between text-xs font-semibold">
                                    <span class="text-navy-900">Sedang diikuti</span>
                                    <span class="text-teal-600">{{ $progres }}%</span>
                                </div>
                                <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-gradient-to-r from-teal-500 to-navy-800" style="width: {{ $progres }}%"></div>
                                </div>
                                <a href="{{ route('pelatihan') }}" class="mt-3 block rounded-lg bg-teal-50 py-2 text-center text-xs font-semibold text-teal-600 transition hover:bg-teal-100">Lanjutkan Belajar</a>
                            @else
                                <a href="{{ route('pelatihan') }}" class="block rounded-lg border border-slate-200 py-2 text-center text-xs font-semibold text-navy-900 transition hover:border-navy-900 hover:bg-navy-900 hover:text-white">Daftar Kursus</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex items-center justify-between gap-3">
                <h2 class="flex items-center gap-2 text-lg font-extrabold text-navy-900">Lowongan Terbaru</h2>
                <a href="{{ route('lowongan') }}" class="text-sm font-semibold text-teal-600 hover:underline">Lihat Semua →</a>
            </div>
            <ul class="mt-4 divide-y divide-slate-100">
                @foreach ($lowonganBaru as $slug => $baru)
                    <li>
                        <a href="{{ route('lowongan.detail', $slug) }}" class="-mx-2 flex items-center gap-3 rounded-xl px-2 py-3 transition hover:bg-surface">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br {{ $baru['warna'] }} text-xl shadow" aria-hidden="true">{{ $baru['emoji'] }}</span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-sm font-bold text-navy-900">{{ $baru['posisi'] }}</span>
                                <span class="block truncate text-xs text-slate-500">{{ $baru['perusahaan'] }} · 📍 {{ $baru['lokasi'] }}</span>
                            </span>
                            <span class="shrink-0 text-right">
                                @if ($baru['hari'] === 0)
                                    <span class="block rounded-full bg-red-50 px-2 py-0.5 text-[10px] font-bold text-red-500">Baru</span>
                                @endif
                                <span class="mt-0.5 block text-[11px] text-slate-400">{{ $baru['hari'] === 0 ? 'Hari ini' : $baru['hari'] . ' hari lalu' }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>
    </section>

    {{-- ============ KELENGKAPAN PROFIL ============ --}}
    <section class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-col gap-5 md:flex-row md:items-center">
            <div class="flex items-center gap-4 md:w-80">
                <span class="relative grid h-16 w-16 shrink-0 place-items-center">
                    <svg class="h-16 w-16 -rotate-90" viewBox="0 0 36 36"><circle cx="18" cy="18" r="15" fill="none" stroke="#eefafa" stroke-width="4"/><circle cx="18" cy="18" r="15" fill="none" stroke="#14a3a6" stroke-width="4" stroke-linecap="round" stroke-dasharray="{{ round(94.2 * $kelengkapan / 100, 1) }} 94.2"/></svg>
                    <span class="absolute text-sm font-extrabold text-navy-900">{{ $kelengkapan }}%</span>
                </span>
                <div>
                    <h2 class="font-extrabold text-navy-900">Tingkatkan Profil Anda</h2>
                    <p class="text-sm">Profil lengkap membuat rekomendasi lebih akurat.</p>
                </div>
            </div>
            <div class="flex-1">
                <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full rounded-full bg-gradient-to-r from-teal-500 to-navy-800" style="width: {{ $kelengkapan }}%"></div>
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($checklistProfil as [$item, $selesai])
                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $selesai ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                            {{ $selesai ? '✓' : '○' }} {{ $item }}
                        </span>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('profil') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-navy-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
                Lengkapi Profil
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script type="module">
    (() => {
        /* ---------- Filter rekomendasi ---------- */
        const cards = document.querySelectorAll('.job-card');
        document.querySelectorAll('.job-filter').forEach((btn) => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.job-filter').forEach((b) => {
                    const active = b === btn;
                    b.classList.toggle('border-navy-900', active);
                    b.classList.toggle('bg-navy-900', active);
                    b.classList.toggle('text-white', active);
                    b.classList.toggle('border-slate-200', !active);
                    b.classList.toggle('text-slate-600', !active);
                });
                const filter = btn.dataset.filter;
                let shown = 0;
                cards.forEach((card) => {
                    const show = filter === '0' || (filter === '1' && card.dataset.bisindo === '1') || (filter === '2' && card.dataset.remote === '1');
                    card.classList.toggle('hidden', !show);
                    if (show) { shown++; card.classList.remove('pop-in'); void card.offsetWidth; card.classList.add('pop-in'); }
                });
                document.getElementById('job-empty').classList.toggle('hidden', shown > 0);
            });
        });

        /* ---------- Simpan lowongan ---------- */
        document.querySelectorAll('.bookmark').forEach((btn) => {
            btn.addEventListener('click', () => {
                const saved = btn.getAttribute('aria-pressed') !== 'true';
                btn.setAttribute('aria-pressed', saved);
                btn.classList.toggle('bg-navy-900', saved);
                btn.classList.toggle('text-white', saved);
                btn.classList.toggle('bg-white/90', !saved);
                btn.querySelector('svg').setAttribute('fill', saved ? 'currentColor' : 'none');
            });
        });

        // Chat Konsultasi AI ditangani resources/js/ai-chat.js lewat atribut data-chat
    })();
</script>
@endpush
