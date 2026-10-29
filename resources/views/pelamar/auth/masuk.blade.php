<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | TUNAKER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-slate-600 antialiased">

@php
    $input = 'w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';

    // 'video' diisi URL video panduan BISINDO (mp4)
    $panelKiri = [
        'manual' => ['foto' => '1758600432914-2b5f4483c7b8', 'video' => null, 'badge' => 'Platform Kerja Ramah Tuli',
                     'judul' => 'Membuka Gerbang Karier Inklusif Bersama TUNAKER',
                     'teks' => 'Masuk untuk melihat lowongan yang cocok, memantau lamaran, dan terhubung dengan perusahaan ramah disabilitas.'],
        'rfid' => ['foto' => '1710988238169-12c5c2474652', 'video' => null, 'badge' => 'Masuk Cepat Tanpa Mengetik',
                   'judul' => 'Gerbang Menuju Peluang Karier Inklusif & Mandiri',
                   'teks' => 'Cukup tempelkan kartu TUNAKER atau Smart ID ke alat pembaca. Semua tanda ditampilkan secara visual.'],
    ];

    $fiturRfid = [
        ['⚡', 'Smart Tap Otomatis', 'Tempel kartu, langsung masuk dalam hitungan detik.'],
        ['🤟', 'Panduan Video BISINDO', 'Setiap langkah dijelaskan dengan bahasa isyarat.'],
        ['🛡️', 'Aman & Terverifikasi', 'Kartu terhubung ke akun yang sudah diverifikasi.'],
    ];
@endphp

