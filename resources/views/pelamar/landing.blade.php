<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TUNAKER | Layanan Pencari Kerja untuk Penyandang Tunarungu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-slate-600 antialiased">

@php
    $navLinks = [
        ['label' => 'Beranda', 'href' => '#beranda'],
        ['label' => 'Tentang', 'href' => '#tentang'],
        ['label' => 'Layanan', 'href' => '#layanan'],
        ['label' => 'Cara Kerja', 'href' => '#cara-kerja'],
        ['label' => 'Lowongan', 'href' => '#lowongan'],
        ['label' => 'Kontak', 'href' => '#kontak'],
    ];

    $layanan = [
        ['title' => 'Pencarian Kerja', 'desc' => 'Temukan lowongan yang sesuai dengan keahlian dan minat Anda.', 'color' => 'bg-teal-50 text-teal-600',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>'],
        ['title' => 'Rekomendasi AI', 'desc' => 'Lowongan disarankan sesuai profil dan CV Anda.', 'color' => 'bg-blue-50 text-blue-600',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.8 15.9 9 18.75l-.8-2.85a4.5 4.5 0 0 0-3.1-3.1L2.25 12l2.85-.8a4.5 4.5 0 0 0 3.1-3.1L9 5.25l.8 2.85a4.5 4.5 0 0 0 3.1 3.1l2.85.8-2.85.8a4.5 4.5 0 0 0-3.1 3.1ZM18.26 8.72 18 9.75l-.26-1.03a3.38 3.38 0 0 0-2.46-2.46L14.25 6l1.03-.26a3.38 3.38 0 0 0 2.46-2.46L18 2.25l.26 1.03a3.38 3.38 0 0 0 2.46 2.46l1.03.26-1.03.26a3.38 3.38 0 0 0-2.46 2.46Z"/>'],
        ['title' => 'Pelatihan Skill', 'desc' => 'Kelas keterampilan bersertifikat dengan video BISINDO dan subtitle.', 'color' => 'bg-emerald-50 text-emerald-600',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.15A50.6 50.6 0 0 0 2.25 9.5 59.9 59.9 0 0 1 12 3.5a59.9 59.9 0 0 1 9.75 6 50.6 50.6 0 0 0-2 .65m-15.5 0a50.7 50.7 0 0 1 7.75 4.35 50.7 50.7 0 0 1 7.75-4.35m-15.5 0V15m15.5-4.85V15M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.68"/>'],
        ['title' => 'Konsultasi Karier', 'desc' => 'Tanya soal CV, wawancara, atau arah karier lewat chat.', 'color' => 'bg-violet-50 text-violet-600',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.5c.88.28 1.5 1.12 1.5 2.08v4.29c0 1.14-.85 2.1-1.98 2.2-.34.02-.68.05-1.02.07v3.11l-3-3c-1.35 0-2.7-.06-4.02-.16a2.1 2.1 0 0 1-.82-.25M20.25 8.5a2.1 2.1 0 0 0-.48-.1 48.3 48.3 0 0 0-8.04 0A2.1 2.1 0 0 0 9.75 10.6v4.29c0 .84.46 1.58 1.13 1.96m9.37-8.35V6.63c0-1.62-1.15-3.03-2.76-3.24A48.4 48.4 0 0 0 11.25 3c-2.12 0-4.2.14-6.24.4-1.61.2-2.76 1.61-2.76 3.23v6.24c0 1.62 1.15 3.03 2.76 3.24.58.08 1.16.14 1.74.19V21l4.16-4.16"/>'],
        ['title' => 'Perusahaan Mitra', 'desc' => 'Lowongan datang dari perusahaan yang sudah kami verifikasi.', 'color' => 'bg-amber-50 text-amber-600',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.38c0-.62.5-1.12 1.13-1.12h1.74c.62 0 1.13.5 1.13 1.12V21"/>'],
    ];

    $langkah = [
        ['title' => 'Buat Akun', 'desc' => 'Daftar gratis, hanya butuh beberapa menit.',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.13a3.38 3.38 0 1 1-6.75 0 3.38 3.38 0 0 1 6.75 0ZM3 19.24v-.12a6.38 6.38 0 0 1 12.75 0v.12A12.3 12.3 0 0 1 9.37 21c-2.33 0-4.5-.64-6.37-1.76Z"/>'],
        ['title' => 'Lengkapi Profil', 'desc' => 'Isi data diri dan unggah CV Anda.',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.63a3.38 3.38 0 0 0-3.38-3.37h-1.5A1.13 1.13 0 0 1 13.5 7.13v-1.5a3.38 3.38 0 0 0-3.38-3.38H8.25m2.25 0H5.63c-.62 0-1.13.5-1.13 1.13v17.25c0 .62.5 1.12 1.13 1.12h12.75c.62 0 1.12-.5 1.12-1.12V11.25a9 9 0 0 0-9-9Z"/>'],
        ['title' => 'Analisis AI', 'desc' => 'Sistem membaca keahlian dan preferensi Anda.',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z"/>'],
        ['title' => 'Dapat Rekomendasi', 'desc' => 'Lihat lowongan yang paling sesuai.',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>'],
        ['title' => 'Lamar Pekerjaan', 'desc' => 'Kirim lamaran langsung dari TUNAKER.',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.27 3.13A59.8 59.8 0 0 1 21.49 12 59.8 59.8 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/>'],
    ];

    $lowongan = [
        ['posisi' => 'UI/UX Designer', 'perusahaan' => 'PT Kreasi Digital', 'lokasi' => 'Jakarta', 'tipe' => 'Full Time', 'gaji' => 'Rp 6 – 9 jt',
         'warna' => 'from-pink-500 to-rose-600',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.12a3 3 0 0 0-5.78 1.13 2.25 2.25 0 0 1-2.4 2.25 4.5 4.5 0 0 0 8.4-2.25c0-.4-.08-.78-.22-1.13Zm0 0a15.998 15.998 0 0 0 3.39-1.62m-5.04-.03a15.998 15.998 0 0 1 1.62-3.39m3.42 3.42a15.995 15.995 0 0 0 4.76-4.65l3.88-5.8a1.15 1.15 0 0 0-1.6-1.6l-5.8 3.88a15.996 15.996 0 0 0-4.65 4.76m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42"/>'],
        ['posisi' => 'Data Analyst Specialist', 'perusahaan' => 'PT Data Nusantara', 'lokasi' => 'Bandung', 'tipe' => 'Full Time', 'gaji' => 'Rp 7 – 10 jt',
         'warna' => 'from-blue-500 to-indigo-600',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.13C3 12.5 3.5 12 4.13 12h2.25c.62 0 1.12.5 1.12 1.13v6.75c0 .62-.5 1.12-1.12 1.12H4.13C3.5 21 3 20.5 3 19.88v-6.75ZM9.75 8.63c0-.63.5-1.13 1.13-1.13h2.25c.62 0 1.12.5 1.12 1.13v11.25c0 .62-.5 1.12-1.12 1.12h-2.25c-.63 0-1.13-.5-1.13-1.12V8.63ZM16.5 4.13c0-.63.5-1.13 1.13-1.13h2.25C20.5 3 21 3.5 21 4.13v15.75c0 .62-.5 1.12-1.12 1.12h-2.25c-.63 0-1.13-.5-1.13-1.12V4.13Z"/>'],
        ['posisi' => 'Digital Marketing Specialist', 'perusahaan' => 'CV Maju Bersama', 'lokasi' => 'Surabaya', 'tipe' => 'Hybrid', 'gaji' => 'Rp 5 – 8 jt',
         'warna' => 'from-amber-400 to-orange-500',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.3 4.3a11.95 11.95 0 0 1 5.81-5.52l2.74-1.22m0 0-5.94-2.28m5.94 2.28-2.28 5.94"/>'],
        ['posisi' => 'Backend Developer', 'perusahaan' => 'PT Teknologi Andal', 'lokasi' => 'Remote', 'tipe' => 'Remote', 'gaji' => 'Rp 9 – 14 jt',
         'warna' => 'from-teal-500 to-emerald-600',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5"/>'],
    ];

    // ID foto Unsplash bertema Tuli / bahasa isyarat & dunia kerja
    $heroSlides = [
        '1787647562374-97652f245581',
        '1758599543122-fc551c9b4b1c',
        '1522071820081-009f0129c71c',
        '1517568730816-501aae259c65',
        '1737567425973-bf7b6369d08a',
    ];

    $sosmed = [
        'Instagram' => 'M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.66 4.77-4.92 4.92-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85C2.38 3.92 3.9 2.38 7.15 2.23 8.42 2.17 8.8 2.16 12 2.16ZM12 0C8.74 0 8.33.01 7.05.07 2.7.27.27 2.69.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.36 2.62 6.78 6.98 6.98C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c4.35-.2 6.78-2.62 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.2-4.35-2.62-6.78-6.98-6.98C15.67.01 15.26 0 12 0Zm0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32ZM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.4-11.85a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88Z',
        'Facebook' => 'M9 8H6v4h3v12h5V12h3.64L18 8h-4V6.33C14 5.38 14.19 5 15.11 5H18V0h-3.81C10.6 0 9 1.58 9 4.61V8Z',
        'LinkedIn' => 'M4.98 3.5C4.98 4.88 3.87 6 2.5 6S.02 4.88.02 3.5 1.13 1 2.5 1s2.48 1.12 2.48 2.5ZM5 8H0v16h5V8Zm7.98 0H8.01v16h4.97v-8.4c0-4.67 6.03-5.05 6.03 0V24H24V13.87c0-7.88-8.92-7.6-11.02-3.72V8Z',
        'X' => 'M18.9 1.15h3.68l-8.04 9.19L24 22.85h-7.4l-5.8-7.58-6.64 7.58H.48l8.6-9.83L0 1.15h7.59l5.24 6.93 6.07-6.93Zm-1.29 19.5h2.04L6.48 3.24H4.3l13.31 17.41Z',
    ];
@endphp

{{-- ============ NAVBAR ============ --}}
<header class="sticky top-0 z-50 border-b border-slate-100 bg-white/90 backdrop-blur">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="#beranda" class="flex items-center">
            <img src="{{ asset('images/logo-tunaker.png') }}" alt="TUNAKER" class="h-11 w-auto">
        </a>

        <ul class="hidden items-center gap-8 text-sm font-medium text-slate-600 lg:flex">
            @foreach ($navLinks as $link)
                <li><a href="{{ $link['href'] }}" class="transition hover:text-teal-600">{{ $link['label'] }}</a></li>
            @endforeach
        </ul>

        <div class="hidden items-center gap-3 lg:flex">
            <a href="{{ route('masuk') }}" class="rounded-lg px-4 py-2 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Masuk</a>
            <a href="{{ route('daftar') }}" class="rounded-lg bg-navy-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-navy-800">Daftar</a>
        </div>

        <button id="menu-btn" class="rounded-lg p-2 text-navy-900 lg:hidden" aria-label="Buka menu">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </nav>

    <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white px-4 pb-4 lg:hidden">
        <ul class="space-y-1 pt-2 text-sm font-medium">
            @foreach ($navLinks as $link)
                <li><a href="{{ $link['href'] }}" class="block rounded-lg px-3 py-2 hover:bg-slate-50">{{ $link['label'] }}</a></li>
            @endforeach
        </ul>
        <div class="mt-3 grid grid-cols-2 gap-2">
            <a href="{{ route('masuk') }}" class="rounded-lg border border-slate-200 py-2 text-center text-sm font-semibold text-navy-900">Masuk</a>
            <a href="{{ route('daftar') }}" class="rounded-lg bg-navy-900 py-2 text-center text-sm font-semibold text-white">Daftar</a>
        </div>
    </div>
</header>

<main>
    {{-- ============ HERO ============ --}}
    <section id="beranda" class="relative isolate overflow-hidden bg-white">
        {{-- Slider gambar latar (berganti otomatis) --}}
        <div class="absolute inset-0 -z-10" aria-hidden="true">
            @foreach ($heroSlides as $slide)
                <img src="https://images.unsplash.com/photo-{{ $slide }}?auto=format&fit=crop&w=1920&q=80" alt=""
                     class="hero-slide absolute inset-0 h-full w-full object-cover transition-all duration-[1500ms] ease-in-out {{ $loop->first ? 'scale-100 opacity-100' : 'scale-105 opacity-0' }}"
                     @unless ($loop->first) loading="lazy" @endunless>
            @endforeach
            {{-- Overlay transparan agar teks tetap terbaca --}}
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/85 to-teal-50/40"></div>
            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-white to-transparent"></div>
        </div>

        <div class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-7xl flex-col justify-center px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-teal-100/90 px-3 py-1 text-xs font-bold tracking-wider text-teal-600 backdrop-blur">
                    <span class="h-1.5 w-1.5 rounded-full bg-teal-500"></span> TUNAKER · RAMAH TULI
                </span>
                <h1 class="mt-5 text-4xl font-extrabold uppercase leading-tight tracking-tight text-navy-900 sm:text-5xl lg:text-6xl">
                    Temukan Peluang Kerja Tanpa Batas Untuk Setiap <span class="text-teal-500">Talenta</span>
                </h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-slate-700 sm:text-lg">
                    TUNAKER membantu teman Tuli dan penyandang tunarungu mencari pekerjaan. Lowongan yang tampil berasal dari perusahaan yang sudah diverifikasi, dan semua informasinya disajikan lewat tulisan, gambar, serta panduan BISINDO.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#lowongan" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
                        Cari Lowongan
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="#cara-kerja" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-navy-900 transition hover:border-teal-500 hover:text-teal-600">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <div class="mt-14 flex flex-wrap items-center justify-between gap-6">
                <div class="flex flex-wrap gap-3">
                    @foreach ([['Perusahaan sudah diverifikasi', 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'], ['Lowongan sesuai keahlianmu', 'M9.8 15.9 9 18.75l-.8-2.85a4.5 4.5 0 0 0-3.1-3.1L2.25 12l2.85-.8a4.5 4.5 0 0 0 3.1-3.1L9 5.25l.8 2.85a4.5 4.5 0 0 0 3.1 3.1l2.85.8-2.85.8a4.5 4.5 0 0 0-3.1 3.1Z']] as [$teks, $ikon])
                        <div class="flex items-center gap-3 rounded-xl bg-white/80 px-4 py-3 shadow-md backdrop-blur">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-teal-100 text-teal-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}"/></svg>
                            </span>
                            <p class="text-sm font-semibold text-navy-900">{{ $teks }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="flex gap-2" role="tablist" aria-label="Pilih gambar">
                    @foreach ($heroSlides as $slide)
                        <button type="button" class="hero-dot h-2.5 rounded-full transition-all {{ $loop->first ? 'w-8 bg-navy-900' : 'w-2.5 bg-navy-900/30' }}"
                                data-index="{{ $loop->index }}" aria-label="Gambar {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ TENTANG ============ --}}
    <section id="tentang" class="py-20">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-teal-600">Tentang Kami</p>
                <h2 class="mt-2 text-3xl font-extrabold text-navy-900">TENTANG TUNAKER</h2>
                <p class="mt-5 leading-relaxed">
                    TUNAKER dibuat untuk memudahkan penyandang tunarungu mencari pekerjaan. Kami menghubungkan pencari kerja dengan perusahaan yang bersedia menyediakan juru bahasa isyarat, instruksi tertulis, dan akomodasi lain yang dibutuhkan.
                </p>
                <p class="mt-4 leading-relaxed">
                    Sistem kami mencocokkan keahlian dan cara berkomunikasi pencari kerja dengan lowongan yang tersedia, lalu menjelaskan kenapa sebuah lowongan disarankan.
                </p>
                <div class="mt-8 flex gap-10">
                    <div>
                        <p class="text-3xl font-extrabold text-navy-900">1.250<span class="text-teal-500">+</span></p>
                        <p class="text-sm">Pencari Kerja</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-navy-900">85<span class="text-teal-500">+</span></p>
                        <p class="text-sm">Perusahaan Mitra</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-surface p-8 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-widest text-teal-600">Visi Kami</p>
                <h3 class="mt-2 text-xl font-bold text-navy-900">Kesempatan kerja yang sama</h3>
                <p class="mt-3 text-sm leading-relaxed">
                    Menghubungkan pencari kerja Tuli dengan perusahaan yang siap bekerja bersama mereka.
                </p>
                <div class="mt-6 flex items-center gap-3 rounded-xl bg-white p-4 shadow-sm">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-navy-900 text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.04A11.96 11.96 0 0 1 3.6 6 11.99 11.99 0 0 0 3 9.75c0 5.59 3.82 10.29 9 11.62 5.18-1.33 9-6.03 9-11.62 0-1.31-.21-2.57-.6-3.75h-.15c-3.2 0-6.1-1.25-8.25-3.29Z"/></svg>
                    </span>
                    <p class="text-sm font-semibold text-navy-900">Perusahaan mitra diverifikasi sebelum membuka lowongan</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ LAYANAN ============ --}}
    <section id="layanan" class="bg-surface py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-extrabold text-navy-900">LAYANAN TUNAKER</h2>
                <p class="mt-3">Solusi lengkap untuk mendukung perjalanan karier yang berarti dan berkelanjutan.</p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
                @foreach ($layanan as $item)
                    <div class="group rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <span class="grid h-12 w-12 place-items-center rounded-xl {{ $item['color'] }}">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">{!! $item['icon'] !!}</svg>
                        </span>
                        <h3 class="mt-5 font-bold text-navy-900">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                        <a href="#" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-teal-600 group-hover:gap-2 transition-all">
                            Selengkapnya <span aria-hidden="true">→</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ CARA KERJA ============ --}}
    <section id="cara-kerja" class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-extrabold text-navy-900">CARA KERJA TUNAKER</h2>
                <p class="mt-3">Proses sederhana untuk mendapatkan rekomendasi pekerjaan yang sesuai.</p>
            </div>

            <ol class="relative mt-14 grid gap-10 sm:grid-cols-2 lg:grid-cols-5">
                <div class="absolute left-[10%] right-[10%] top-10 hidden h-0.5 bg-gradient-to-r from-teal-100 via-teal-500 to-navy-900 lg:block" aria-hidden="true"></div>
                @foreach ($langkah as $i => $step)
                    <li class="relative text-center">
                        <div class="mx-auto grid h-20 w-20 place-items-center rounded-full border-4 border-white shadow-md
                                    {{ $loop->last ? 'bg-navy-900 text-white' : 'bg-teal-50 text-teal-600' }}">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">{!! $step['icon'] !!}</svg>
                        </div>
                        <p class="mt-4 text-xs font-bold text-teal-600">LANGKAH {{ $i + 1 }}</p>
                        <h3 class="mt-1 font-bold text-navy-900">{{ $step['title'] }}</h3>
                        <p class="mt-1 text-sm">{{ $step['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ============ LOWONGAN ============ --}}
    <section id="lowongan" class="bg-surface py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-navy-900">LOWONGAN KERJA TERBARU</h2>
                    <p class="mt-3">Temukan peluang karier terbaru dari berbagai perusahaan terverifikasi.</p>
                </div>
                <a href="#" class="rounded-lg border border-navy-900 px-5 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-navy-900 hover:text-white">
                    Lihat Semua
                </a>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($lowongan as $job)
                    <article class="flex flex-col rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex items-center gap-3">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br {{ $job['warna'] }} text-white shadow-md">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">{!! $job['icon'] !!}</svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="truncate font-bold text-navy-900">{{ $job['posisi'] }}</h3>
                                <p class="truncate text-xs">{{ $job['perusahaan'] }}</p>
                            </div>
                        </div>
                        <div class="mt-5 flex flex-wrap gap-2 text-xs font-medium">
                            <span class="rounded-full bg-teal-50 px-3 py-1 text-teal-600">{{ $job['tipe'] }}</span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">{{ $job['lokasi'] }}</span>
                        </div>
                        <p class="mt-4 text-sm font-semibold text-navy-900">{{ $job['gaji'] }} <span class="font-normal text-slate-500">/ bulan</span></p>
                        <a href="#" class="mt-6 rounded-lg bg-navy-900 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-teal-600">
                            Lamar Sekarang
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ CTA ============ --}}
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl bg-navy-900 px-8 py-12 sm:px-12">
                <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-teal-500/20 blur-2xl" aria-hidden="true"></div>
                <div class="relative flex flex-col items-start justify-between gap-6 lg:flex-row lg:items-center">
                    <div>
                        <h2 class="text-2xl font-extrabold text-white sm:text-3xl">Mulai cari kerja hari ini</h2>
                        <p class="mt-2 text-slate-300">Buat akun gratis, lengkapi profil, lalu lihat lowongan yang cocok untuk Anda.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('daftar') }}" class="rounded-lg bg-teal-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-teal-600">Daftar Sekarang</a>
                        <a href="#lowongan" class="rounded-lg border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Lihat Lowongan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

{{-- ============ FOOTER ============ --}}
<footer id="kontak" class="bg-navy-950 text-slate-400">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
        <div>
            <a href="#beranda" class="inline-block">
                <img src="{{ asset('images/logo-tunaker-light.png') }}" alt="TUNAKER" class="h-14 w-auto">
            </a>
            <p class="mt-4 text-sm leading-relaxed">Sistem layanan pencari kerja untuk penyandang tunarungu.</p>
        </div>
        <div>
            <h4 class="font-semibold text-white">Navigasi</h4>
            <ul class="mt-4 space-y-2 text-sm">
                @foreach (array_slice($navLinks, 0, 5) as $link)
                    <li><a href="{{ $link['href'] }}" class="hover:text-teal-500">{{ $link['label'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="font-semibold text-white">Bantuan</h4>
            <ul class="mt-4 space-y-2 text-sm">
                <li><a href="#" class="hover:text-teal-500">FAQ</a></li>
                <li><a href="#" class="hover:text-teal-500">Kebijakan Privasi</a></li>
                <li><a href="#" class="hover:text-teal-500">Syarat & Ketentuan</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold text-white">Kontak</h4>
            <ul class="mt-4 space-y-2 text-sm">
                <li>info@tunaker.id</li>
                <li>+62 812-0000-0000</li>
            </ul>
            <div class="mt-4 flex gap-2">
                @foreach ($sosmed as $nama => $path)
                    <a href="#" aria-label="{{ $nama }}" class="grid h-9 w-9 place-items-center rounded-lg bg-white/5 text-slate-300 transition hover:bg-teal-500 hover:text-white">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="border-t border-white/10 py-6 text-center text-xs">
        &copy; {{ date('Y') }} TUNAKER. Semua hak dilindungi.
    </div>
</footer>

<script>
    document.getElementById('menu-btn').addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // Slider gambar hero
    (() => {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.hero-dot');
        let current = 0;
        let timer;

        const show = (index) => {
            slides[current].classList.replace('opacity-100', 'opacity-0');
            slides[current].classList.replace('scale-100', 'scale-105');
            dots[current].classList.replace('w-8', 'w-2.5');
            dots[current].classList.replace('bg-navy-900', 'bg-navy-900/30');

            current = index;

            slides[current].classList.replace('opacity-0', 'opacity-100');
            slides[current].classList.replace('scale-105', 'scale-100');
            dots[current].classList.replace('w-2.5', 'w-8');
            dots[current].classList.replace('bg-navy-900/30', 'bg-navy-900');
        };

        const start = () => {
            clearInterval(timer);
            timer = setInterval(() => show((current + 1) % slides.length), 5000);
        };

        dots.forEach((dot) => dot.addEventListener('click', () => {
            show(Number(dot.dataset.index));
            start();
        }));

        start();
    })();
</script>
</body>
</html>
