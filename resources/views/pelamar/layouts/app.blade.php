<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') | TUNAKER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-slate-600 antialiased">

@php
    // CONTOH data pengguna — ganti dengan auth()->user() setelah login tersambung
    $pengguna = ['nama' => 'Andi Saputra', 'status' => 'Tuli · BISINDO', 'inisial' => 'AS'];

    $menu = [
        ['Beranda', 'beranda', 'm2.25 12 8.95-8.95a1.13 1.13 0 0 1 1.6 0L21.75 12M4.5 9.75v10.13c0 .62.5 1.12 1.13 1.12H9.75v-4.88c0-.62.5-1.12 1.13-1.12h2.25c.62 0 1.12.5 1.12 1.12V21h4.13c.62 0 1.12-.5 1.12-1.12V9.75M8.25 21h8.25'],
        ['Rekomendasi Pekerjaan', 'rekomendasi', 'M11.48 3.5a.56.56 0 0 1 1.04 0l2.13 5.11a.56.56 0 0 0 .48.35l5.52.44c.5.04.7.66.32.99l-4.2 3.6a.56.56 0 0 0-.18.56l1.28 5.38a.56.56 0 0 1-.84.61l-4.72-2.88a.56.56 0 0 0-.59 0l-4.72 2.88a.56.56 0 0 1-.84-.61l1.28-5.38a.56.56 0 0 0-.18-.56l-4.2-3.6a.56.56 0 0 1 .32-.99l5.52-.44a.56.56 0 0 0 .47-.35l2.13-5.11Z'],
        ['Pelatihan', 'pelatihan', 'M4.26 10.15A50.6 50.6 0 0 0 2.25 9.5 59.9 59.9 0 0 1 12 3.5a59.9 59.9 0 0 1 9.75 6 50.6 50.6 0 0 0-2 .65m-15.5 0a50.7 50.7 0 0 1 7.75 4.35 50.7 50.7 0 0 1 7.75-4.35m-15.5 0V15m15.5-4.85V15M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.68'],
        ['Konsultasi AI', 'konsultasi', 'M8.63 12a.38.38 0 1 1-.75 0 .38.38 0 0 1 .75 0Zm4.12 0a.38.38 0 1 1-.75 0 .38.38 0 0 1 .75 0Zm4.13 0a.38.38 0 1 1-.76 0 .38.38 0 0 1 .76 0ZM2.25 12.76c0 1.6 1.12 2.99 2.7 3.22 1.09.16 2.19.28 3.3.37V21l4.18-4.18a1.14 1.14 0 0 1 .78-.33 48.4 48.4 0 0 0 5.83-.5c1.58-.23 2.7-1.62 2.7-3.23V6.74c0-1.6-1.12-2.99-2.7-3.22A48.4 48.4 0 0 0 12 3c-2.39 0-4.73.17-7.02.52-1.58.23-2.7 1.62-2.7 3.22v6.02Z'],
        ['Lowongan Kerja', 'lowongan', 'M20.25 14.15v4.25c0 1.1-.78 2.04-1.86 2.18-2.08.28-4.21.42-6.39.42s-4.31-.14-6.39-.42c-1.08-.14-1.86-1.09-1.86-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.66V8.71c0-1.08-.77-2.01-1.84-2.17a48.4 48.4 0 0 0-3.41-.39M20.25 14.15a2.2 2.2 0 0 1-1.42.53H5.17c-.54 0-1.04-.2-1.42-.53m0 0A2.18 2.18 0 0 1 3 12.49V8.71c0-1.08.77-2.01 1.84-2.17a48.5 48.5 0 0 1 3.41-.39m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.89m7.5 0a48.7 48.7 0 0 0-7.5 0'],
        ['Riwayat Lamaran', 'riwayat', 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
        ['Profil Saya', 'profil', 'M17.98 18.73A7.48 7.48 0 0 0 12 15.75a7.48 7.48 0 0 0-5.98 2.98m11.96 0a9 9 0 1 0-11.96 0m11.96 0A8.97 8.97 0 0 1 12 21a8.97 8.97 0 0 1-5.98-2.27M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z'],
    ];

    $notifikasi = [
        ['📅', 'Wawancara besok 10.00 WIB', 'PT Solusi Digital · juru bahasa sudah disiapkan', '5 mnt'],
        ['💼', '6 lowongan baru cocok untukmu', 'Desain, Administrasi, IT', '1 jam'],
        ['✅', 'Lamaran dilihat perusahaan', 'Staff Administrasi · PT Sinar Jaya', 'Kemarin'],
    ];
@endphp

<div class="flex min-h-screen">
    {{-- ============ SIDEBAR ============ --}}
    <div id="sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-navy-950/50 backdrop-blur-sm lg:hidden"></div>
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-100 bg-white transition-transform duration-300 lg:sticky lg:top-0 lg:h-screen lg:w-64 lg:translate-x-0">
        <div class="flex h-20 items-center justify-between px-5">
            <a href="{{ route('beranda') }}"><img src="{{ asset('images/logo-tunaker.png') }}" alt="TUNAKER" class="h-11 w-auto"></a>
            <button type="button" id="sidebar-close" class="grid h-9 w-9 place-items-center rounded-lg text-slate-400 hover:bg-slate-100 lg:hidden" aria-label="Tutup menu">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-2">
            <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-widest text-slate-400">Menu</p>
            <ul class="space-y-1">
                @foreach ($menu as [$label, $rute, $ikon])
                    @php $aktif = $rute && request()->routeIs($rute, $rute . '.*'); @endphp
                    <li>
                        <a href="{{ $rute ? route($rute) : '#' }}"
                           class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $aktif ? 'bg-navy-900 text-white shadow-lg shadow-navy-900/20' : 'text-slate-600 hover:bg-surface hover:text-navy-900' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}"/></svg>
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="space-y-3 p-4">
            <div class="rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 p-4 text-white">
                <p class="text-2xl" aria-hidden="true">🤟</p>
                <p class="mt-2 text-sm font-bold">Butuh juru bahasa?</p>
                <p class="mt-0.5 text-xs text-slate-300">Hubungi layanan bantuan lewat chat atau video call isyarat.</p>
                <a href="#" class="mt-3 block rounded-lg bg-teal-500 py-2 text-center text-xs font-bold transition hover:bg-teal-600">Hubungi Bantuan</a>
            </div>
            <a href="{{ route('masuk') }}" class="flex items-center justify-center gap-2 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H21"/></svg>
                Keluar
            </a>
        </div>
    </aside>

    {{-- ============ KONTEN ============ --}}
    <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-30 border-b border-slate-100 bg-white/90 backdrop-blur">
            <div class="flex h-20 items-center gap-3 px-4 sm:px-6 lg:px-8">
                <button type="button" id="sidebar-open" class="grid h-10 w-10 shrink-0 place-items-center rounded-lg text-navy-900 hover:bg-slate-100 lg:hidden" aria-label="Buka menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <form class="relative min-w-0 flex-1 md:max-w-md" role="search" onsubmit="return false">
                    <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                    <input type="search" placeholder="Cari pekerjaan, pelatihan, atau informasi…" class="w-full rounded-xl border border-slate-200 bg-surface py-2.5 pl-11 pr-4 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-teal-500/15">
                </form>

                <div class="ml-auto flex items-center gap-2 sm:gap-3">
                    <button type="button" class="video-btn hidden items-center gap-2 rounded-xl border border-teal-100 bg-teal-50 px-3.5 py-2.5 text-sm font-semibold text-teal-600 transition hover:border-teal-500 sm:inline-flex"
                            data-video="" data-judul="Panduan penggunaan sistem TUNAKER">
                        <span aria-hidden="true">🤟</span> Bahasa Isyarat
                    </button>

                    {{-- Notifikasi visual --}}
                    <div class="relative">
                        <button type="button" id="notif-btn" class="relative grid h-11 w-11 place-items-center rounded-xl border border-slate-200 text-navy-900 transition hover:bg-surface" aria-label="Notifikasi" aria-expanded="false">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.86 17.08a23.85 23.85 0 0 0 5.45-1.31A8.97 8.97 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.97 8.97 0 0 1-2.31 6.02c1.73.64 3.55 1.08 5.45 1.31m5.72 0a24.26 24.26 0 0 1-5.72 0m5.72 0a3 3 0 1 1-5.72 0"/></svg>
                            <span class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white ring-2 ring-white">{{ count($notifikasi) }}</span>
                        </button>
                        <div id="notif-panel" class="absolute right-0 top-14 hidden w-80 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-2xl">
                            <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
                                <p class="text-sm font-extrabold text-navy-900">Notifikasi</p>
                                <a href="#" class="text-xs font-semibold text-teal-600 hover:underline">Tandai dibaca</a>
                            </div>
                            <ul class="divide-y divide-slate-100">
                                @foreach ($notifikasi as [$emoji, $judul, $ket, $waktu])
                                    <li class="flex gap-3 px-4 py-3 transition hover:bg-surface">
                                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-surface text-lg" aria-hidden="true">{{ $emoji }}</span>
                                        <span class="min-w-0 flex-1">
                                            <span class="block text-sm font-semibold text-navy-900">{{ $judul }}</span>
                                            <span class="block truncate text-xs text-slate-500">{{ $ket }}</span>
                                        </span>
                                        <span class="shrink-0 text-[11px] text-slate-400">{{ $waktu }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <a href="{{ route('profil') }}" class="flex items-center gap-3 rounded-xl py-1 pl-1 pr-1 transition hover:bg-surface sm:pr-3">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-teal-500 to-navy-800 text-sm font-bold text-white">{{ $pengguna['inisial'] }}</span>
                        <span class="hidden text-left sm:block">
                            <span class="block text-sm font-bold text-navy-900">{{ $pengguna['nama'] }}</span>
                            <span class="block text-xs text-slate-500">{{ $pengguna['status'] }}</span>
                        </span>
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
            @yield('content')
        </main>

        <footer class="border-t border-slate-100 bg-white px-4 py-4 text-xs text-slate-500 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <p class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-teal-500"></span> Standar aksesibilitas WCAG 2.1 AA · Ramah Tuli</p>
                <p>Layanan bantuan WhatsApp (teks): <b class="text-navy-900">0812-0000-0000</b></p>
                <p>&copy; {{ date('Y') }} TUNAKER</p>
            </div>
        </footer>
    </div>
</div>

@include('shared.a11y')
@include('shared.video-modal')
@include('pelamar.partials.lamar-modal')

<script type="module">
    (() => {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const toggleSidebar = (open) => {
            sidebar.classList.toggle('-translate-x-full', !open);
            backdrop.classList.toggle('hidden', !open);
        };
        document.getElementById('sidebar-open').addEventListener('click', () => toggleSidebar(true));
        document.getElementById('sidebar-close').addEventListener('click', () => toggleSidebar(false));
        backdrop.addEventListener('click', () => toggleSidebar(false));

        const notifBtn = document.getElementById('notif-btn');
        const notifPanel = document.getElementById('notif-panel');
        notifBtn.addEventListener('click', () => {
            const open = notifPanel.classList.toggle('hidden') === false;
            notifBtn.setAttribute('aria-expanded', open);
            if (open) notifPanel.classList.add('pop-in');
        });
        document.addEventListener('click', (e) => {
            if (!notifPanel.contains(e.target) && !notifBtn.contains(e.target)) notifPanel.classList.add('hidden');
        });
    })();
</script>
@stack('scripts')
</body>
</html>