<div class="flex min-h-screen">
    {{-- ============ PANEL KIRI ============ --}}
    <aside class="sticky top-0 hidden h-screen w-[42%] max-w-xl flex-col overflow-hidden bg-navy-950 p-10 text-white lg:flex">
        @foreach ($panelKiri as $mode => $panel)
            <img src="https://images.unsplash.com/photo-{{ $panel['foto'] }}?auto=format&fit=crop&w=1200&q=80" alt=""
                 class="side-photo absolute inset-0 h-full w-full object-cover transition-all duration-1000 ease-out {{ $loop->first ? 'scale-100 opacity-100' : 'scale-110 opacity-0' }}"
                 data-mode="{{ $mode }}" aria-hidden="true">
        @endforeach
        <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/80 to-navy-900/30" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-teal-500/25 via-transparent to-transparent mix-blend-overlay" aria-hidden="true"></div>

        <div class="relative flex items-start justify-between gap-4">
            <a href="{{ route('home') }}" class="inline-block drop-shadow-lg">
                <img src="{{ asset('images/logo-tunaker-light.png') }}" alt="TUNAKER" class="h-12 w-auto">
            </a>
            <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold backdrop-blur-md">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-teal-500 opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-teal-500"></span>
                </span>
                Ramah Tuli · BISINDO
            </span>
        </div>

        @foreach ($panelKiri as $mode => $panel)
            <div class="mode-panel relative mt-auto {{ $loop->first ? '' : 'hidden' }}" data-mode="{{ $mode }}">
                <span class="inline-flex items-center gap-2 rounded-full bg-teal-500/20 px-3 py-1 text-xs font-bold uppercase tracking-wider text-teal-100 ring-1 ring-teal-500/40 backdrop-blur">
                    {{ $panel['badge'] }}
                </span>
                <h2 class="mt-4 text-3xl font-extrabold leading-tight drop-shadow xl:text-4xl">{{ $panel['judul'] }}</h2>
                <p class="mt-3 leading-relaxed text-slate-200">{{ $panel['teks'] }}</p>

                @if ($mode === 'manual')
                    <button type="button" class="video-btn group mt-6 flex w-full items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-3 text-left backdrop-blur-md transition hover:bg-white/15"
                            data-video="{{ $panel['video'] }}" data-judul="Cara masuk ke akun TUNAKER">
                        <span class="relative grid h-16 w-24 shrink-0 place-items-center overflow-hidden rounded-xl bg-navy-800">
                            <img src="https://images.unsplash.com/photo-{{ $panel['foto'] }}?auto=format&fit=crop&w=200&q=60" alt="" class="absolute inset-0 h-full w-full object-cover opacity-60">
                            <span class="relative grid h-9 w-9 place-items-center rounded-full bg-teal-500 shadow-lg transition group-hover:scale-110">
                                <svg class="ml-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5.14v13.72a1 1 0 0 0 1.52.85l10.79-6.86a1 1 0 0 0 0-1.7L9.52 4.29A1 1 0 0 0 8 5.14Z"/></svg>
                            </span>
                            <span class="absolute bottom-1 right-1 rounded bg-black/60 px-1 text-[10px] font-semibold">0:35</span>
                        </span>
                        <span>
                            <span class="block text-sm font-bold">Dukungan Bahasa Isyarat</span>
                            <span class="mt-0.5 block text-xs text-slate-300">Tonton cara masuk akun dalam BISINDO, lengkap dengan teks.</span>
                        </span>
                    </button>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md">
                            <p class="text-2xl font-extrabold">1.250<span class="text-teal-500">+</span></p>
                            <p class="text-xs text-slate-300">Pencari kerja bergabung</p>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md">
                            <p class="text-2xl font-extrabold">85<span class="text-teal-500">+</span></p>
                            <p class="text-xs text-slate-300">Perusahaan mitra</p>
                        </div>
                    </div>
                @else
                    <ul class="mt-6 space-y-3">
                        @foreach ($fiturRfid as [$emoji, $judul, $ket])
                            <li class="flex items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-3.5 backdrop-blur-md">
                                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-teal-500/20 text-xl ring-1 ring-teal-500/40" aria-hidden="true">{{ $emoji }}</span>
                                <span>
                                    <span class="block text-sm font-bold">{{ $judul }}</span>
                                    <span class="block text-xs text-slate-300">{{ $ket }}</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach

        <p class="relative mt-8 text-xs text-slate-400">&copy; {{ date('Y') }} TUNAKER · Sistem Layanan Pencari Kerja untuk Penyandang Tunarungu</p>
    </aside>

    {{-- ============ FORM ============ --}}
    <main class="flex min-w-0 flex-1 flex-col">
        <header class="flex items-center justify-between px-6 py-5 sm:px-10">
            <a href="{{ route('home') }}" class="lg:hidden">
                <img src="{{ asset('images/logo-tunaker.png') }}" alt="TUNAKER" class="h-10 w-auto">
            </a>
            <a href="{{ route('home') }}" class="hidden items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-teal-600 lg:inline-flex">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
                Kembali ke Beranda
            </a>
            <p class="text-sm">Belum punya akun? <a href="{{ route('daftar') }}" class="font-semibold text-teal-600 hover:underline">Daftar</a></p>
        </header>

        <div class="flex flex-1 items-center justify-center px-6 pb-12 sm:px-10">
            <div class="w-full max-w-lg">
                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-teal-600">Selamat datang kembali</p>
                            <h1 class="mt-1 text-2xl font-extrabold text-navy-900">Masuk ke Akun</h1>
                            <p class="mt-1 text-sm">Akses semua layanan TUNAKER untuk mencari kerja yang ramah Tuli.</p>
                        </div>
                        <button type="button" class="video-btn inline-flex shrink-0 items-center gap-1.5 rounded-full bg-navy-900 px-3 py-2 text-xs font-bold text-white lg:hidden"
                                data-video="{{ $panelKiri['manual']['video'] }}" data-judul="Cara masuk ke akun TUNAKER">
                            BISINDO
                        </button>
                    </div>

                    {{-- Pilihan cara masuk --}}
                    <div class="mt-6 grid grid-cols-2 gap-1 rounded-xl bg-surface p-1" role="tablist">
                        @foreach (['manual' => ['🔑', 'Login Manual'], 'rfid' => ['💳', 'Kartu RFID / Smart ID']] as $mode => [$emoji, $teks])
                            <button type="button" role="tab" data-mode="{{ $mode }}"
                                    class="mode-tab flex items-center justify-center gap-2 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ $loop->first ? 'bg-navy-900 text-white shadow' : 'text-slate-500 hover:text-navy-900' }}">
                                <span aria-hidden="true">{{ $emoji }}</span> {{ $teks }}
                            </button>
                        @endforeach
                    </div>

                    {{-- ---------- MODE MANUAL ---------- --}}
                    <form id="form-masuk" method="POST" class="mode-panel anim-next mt-6 space-y-5" data-mode="manual" novalidate>
                        @csrf
                        <div class="field">
                            <x-pelamar.daftar.label for="identitas" hint="Tulis email atau nomor WhatsApp yang kamu pakai saat mendaftar.">Email / No. WhatsApp</x-pelamar.daftar.label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 grid w-11 place-items-center text-slate-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.12a7.5 7.5 0 0 1 15 0A17.93 17.93 0 0 1 12 21.75c-2.68 0-5.22-.58-7.5-1.63Z"/></svg>
                                </span>
                                <input id="identitas" name="identitas" type="text" required autocomplete="username"
                                       placeholder="nama@email.com atau 08xxxxxxxxxx" class="{{ $input }} pl-11">
                            </div>
                        </div>

                        <div class="field">
                            <x-pelamar.daftar.label for="password" hint="Kata sandi yang kamu buat saat mendaftar.">Kata Sandi</x-pelamar.daftar.label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 grid w-11 place-items-center text-slate-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                </span>
                                <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Masukkan kata sandi" class="{{ $input }} pl-11 pr-11">
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 grid w-11 place-items-center text-slate-400 hover:text-navy-900" aria-label="Tampilkan kata sandi">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.04 12.32a1 1 0 0 1 0-.64C3.42 7.51 7.36 4.5 12 4.5c4.64 0 8.57 3 9.96 7.18.07.2.07.43 0 .64C20.58 16.49 16.64 19.5 12 19.5c-4.64 0-8.57-3-9.96-7.18Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                </button>
                            </div>
                            <p id="caps-warning" class="mt-1.5 hidden items-center gap-1.5 text-xs font-semibold text-amber-600">Caps Lock sedang aktif</p>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <label class="flex cursor-pointer items-center gap-2 text-sm">
                                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 accent-teal-600">
                                Ingat saya di perangkat ini
                            </label>
                            <a href="#" class="text-sm font-semibold text-teal-600 hover:underline">Lupa kata sandi?</a>
                        </div>

                        <button type="submit" id="btn-masuk" class="flex w-full items-center justify-center gap-2 rounded-lg bg-navy-900 py-3.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:-translate-y-0.5 hover:bg-navy-800 disabled:pointer-events-none disabled:opacity-70">
                            <svg id="btn-masuk-spin" class="hidden h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25"/><path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v3a5 5 0 0 0-5 5H4Z" class="opacity-75"/></svg>
                            <span id="btn-masuk-teks">Masuk ke Akun TUNAKER</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/></svg>
                        </button>

                        <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-widest text-slate-400">
                            <span class="h-px flex-1 bg-slate-200"></span> atau <span class="h-px flex-1 bg-slate-200"></span>
                        </div>

                        <button type="button" data-switch="rfid" class="flex w-full items-center gap-4 rounded-xl border border-teal-100 bg-teal-50 p-4 text-left transition hover:border-teal-500">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-white text-2xl shadow-sm" aria-hidden="true">💳</span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-sm font-bold text-navy-900">Tempelkan Kartu RFID / Smart ID <span class="ml-1 rounded-full bg-teal-500 px-2 py-0.5 text-[10px] font-bold text-white">Cepat</span></span>
                                <span class="block text-xs text-slate-500">Masuk tanpa mengetik email dan kata sandi.</span>
                            </span>
                            <span class="text-sm font-semibold text-teal-600">Pakai →</span>
                        </button>
                    </form>

                    {{-- ---------- MODE RFID ---------- --}}
                    <div class="mode-panel mt-6 hidden" data-mode="rfid">
                        <div id="rfid-box" class="relative overflow-hidden rounded-2xl border-2 border-dashed border-slate-200 bg-surface px-6 py-8 text-center transition-colors duration-300">
                            <div class="relative mx-auto grid h-28 w-28 place-items-center">
                                <span class="rfid-ring absolute inset-0 animate-ping rounded-full bg-teal-500/20"></span>
                                <span class="rfid-ring absolute inset-3 animate-pulse rounded-full bg-teal-500/20"></span>
                                <span id="rfid-icon" class="relative grid h-20 w-20 place-items-center rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 text-4xl text-white shadow-xl transition">💳</span>
                            </div>
                            <h2 class="mt-5 text-lg font-extrabold text-navy-900">Tempelkan Kartu TUNAKER / Smart ID</h2>
                            <p class="mx-auto mt-1 max-w-sm text-sm">Dekatkan kartu ke alat pembaca. Kotak ini akan <b class="text-teal-600">berubah hijau</b> saat kartu terbaca, tanpa bunyi.</p>

                            <p id="rfid-status" class="mt-5 inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-amber-600 shadow-sm">
                                <span class="h-2.5 w-2.5 animate-pulse rounded-full bg-amber-500"></span>
                                <span id="rfid-status-text">Menunggu kartu ditempelkan…</span>
                            </p>

                            {{-- Alat pembaca RFID USB bekerja seperti keyboard: mengetik nomor kartu lalu Enter --}}
                            <input id="rfid-reader" type="text" autocomplete="off" inputmode="none" aria-label="Pembaca kartu" class="absolute h-px w-px opacity-0">
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <button type="button" id="btn-ketik-kartu" class="flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white py-2.5 text-sm font-semibold text-navy-900 transition hover:border-teal-500">
                                Ketik Nomor Kartu
                            </button>
                            <button type="button" disabled class="flex cursor-not-allowed items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white py-2.5 text-sm font-semibold text-slate-400">
                                Scan QR <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px]">Segera</span>
                            </button>
                        </div>

                        <form id="form-kartu" class="field mt-4 hidden" novalidate>
                            <x-pelamar.daftar.label for="nomor_kartu" hint="Nomor yang tercetak di bagian belakang kartu TUNAKER atau Smart ID.">Nomor Kartu</x-pelamar.daftar.label>
                            <div class="flex gap-2">
                                <input id="nomor_kartu" name="nomor_kartu" type="text" inputmode="numeric" required pattern="[0-9]{6,16}"
                                       data-pattern-msg="Nomor kartu berisi 6–16 angka." placeholder="Contoh: 0012345678" class="{{ $input }}">
                                <button type="submit" class="shrink-0 rounded-lg bg-navy-900 px-5 text-sm font-semibold text-white transition hover:bg-navy-800">Masuk</button>
                            </div>
                        </form>

                        <div class="mt-4 flex gap-3 rounded-xl bg-teal-50 p-4 ring-1 ring-teal-100">
                            <span class="text-xl" aria-hidden="true">💡</span>
                            <p class="text-sm text-navy-900">Belum punya kartu? Informasi pengambilan kartu dikirim setelah akunmu terverifikasi.</p>
                        </div>
                    </div>
                </div>

                <p class="mt-6 text-center text-sm">Belum memiliki akun TUNAKER? <a href="{{ route('daftar') }}" class="font-semibold text-teal-600 hover:underline">Daftar Sekarang</a></p>
            </div>
        </div>
    </main>
</div>

@include('shared.a11y')
@include('shared.video-modal')

{{-- Notifikasi visual --}}
<div id="toast" class="pointer-events-none fixed inset-x-0 top-5 z-[60] hidden justify-center px-4">
    <div class="pop-in flex max-w-md items-center gap-3 rounded-xl bg-navy-900 px-5 py-4 text-sm font-medium text-white shadow-2xl">
        <span id="toast-icon" class="text-xl" aria-hidden="true">ℹ️</span>
        <span id="toast-text"></span>
    </div>
</div>

{{-- type="module" agar dijalankan setelah app.js (window.TunakerUI) --}}
<script type="module">
    (() => {
        const { storage, checkField } = window.TunakerUI;
        const MODE_KEY = 'tunaker_mode_masuk';
        const form = document.getElementById('form-masuk');
        const reader = document.getElementById('rfid-reader');
        const rfidBox = document.getElementById('rfid-box');
        let mode = 'manual';

        const toast = (text, icon = 'ℹ️') => {
            const el = document.getElementById('toast');
            document.getElementById('toast-text').textContent = text;
            document.getElementById('toast-icon').textContent = icon;
            el.classList.replace('hidden', 'flex');
            clearTimeout(toast.timer);
            toast.timer = setTimeout(() => el.classList.replace('flex', 'hidden'), 4000);
        };

        /* ---------- Ganti cara masuk ---------- */
        const setMode = (next) => {
            mode = next;
            storage.set(MODE_KEY, mode);

            document.querySelectorAll('.mode-tab').forEach((tab) => {
                const active = tab.dataset.mode === mode;
                tab.setAttribute('aria-selected', active);
                tab.className = 'mode-tab flex items-center justify-center gap-2 rounded-lg px-3 py-2.5 text-sm font-semibold transition ' +
                    (active ? 'bg-navy-900 text-white shadow' : 'text-slate-500 hover:text-navy-900');
            });
            document.querySelectorAll('.mode-panel').forEach((panel) => {
                const visible = panel.dataset.mode === mode;
                panel.classList.toggle('hidden', !visible);
                if (visible) {
                    panel.classList.remove('anim-next');
                    void panel.offsetWidth;
                    panel.classList.add('anim-next');
                }
            });
            document.querySelectorAll('.side-photo').forEach((img) => {
                const active = img.dataset.mode === mode;
                img.classList.toggle('opacity-100', active);
                img.classList.toggle('scale-100', active);
                img.classList.toggle('opacity-0', !active);
                img.classList.toggle('scale-110', !active);
            });

            if (mode === 'rfid') {
                resetRfid();
                reader.focus();
            }
        };

        document.querySelectorAll('.mode-tab, [data-switch]').forEach((btn) => {
            btn.addEventListener('click', () => setMode(btn.dataset.mode || btn.dataset.switch));
        });

        /* ---------- Login manual ---------- */
        const isEmail = (v) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
        const isPhone = (v) => /^08[0-9]{8,12}$/.test(v.replace(/[\s-]/g, ''));

        const checkIdentitas = () => {
            const el = form.identitas;
            el.setCustomValidity(el.value && !isEmail(el.value) && !isPhone(el.value)
                ? 'Tulis email (nama@email.com) atau nomor WhatsApp (08xxxxxxxxxx).' : '');
            return checkField(el);
        };

        form.addEventListener('input', (e) => {
            if (!e.target.closest('.field.is-invalid')) return;
            e.target === form.identitas ? checkIdentitas() : checkField(e.target);
        });

        form.password.addEventListener('keyup', (e) => {
            const caps = e.getModifierState?.('CapsLock');
            document.getElementById('caps-warning').classList.toggle('hidden', !caps);
            document.getElementById('caps-warning').classList.toggle('flex', !!caps);
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const ok = [checkIdentitas(), checkField(form.password)];
            if (ok.includes(false)) {
                form.querySelector('.field.is-invalid input')?.focus();
                return;
            }

            const btn = document.getElementById('btn-masuk');
            btn.disabled = true;
            document.getElementById('btn-masuk-spin').classList.remove('hidden');
            document.getElementById('btn-masuk-teks').textContent = 'Memeriksa akun…';

            // TODO: kirim ke route POST login setelah backend siap (form.submit() / fetch)
            setTimeout(() => {
                btn.disabled = false;
                document.getElementById('btn-masuk-spin').classList.add('hidden');
                document.getElementById('btn-masuk-teks').textContent = 'Masuk ke Akun TUNAKER';
                toast('Form valid. Backend login belum disambungkan.');
            }, 1200);
        });

        /* ---------- Login kartu RFID ---------- */
        const setRfidStatus = (state, text) => {
            const styles = {
                wait: ['text-amber-600', 'bg-amber-500 animate-pulse', 'border-slate-200 bg-surface'],
                ok: ['text-emerald-600', 'bg-emerald-500', 'border-emerald-500 bg-emerald-50'],
                error: ['text-red-600', 'bg-red-500', 'border-red-400 bg-red-50'],
            }[state];
            const status = document.getElementById('rfid-status');
            status.className = `mt-5 inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold shadow-sm ${styles[0]}`;
            status.firstElementChild.className = `h-2.5 w-2.5 rounded-full ${styles[1]}`;
            document.getElementById('rfid-status-text').textContent = text;
            rfidBox.className = `relative overflow-hidden rounded-2xl border-2 px-6 py-8 text-center transition-colors duration-300 ${state === 'wait' ? 'border-dashed' : ''} ${styles[2]}`;
            document.getElementById('rfid-icon').textContent = state === 'ok' ? '✅' : state === 'error' ? '⚠️' : '💳';
            rfidBox.querySelectorAll('.rfid-ring').forEach((r) => r.classList.toggle('hidden', state !== 'wait'));
            if (state === 'error') {
                rfidBox.classList.remove('shake');
                void rfidBox.offsetWidth;
                rfidBox.classList.add('shake');
            }
        };

        const resetRfid = () => setRfidStatus('wait', 'Menunggu kartu ditempelkan…');

        const loginKartu = (nomor) => {
            if (!/^[0-9]{6,16}$/.test(nomor)) {
                setRfidStatus('error', 'Kartu tidak dikenali. Coba tempelkan lagi.');
                setTimeout(resetRfid, 2500);
                return;
            }
            setRfidStatus('ok', `Kartu terbaca: •••• ${nomor.slice(-4)}`);
            // TODO: kirim nomor kartu ke route POST login-kartu setelah backend siap
            setTimeout(() => toast('Kartu terbaca. Backend login kartu belum disambungkan.', '💳'), 600);
            setTimeout(resetRfid, 3500);
        };

        reader.addEventListener('keydown', (e) => {
            if (e.key !== 'Enter') return;
            e.preventDefault();
            loginKartu(reader.value.trim());
            reader.value = '';
        });

        // Jaga fokus ke pembaca kartu selama mode RFID aktif
        rfidBox.addEventListener('click', () => reader.focus());
        reader.addEventListener('blur', () => {
            if (mode === 'rfid' && document.getElementById('form-kartu').classList.contains('hidden')) {
                setTimeout(() => { if (!document.activeElement || document.activeElement === document.body) reader.focus(); }, 100);
            }
        });

        const formKartu = document.getElementById('form-kartu');
        document.getElementById('btn-ketik-kartu').addEventListener('click', () => {
            formKartu.classList.toggle('hidden');
            if (!formKartu.classList.contains('hidden')) {
                formKartu.classList.add('pop-in');
                formKartu.nomor_kartu.focus();
            }
        });
        formKartu.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!checkField(formKartu.nomor_kartu)) return;
            loginKartu(formKartu.nomor_kartu.value);
            formKartu.reset();
        });
        formKartu.nomor_kartu.addEventListener('input', (e) => {
            if (e.target.closest('.field.is-invalid')) checkField(e.target);
        });

        /* ---------- Mulai ---------- */
        if (storage.get(MODE_KEY) === 'rfid') setMode('rfid');
    })();
</script>
</body>
</html>
