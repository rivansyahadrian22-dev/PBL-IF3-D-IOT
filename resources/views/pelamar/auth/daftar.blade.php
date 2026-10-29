<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar | TUNAKER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-slate-600 antialiased">

@php
    $input = 'w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $chip = 'chip inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium transition hover:border-teal-500 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15';

    $langkah = [
        ['nama' => 'Akun', 'judul' => 'Daftar Akun Baru', 'sub' => 'Buat akun untuk mulai mencari lowongan yang ramah Tuli.'],
        ['nama' => 'Biodata', 'judul' => 'Lengkapi Biodata Diri', 'sub' => 'Data ini membantu perusahaan memahami kebutuhan komunikasimu.'],
        ['nama' => 'Keahlian', 'judul' => 'Keterampilan & Minat', 'sub' => 'Pilih keahlian dan bidang kerja supaya rekomendasi lowongan lebih sesuai.'],
        ['nama' => 'Dokumen', 'judul' => 'Unggah Dokumen', 'sub' => 'Lengkapi CV dan dokumen pendukung untuk melamar pekerjaan.'],
    ];

    // 'video' diisi URL video panduan BISINDO (mp4) untuk tiap langkah
    $panelKiri = [
        ['foto' => '1787647562374-97652f245581', 'video' => null, 'durasi' => '0:45', 'judul' => 'Mulai Cari Kerja dari Sini',
         'teks' => 'Buat akun, isi profil, lalu lihat lowongan dari perusahaan yang ramah Tuli.',
         'icon' => 'M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.13a3.38 3.38 0 1 1-6.75 0 3.38 3.38 0 0 1 6.75 0ZM3 19.24v-.12a6.38 6.38 0 0 1 12.75 0v.12A12.3 12.3 0 0 1 9.37 21c-2.33 0-4.5-.64-6.37-1.76Z'],
        ['foto' => '1789654246425-3c06dc5e2b4c', 'video' => null, 'durasi' => '1:10', 'judul' => 'Ceritakan Cara Berkomunikasimu',
         'teks' => 'Informasi ini kami sampaikan ke perusahaan supaya proses seleksi bisa disesuaikan.',
         'icon' => 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.12 2.99 2.7 3.22 1.09.16 2.19.28 3.3.37V21l4.18-4.18a1.14 1.14 0 0 1 .78-.33 48.4 48.4 0 0 0 5.83-.5c1.58-.23 2.7-1.62 2.7-3.23V6.74c0-1.6-1.12-2.99-2.7-3.22A48.4 48.4 0 0 0 12 3c-2.39 0-4.73.17-7.02.52-1.58.23-2.7 1.62-2.7 3.22v6.02Z'],
        ['foto' => '1758599543122-fc551c9b4b1c', 'video' => null, 'durasi' => '0:55', 'judul' => 'Pilih Keahlian dan Bidang Kerja',
         'teks' => 'Dari pilihan ini, sistem mencocokkan keahlianmu dengan lowongan yang tersedia.',
         'icon' => 'M9.8 15.9 9 18.75l-.8-2.85a4.5 4.5 0 0 0-3.1-3.1L2.25 12l2.85-.8a4.5 4.5 0 0 0 3.1-3.1L9 5.25l.8 2.85a4.5 4.5 0 0 0 3.1 3.1l2.85.8-2.85.8a4.5 4.5 0 0 0-3.1 3.1Z'],
        ['foto' => '1522071820081-009f0129c71c', 'video' => null, 'durasi' => '0:40', 'judul' => 'Tinggal Unggah Dokumen',
         'teks' => 'Unggah CV dan dokumen pendukung. Kalau belum siap, bisa dilengkapi nanti dari halaman profil.',
         'icon' => 'M19.5 14.25v-2.63a3.38 3.38 0 0 0-3.38-3.37h-1.5A1.13 1.13 0 0 1 13.5 7.13v-1.5a3.38 3.38 0 0 0-3.38-3.38H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.63c-.62 0-1.13.5-1.13 1.13v17.25c0 .62.5 1.12 1.13 1.12h12.75c.62 0 1.12-.5 1.12-1.12V11.25a9 9 0 0 0-9-9Z'],
    ];

    // CONTOH — ganti dengan testimoni asli pengguna sebelum dipublikasikan
    $testimoni = ['nama' => 'Rina A.', 'peran' => 'UI Designer · Teman Tuli', 'foto' => '1787647562374-97652f245581',
                  'kutipan' => 'Wawancaranya pakai juru bahasa isyarat, jadi aku bisa menunjukkan kemampuanku dengan percaya diri.'];

    $keahlian = [
        'Desain Grafis' => '🎨', 'UI/UX Design' => '📱', 'Pemrograman' => '💻', 'Data Entry' => '⌨️',
        'Administrasi' => '🗂️', 'Akuntansi' => '🧮', 'Fotografi' => '📷', 'Video Editing' => '🎬',
        'Menjahit' => '🧵', 'Tata Boga' => '🍳', 'Barista' => '☕', 'Kerajinan Tangan' => '🏺',
        'Digital Marketing' => '📈', 'Customer Service (Chat)' => '💬', 'Microsoft Office' => '📊', 'Bahasa Inggris' => '🔤',
    ];

    $bidang = [
        ['Teknologi & IT', '💻', 'Developer, IT support, data'],
        ['Kreatif & Desain', '🎨', 'Desain, foto, video'],
        ['Administrasi & Kantor', '🗂️', 'Admin, input data, arsip'],
        ['Manufaktur & Produksi', '🏭', 'Operator, quality control'],
        ['Kuliner & Hospitality', '🍽️', 'Dapur, barista, hotel'],
        ['Retail & Penjualan', '🛍️', 'Toko, gudang, online shop'],
    ];

    $komunikasi = ['BISINDO' => '🤟', 'SIBI' => '✋', 'Tulisan / Chat' => '💬', 'Membaca Gerak Bibir' => '👄', 'Lisan' => '🗣️'];

    $akomodasi = ['Instruksi kerja tertulis' => '📝', 'Subtitle saat rapat' => '🔡', 'Alarm visual (lampu)' => '💡',
                  'Koordinasi lewat chat' => '📲', 'Rekan kerja paham isyarat dasar' => '🤝'];
@endphp

<div class="flex min-h-screen">
    {{-- ============ PANEL KIRI ============ --}}
    <aside class="sticky top-0 hidden h-screen w-[42%] max-w-xl flex-col overflow-hidden bg-navy-950 p-10 text-white lg:flex">
        @foreach ($panelKiri as $i => $panel)
            <img src="https://images.unsplash.com/photo-{{ $panel['foto'] }}?auto=format&fit=crop&w=1200&q=80" alt=""
                 class="side-photo absolute inset-0 h-full w-full object-cover transition-all duration-1000 ease-out {{ $i === 0 ? 'scale-100 opacity-100' : 'scale-110 opacity-0' }}"
                 aria-hidden="true">
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

        {{-- Testimoni (hanya tampil di layar yang cukup tinggi) --}}
        <figure class="relative mt-8 hidden max-w-sm rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md [@media(min-height:820px)]:block">
            <blockquote class="text-sm leading-relaxed text-slate-100">“{{ $testimoni['kutipan'] }}”</blockquote>
            <figcaption class="mt-3 flex items-center gap-3">
                <img src="https://images.unsplash.com/photo-{{ $testimoni['foto'] }}?auto=format&fit=crop&w=80&h=80&q=80" alt="" class="h-9 w-9 rounded-full object-cover ring-2 ring-teal-500">
                <div>
                    <p class="text-sm font-bold">{{ $testimoni['nama'] }}</p>
                    <p class="text-xs text-slate-300">{{ $testimoni['peran'] }}</p>
                </div>
            </figcaption>
        </figure>

        @foreach ($panelKiri as $i => $panel)
            <div class="step-panel relative mt-auto {{ $i > 0 ? 'hidden' : '' }}" data-step="{{ $i }}">
                <span class="inline-flex items-center gap-2 rounded-full bg-teal-500/20 px-3 py-1 text-xs font-bold uppercase tracking-wider text-teal-100 ring-1 ring-teal-500/40 backdrop-blur">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $panel['icon'] }}"/></svg>
                    Langkah {{ $i + 1 }}
                </span>
                <h2 class="mt-4 text-3xl font-extrabold leading-tight drop-shadow xl:text-4xl">{{ $panel['judul'] }}</h2>
                <p class="mt-3 leading-relaxed text-slate-200">{{ $panel['teks'] }}</p>

                {{-- Panduan video BISINDO --}}
                <button type="button" class="video-btn group mt-6 flex w-full items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-3 text-left backdrop-blur-md transition hover:bg-white/15"
                        data-video="{{ $panel['video'] }}" data-judul="{{ $panel['judul'] }}">
                    <span class="relative grid h-16 w-24 shrink-0 place-items-center overflow-hidden rounded-xl bg-navy-800">
                        <img src="https://images.unsplash.com/photo-{{ $panel['foto'] }}?auto=format&fit=crop&w=200&q=60" alt="" class="absolute inset-0 h-full w-full object-cover opacity-60">
                        <span class="relative grid h-9 w-9 place-items-center rounded-full bg-teal-500 shadow-lg transition group-hover:scale-110">
                            <svg class="ml-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5.14v13.72a1 1 0 0 0 1.52.85l10.79-6.86a1 1 0 0 0 0-1.7L9.52 4.29A1 1 0 0 0 8 5.14Z"/></svg>
                        </span>
                        <span class="absolute bottom-1 right-1 rounded bg-black/60 px-1 text-[10px] font-semibold">{{ $panel['durasi'] }}</span>
                    </span>
                    <span>
                        <span class="block text-sm font-bold">Tonton Panduan BISINDO</span>
                        <span class="mt-0.5 block text-xs text-slate-300">Penjelasan langkah ini dalam bahasa isyarat, dengan teks.</span>
                    </span>
                </button>
            </div>
        @endforeach

        <div class="relative mt-8">
            <div class="flex gap-2">
                @foreach ($langkah as $i => $l)
                    <span class="side-bar h-1.5 flex-1 rounded-full transition-colors duration-500 {{ $i === 0 ? 'bg-teal-500' : 'bg-white/15' }}"></span>
                @endforeach
            </div>
            <p class="mt-4 text-xs text-slate-400">&copy; {{ date('Y') }} TUNAKER · Sistem Layanan Pencari Kerja untuk Penyandang Tunarungu</p>
        </div>
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
            <p class="text-sm">Sudah punya akun? <a href="{{ route('masuk') }}" class="font-semibold text-teal-600 hover:underline">Masuk</a></p>
        </header>

        <div class="flex flex-1 justify-center px-6 pb-12 sm:px-10">
            <div class="w-full max-w-2xl">
                {{-- Stepper --}}
                <ol class="mb-8 flex items-center">
                    @foreach ($langkah as $i => $l)
                        <li class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
                            <div class="stepper-item flex flex-col items-center gap-2" data-step="{{ $i }}">
                                <span class="stepper-circle grid h-10 w-10 place-items-center rounded-full border-2 text-sm font-bold transition
                                             {{ $i === 0 ? 'border-navy-900 bg-navy-900 text-white' : 'border-slate-200 bg-white text-slate-400' }}">
                                    <span class="stepper-num">{{ $i + 1 }}</span>
                                    <svg class="stepper-check hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                </span>
                                <span class="stepper-label text-xs font-semibold {{ $i === 0 ? 'text-navy-900' : 'text-slate-400' }}">{{ $l['nama'] }}</span>
                            </div>
                            @unless ($loop->last)
                                <span class="mx-2 mb-6 h-1 flex-1 overflow-hidden rounded-full bg-slate-200">
                                    <span class="stepper-line block h-full w-0 rounded-full bg-teal-500 transition-all duration-500"></span>
                                </span>
                            @endunless
                        </li>
                    @endforeach
                </ol>

                <form id="form-daftar" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8" novalidate>
                    @csrf

                    @foreach ($langkah as $i => $l)
                        <div class="step-panel step-anim mb-6 {{ $i > 0 ? 'hidden' : '' }}" data-step="{{ $i }}">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-teal-600">Langkah {{ $i + 1 }} dari {{ count($langkah) }}</p>
                                    <h1 class="mt-1 text-2xl font-extrabold text-navy-900">{{ $l['judul'] }}</h1>
                                    <p class="mt-1 text-sm">{{ $l['sub'] }}</p>
                                </div>
                                {{-- Di layar kecil panel kiri tersembunyi, jadi tombol video ditaruh di sini --}}
                                <button type="button" class="video-btn inline-flex shrink-0 items-center gap-1.5 rounded-full bg-navy-900 px-3 py-2 text-xs font-bold text-white lg:hidden"
                                        data-video="{{ $panelKiri[$i]['video'] }}" data-judul="{{ $panelKiri[$i]['judul'] }}">
                                    BISINDO
                                </button>
                            </div>
                        </div>
                    @endforeach

                    {{-- Ringkasan error --}}
                    <div id="form-alert" class="mb-6 hidden items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700" role="alert">
                        <span class="text-xl" aria-hidden="true">⚠️</span>
                        <span id="form-alert-text"></span>
                    </div>

                    {{-- ---------- LANGKAH 1: AKUN ---------- --}}
                    <fieldset class="step-panel step-anim space-y-5" data-step="0">
                        <div class="field">
                            <x-pelamar.daftar.label for="nama" hint="Tulis nama lengkap sesuai KTP. Contoh: Rina Ayu Lestari.">Nama Lengkap</x-pelamar.daftar.label>
                            <input id="nama" name="nama" type="text" required autocomplete="name" placeholder="Masukkan nama lengkap" class="{{ $input }}">
                        </div>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="field">
                                <x-pelamar.daftar.label for="email" hint="Alamat email untuk masuk akun dan menerima info lowongan. Contoh: rina@gmail.com">Email</x-pelamar.daftar.label>
                                <input id="email" name="email" type="email" required autocomplete="email" placeholder="nama@email.com" class="{{ $input }}">
                            </div>
                            <div class="field">
                                <x-pelamar.daftar.label for="whatsapp" hint="Nomor HP yang punya WhatsApp. Kami kirim info lewat pesan teks, bukan telepon.">No. WhatsApp</x-pelamar.daftar.label>
                                <input id="whatsapp" name="whatsapp" type="tel" required inputmode="numeric" pattern="08[0-9]{8,12}" autocomplete="tel"
                                       data-pattern-msg="Nomor diawali 08 dan berisi 10–14 angka." placeholder="08xxxxxxxxxx" class="{{ $input }}">
                            </div>
                        </div>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="field">
                                <x-pelamar.daftar.label for="password" hint="Kata rahasia untuk masuk akun. Minimal 8 karakter. Jangan beri tahu orang lain.">Kata Sandi</x-pelamar.daftar.label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" placeholder="Minimal 8 karakter" class="{{ $input }} pr-11">
                                    <button type="button" class="toggle-password absolute inset-y-0 right-0 grid w-11 place-items-center text-slate-400 hover:text-navy-900" aria-label="Tampilkan kata sandi">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.04 12.32a1 1 0 0 1 0-.64C3.42 7.51 7.36 4.5 12 4.5c4.64 0 8.57 3 9.96 7.18.07.2.07.43 0 .64C20.58 16.49 16.64 19.5 12 19.5c-4.64 0-8.57-3-9.96-7.18Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="field">
                                <x-pelamar.daftar.label for="password_confirmation" hint="Ketik ulang kata sandi yang sama persis.">Konfirmasi Kata Sandi</x-pelamar.daftar.label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Ulangi kata sandi" class="{{ $input }}">
                                <p id="pw-match" class="mt-1.5 hidden items-center gap-1 text-xs font-semibold"></p>
                            </div>
                        </div>

                        {{-- Kekuatan kata sandi --}}
                        <div class="rounded-xl bg-surface p-4">
                            <div class="flex items-center justify-between text-xs font-semibold">
                                <span class="text-navy-900">Kekuatan kata sandi</span>
                                <span id="pw-label" class="text-slate-400">Belum diisi</span>
                            </div>
                            <div class="mt-2 grid grid-cols-4 gap-1.5">
                                @for ($s = 0; $s < 4; $s++)
                                    <span class="pw-bar h-1.5 rounded-full bg-slate-200 transition-colors duration-300"></span>
                                @endfor
                            </div>
                            <ul class="mt-3 grid gap-1.5 text-xs sm:grid-cols-2">
                                @foreach (['len' => 'Minimal 8 karakter', 'case' => 'Huruf besar & kecil', 'num' => 'Mengandung angka', 'sym' => 'Mengandung simbol (!@#)'] as $key => $teks)
                                    <li class="pw-rule flex items-center gap-2 text-slate-400 transition" data-rule="{{ $key }}">
                                        <span class="pw-dot grid h-4 w-4 place-items-center rounded-full border-2 border-current text-[9px] font-black"></span>
                                        {{ $teks }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="flex gap-3 rounded-xl bg-teal-50 p-4 ring-1 ring-teal-100">
                            <span class="text-xl" aria-hidden="true">📩</span>
                            <p class="text-sm text-navy-900">Semua notifikasi dikirim lewat <b>email & WhatsApp (teks)</b>, bukan panggilan suara.</p>
                        </div>
                    </fieldset>

                    {{-- ---------- LANGKAH 2: BIODATA ---------- --}}
                    <fieldset class="step-panel step-anim hidden space-y-5" data-step="1">
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="field">
                                <x-pelamar.daftar.label for="tanggal_lahir" hint="Pilih tanggal, bulan, dan tahun kamu lahir.">Tanggal Lahir</x-pelamar.daftar.label>
                                <input id="tanggal_lahir" name="tanggal_lahir" type="date" required class="{{ $input }}">
                            </div>
                            <div class="field">
                                <x-pelamar.daftar.label>Jenis Kelamin</x-pelamar.daftar.label>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach (['Laki-laki' => '👨', 'Perempuan' => '👩'] as $jk => $emoji)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="jenis_kelamin" value="{{ $jk }}" required class="peer sr-only">
                                            <span class="chip flex items-center justify-center gap-2 rounded-lg border border-slate-200 py-2.5 text-sm font-medium transition peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-600 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15">
                                                <span aria-hidden="true">{{ $emoji }}</span> {{ $jk }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="field">
                                <x-pelamar.daftar.label for="kota" hint="Kota tempat kamu tinggal sekarang. Dipakai untuk mencari lowongan terdekat.">Kota / Kabupaten</x-pelamar.daftar.label>
                                <input id="kota" name="kota" type="text" required placeholder="Contoh: Bandung" class="{{ $input }}">
                            </div>
                            <div class="field">
                                <x-pelamar.daftar.label for="pendidikan" hint="Sekolah terakhir yang sudah kamu selesaikan (lulus).">Pendidikan Terakhir</x-pelamar.daftar.label>
                                <select id="pendidikan" name="pendidikan" required class="{{ $input }}">
                                    <option value="">Pilih pendidikan</option>
                                    @foreach (['SD', 'SMP', 'SMA / SMK / SLB', 'D3', 'S1', 'S2'] as $p)
                                        <option>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <x-pelamar.daftar.label for="alamat" optional>Alamat Lengkap</x-pelamar.daftar.label>
                            <textarea id="alamat" name="alamat" rows="2" placeholder="Nama jalan, RT/RW, kelurahan" class="{{ $input }}"></textarea>
                        </div>
                        <div class="field">
                            <x-pelamar.daftar.label for="kondisi" hint="Tuli: tidak bisa mendengar. Hard of Hearing: masih bisa mendengar sedikit.">Kondisi Pendengaran</x-pelamar.daftar.label>
                            <select id="kondisi" name="kondisi_pendengaran" required class="{{ $input }}">
                                <option value="">Pilih kondisi</option>
                                <option>Tuli (Deaf)</option>
                                <option>Hard of Hearing (Kurang Dengar)</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div class="field">
                            <x-pelamar.daftar.label hint="Pilih cara berkomunikasi yang paling nyaman untukmu. Boleh lebih dari satu.">Preferensi Komunikasi</x-pelamar.daftar.label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($komunikasi as $k => $emoji)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="komunikasi[]" value="{{ $k }}" class="peer sr-only">
                                        <span class="{{ $chip }} peer-checked:border-teal-500 peer-checked:bg-teal-500 peer-checked:text-white"><span aria-hidden="true">{{ $emoji }}</span> {{ $k }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Akomodasi kerja --}}
                        <div class="rounded-2xl border border-navy-900/10 bg-gradient-to-br from-navy-900/[0.03] to-teal-50 p-5">
                            <div class="field">
                                <x-pelamar.daftar.label hint="Jika memilih Ya, perusahaan akan menyiapkan juru bahasa isyarat saat wawancara.">Butuh juru bahasa isyarat saat wawancara?</x-pelamar.daftar.label>
                                <div class="grid grid-cols-3 gap-3">
                                    @foreach (['Ya' => '🙋', 'Kadang' => '🤔', 'Tidak' => '👌'] as $opsi => $emoji)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="juru_bahasa" value="{{ $opsi }}" required class="peer sr-only">
                                            <span class="chip flex flex-col items-center gap-1 rounded-xl border border-slate-200 bg-white py-3 text-sm font-semibold text-navy-900 transition peer-checked:border-teal-500 peer-checked:bg-teal-500 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15">
                                                <span class="text-2xl" aria-hidden="true">{{ $emoji }}</span> {{ $opsi }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="field mt-5">
                                <x-pelamar.daftar.label optional>Dukungan lain di tempat kerja</x-pelamar.daftar.label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($akomodasi as $a => $emoji)
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="akomodasi[]" value="{{ $a }}" class="peer sr-only">
                                            <span class="{{ $chip }} peer-checked:border-navy-900 peer-checked:bg-navy-900 peer-checked:text-white"><span aria-hidden="true">{{ $emoji }}</span> {{ $a }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- ---------- LANGKAH 3: KEAHLIAN ---------- --}}
                    <fieldset class="step-panel step-anim hidden space-y-6" data-step="2">
                        <div class="field">
                            <x-pelamar.daftar.label hint="Pilih hal-hal yang bisa kamu kerjakan dengan baik. Boleh pilih banyak.">Keterampilan</x-pelamar.daftar.label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($keahlian as $k => $emoji)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="keahlian[]" value="{{ $k }}" class="skill-check peer sr-only">
                                        <span class="{{ $chip }} peer-checked:border-navy-900 peer-checked:bg-navy-900 peer-checked:text-white"><span aria-hidden="true">{{ $emoji }}</span> {{ $k }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="mt-3 text-xs font-semibold text-slate-500"><span id="skill-count">0</span> keterampilan dipilih <span id="skill-cheer" class="text-teal-600"></span></p>
                            <input name="keahlian_lain" type="text" placeholder="+ Tambahkan keterampilan lain (pisahkan dengan koma)" class="{{ $input }} mt-3">
                        </div>
                        <div class="field">
                            <x-pelamar.daftar.label hint="Jenis pekerjaan yang ingin kamu coba.">Bidang Pekerjaan yang Diminati</x-pelamar.daftar.label>
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach ($bidang as [$nama, $emoji, $ket])
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="bidang[]" value="{{ $nama }}" class="peer sr-only">
                                        <span class="chip flex items-center gap-3 rounded-xl border border-slate-200 p-3.5 transition hover:border-teal-500 peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:shadow-md peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15">
                                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-surface text-2xl" aria-hidden="true">{{ $emoji }}</span>
                                            <span class="min-w-0 flex-1">
                                                <span class="block text-sm font-bold text-navy-900">{{ $nama }}</span>
                                                <span class="block text-xs text-slate-500">{{ $ket }}</span>
                                            </span>
                                            <span class="grid h-5 w-5 shrink-0 place-items-center rounded-md border-2 border-current text-teal-600">
                                                <svg class="check-icon h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                            </span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="field">
                                <x-pelamar.daftar.label for="pengalaman">Pengalaman Kerja</x-pelamar.daftar.label>
                                <select id="pengalaman" name="pengalaman" class="{{ $input }}">
                                    <option>Belum ada pengalaman</option>
                                    <option>Kurang dari 1 tahun</option>
                                    <option>1 – 3 tahun</option>
                                    <option>Lebih dari 3 tahun</option>
                                </select>
                            </div>
                            <div class="field">
                                <x-pelamar.daftar.label for="tipe_kerja">Tipe Kerja</x-pelamar.daftar.label>
                                <select id="tipe_kerja" name="tipe_kerja" class="{{ $input }}">
                                    <option>Semua tipe</option>
                                    <option>Full Time</option>
                                    <option>Part Time</option>
                                    <option>Remote</option>
                                    <option>Magang</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    {{-- ---------- LANGKAH 4: DOKUMEN ---------- --}}
                    <fieldset class="step-panel step-anim hidden space-y-5" data-step="3">
                        @foreach ([
                            ['name' => 'cv', 'judul' => 'Curriculum Vitae (CV)', 'ket' => 'PDF, maks. 2 MB', 'accept' => '.pdf', 'emoji' => '📄', 'opsional' => false,
                             'hint' => 'CV adalah daftar riwayat sekolah, pengalaman kerja, dan keahlianmu.'],
                            ['name' => 'foto', 'judul' => 'Foto Profil', 'ket' => 'JPG / PNG, maks. 1 MB', 'accept' => 'image/*', 'emoji' => '🖼️', 'opsional' => false,
                             'hint' => 'Foto wajah yang jelas dan rapi, seperti pas foto.'],
                            ['name' => 'sertifikat', 'judul' => 'Sertifikat / Portofolio', 'ket' => 'PDF / JPG, maks. 5 MB', 'accept' => '.pdf,image/*', 'emoji' => '🏅', 'opsional' => true,
                             'hint' => 'Bukti pelatihan atau contoh hasil karyamu. Boleh dilewati.'],
                        ] as $doc)
                            <div class="field">
                                <x-pelamar.daftar.label :hint="$doc['hint']" :optional="$doc['opsional']">{{ $doc['judul'] }}</x-pelamar.daftar.label>
                                <label class="dropzone flex cursor-pointer items-center gap-4 rounded-xl border-2 border-dashed border-slate-200 p-4 transition hover:border-teal-500 hover:bg-teal-50/50">
                                    <span class="dropzone-icon grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-teal-50 text-2xl" aria-hidden="true">{{ $doc['emoji'] }}</span>
                                    <span class="min-w-0 flex-1">
                                        <span class="dropzone-name block truncate text-sm font-semibold text-navy-900">Klik atau seret file ke sini</span>
                                        <span class="dropzone-ket block text-xs text-slate-400">{{ $doc['ket'] }}</span>
                                    </span>
                                    <span class="dropzone-ok hidden h-8 w-8 shrink-0 place-items-center rounded-full bg-teal-500 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                    </span>
                                    <input type="file" name="{{ $doc['name'] }}" accept="{{ $doc['accept'] }}" class="sr-only">
                                </label>
                            </div>
                        @endforeach

                        <div class="field">
                            <label class="chip flex cursor-pointer items-start gap-3 rounded-xl border border-transparent bg-surface p-4">
                                <input type="checkbox" name="setuju" required data-required-msg="Centang persetujuan ini untuk menyelesaikan pendaftaran." class="mt-0.5 h-4 w-4 rounded border-slate-300 accent-teal-600">
                                <span class="text-sm">Saya menyetujui <a href="#" class="font-semibold text-teal-600 hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="font-semibold text-teal-600 hover:underline">Kebijakan Privasi</a> TUNAKER.</span>
                            </label>
                        </div>
                    </fieldset>

                    {{-- Navigasi --}}
                    <div class="mt-8 flex items-center justify-between gap-3 border-t border-slate-100 pt-6">
                        <button type="button" id="btn-kembali" class="invisible inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
                            Kembali
                        </button>
                        <span id="autosave" class="hidden items-center gap-1.5 text-xs font-medium text-slate-400 opacity-0 transition-opacity duration-500 sm:inline-flex">
                            <svg class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            <span id="autosave-text">Tersimpan otomatis</span>
                        </span>
                        <button type="submit" id="btn-lanjut" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:-translate-y-0.5 hover:bg-navy-800">
                            <span id="btn-lanjut-teks">Lanjut</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@include('shared.a11y')
@include('shared.video-modal')

{{-- ============ MODAL BERHASIL ============ --}}
<div id="success-modal" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm">
    <div class="pop-in w-full max-w-md rounded-3xl bg-white p-8 text-center shadow-2xl">
        <div class="mx-auto grid h-20 w-20 place-items-center rounded-full bg-teal-50 ring-8 ring-teal-50/50">
            <svg class="draw-check h-10 w-10 text-teal-500" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
        </div>
        
        <h2 class="mt-5 text-2xl font-extrabold text-navy-900">Akunmu sudah jadi, <span id="success-nama">Teman</span></h2>
        <p class="mt-2 text-sm leading-relaxed">Kami akan mengirim lowongan yang cocok lewat email dan WhatsApp (teks).</p>
        <div class="mt-6 grid gap-2">
            <a href="{{ route('home') }}#lowongan" class="rounded-lg bg-navy-900 py-3 text-sm font-semibold text-white transition hover:bg-navy-800">Lihat Lowongan</a>
            <a href="{{ route('home') }}" class="rounded-lg py-3 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Ke Beranda</a>
        </div>
    </div>
</div>

<canvas id="confetti" class="pointer-events-none fixed inset-0 z-[60] h-full w-full"></canvas>

<style>
    .check-icon { opacity: 0; transition: opacity .15s; }
    input:checked + span .check-icon { opacity: 1; }
</style>

{{-- type="module" agar dijalankan setelah app.js (window.TunakerUI) --}}
<script type="module">
    (() => {
        const { storage, openModal, checkField: baseCheck } = window.TunakerUI;
        const form = document.getElementById('form-daftar');
        const total = document.querySelectorAll('.stepper-item').length;
        const btnKembali = document.getElementById('btn-kembali');
        const btnLanjutTeks = document.getElementById('btn-lanjut-teks');
        const alertBox = document.getElementById('form-alert');
        const DRAFT_KEY = 'tunaker_daftar_draf';
        let step = 0;

        /* ---------- Navigasi langkah ---------- */
        const render = (direction = 'next') => {
            document.querySelectorAll('.step-panel').forEach((el) => {
                const visible = Number(el.dataset.step) === step;
                el.classList.toggle('hidden', !visible);
                if (visible && el.classList.contains('step-anim')) {
                    el.classList.remove('anim-next', 'anim-prev');
                    void el.offsetWidth;
                    el.classList.add(direction === 'next' ? 'anim-next' : 'anim-prev');
                }
            });

            document.querySelectorAll('.side-photo').forEach((img, i) => {
                img.classList.toggle('opacity-100', i === step);
                img.classList.toggle('scale-100', i === step);
                img.classList.toggle('opacity-0', i !== step);
                img.classList.toggle('scale-110', i !== step);
            });

            document.querySelectorAll('.side-bar').forEach((el, i) => {
                el.classList.toggle('bg-teal-500', i <= step);
                el.classList.toggle('bg-white/15', i > step);
            });

            document.querySelectorAll('.stepper-item').forEach((item, i) => {
                const done = i < step;
                const active = i === step;
                item.querySelector('.stepper-circle').className = 'stepper-circle grid h-10 w-10 place-items-center rounded-full border-2 text-sm font-bold transition ' +
                    (done ? 'border-teal-500 bg-teal-500 text-white'
                        : active ? 'border-navy-900 bg-navy-900 text-white ring-4 ring-navy-900/10'
                        : 'border-slate-200 bg-white text-slate-400');
                item.querySelector('.stepper-label').className = 'stepper-label text-xs font-semibold ' + (done ? 'text-teal-600' : active ? 'text-navy-900' : 'text-slate-400');
                item.querySelector('.stepper-num').classList.toggle('hidden', done);
                item.querySelector('.stepper-check').classList.toggle('hidden', !done);
            });

            document.querySelectorAll('.stepper-line').forEach((line, i) => {
                line.style.width = i < step ? '100%' : '0';
            });

            alertBox.classList.add('hidden');
            alertBox.classList.remove('flex');
            btnKembali.classList.toggle('invisible', step === 0);
            btnLanjutTeks.textContent = step === total - 1 ? 'Daftar Sekarang' : 'Lanjut';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        /* ---------- Validasi dengan pesan jelas ---------- */
        const checkField = (el) => {
            if (el.id === 'password_confirmation') {
                el.setCustomValidity(el.value && el.value !== form.password.value ? 'Kata sandi belum sama. Coba ketik ulang.' : '');
            }
            return baseCheck(el);
        };

        const validStep = () => {
            const seen = new Set();
            const invalid = [];
            form.querySelectorAll(`fieldset[data-step="${step}"] [required]`).forEach((el) => {
                if (el.type === 'radio') {
                    if (seen.has(el.name)) return;
                    seen.add(el.name);
                }
                if (!checkField(el)) invalid.push(el);
            });
            if (step === 0 && !checkField(form.password_confirmation)) invalid.push(form.password_confirmation);

            if (invalid.length) {
                document.getElementById('form-alert-text').textContent =
                    `Ada ${invalid.length} kolom yang perlu diperbaiki. Lihat tanda merah di bawah.`;
                alertBox.classList.remove('hidden');
                alertBox.classList.add('flex');
                invalid[0].closest('.field').scrollIntoView({ behavior: 'smooth', block: 'center' });
                if (invalid[0].type !== 'radio' && invalid[0].type !== 'checkbox') invalid[0].focus({ preventScroll: true });
                return false;
            }
            return true;
        };

        // Hilangkan error begitu pengguna memperbaikinya
        form.addEventListener('input', (e) => {
            if (e.target.closest('.field.is-invalid')) checkField(e.target);
        });
        form.addEventListener('change', (e) => {
            if (e.target.closest('.field.is-invalid')) checkField(e.target);
        });
        form.addEventListener('focusout', (e) => {
            if (e.target.matches('input[required]:not([type=radio]):not([type=checkbox]), select[required]') && e.target.value) checkField(e.target);
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!validStep()) return;

            if (step < total - 1) {
                step++;
                render('next');
                return;
            }

            // TODO: kirim ke route POST pendaftaran (form.submit() / fetch) setelah backend siap.
            // Modal berhasil di bawah ini sementara hanya tampilan.
            storage.remove(DRAFT_KEY);
            document.getElementById('success-nama').textContent = form.nama.value.split(' ')[0] || 'Teman';
            openModal('success-modal');
            confetti();
        });

        btnKembali.addEventListener('click', () => {
            step = Math.max(0, step - 1);
            render('prev');
        });

        /* ---------- Kekuatan kata sandi ---------- */
        const strengthLevels = [
            ['Belum diisi', 'text-slate-400', 'bg-slate-200'],
            ['Lemah', 'text-red-500', 'bg-red-500'],
            ['Sedang', 'text-orange-500', 'bg-orange-500'],
            ['Kuat', 'text-amber-500', 'bg-amber-500'],
            ['Sangat kuat', 'text-emerald-600', 'bg-emerald-500'],
        ];

        const updatePassword = () => {
            const pw = form.password.value;
            const rules = {
                len: pw.length >= 8,
                case: /[a-z]/.test(pw) && /[A-Z]/.test(pw),
                num: /\d/.test(pw),
                sym: /[^A-Za-z0-9]/.test(pw),
            };
            const score = pw ? Math.max(1, Object.values(rules).filter(Boolean).length) : 0;
            const [teks, warnaTeks, warnaBar] = strengthLevels[score];

            const label = document.getElementById('pw-label');
            label.textContent = teks;
            label.className = warnaTeks;
            document.querySelectorAll('.pw-bar').forEach((bar, i) => {
                bar.className = 'pw-bar h-1.5 rounded-full transition-colors duration-300 ' + (i < score ? warnaBar : 'bg-slate-200');
            });
            document.querySelectorAll('.pw-rule').forEach((li) => {
                const ok = rules[li.dataset.rule];
                li.classList.toggle('text-emerald-600', ok);
                li.classList.toggle('text-slate-400', !ok);
                li.querySelector('.pw-dot').textContent = ok ? '✓' : '';
            });

            const match = document.getElementById('pw-match');
            const confirm = form.password_confirmation.value;
            match.classList.toggle('hidden', !confirm);
            match.classList.toggle('flex', !!confirm);
            if (confirm) {
                const same = confirm === pw;
                match.className = 'mt-1.5 flex items-center gap-1 text-xs font-semibold ' + (same ? 'text-emerald-600' : 'text-orange-500');
                match.textContent = same ? '✓ Kata sandi cocok' : '… Belum sama dengan kata sandi';
            }
        };
        form.password.addEventListener('input', updatePassword);
        form.password_confirmation.addEventListener('input', updatePassword);

        /* ---------- Jumlah keterampilan ---------- */
        const updateSkills = () => {
            const n = form.querySelectorAll('.skill-check:checked').length;
            document.getElementById('skill-count').textContent = n;
            document.getElementById('skill-cheer').textContent =
                n >= 5 ? '· Sudah cukup lengkap' : '';
        };
        form.addEventListener('change', (e) => { if (e.target.matches('.skill-check')) updateSkills(); });

        /* ---------- Unggah file ---------- */
        document.querySelectorAll('.dropzone').forEach((zone) => {
            const input = zone.querySelector('input[type=file]');
            const update = () => {
                if (!input.files.length) return;
                const file = input.files[0];
                zone.querySelector('.dropzone-name').textContent = file.name;
                zone.querySelector('.dropzone-ket').textContent = `${(file.size / 1024 / 1024).toFixed(2)} MB · siap diunggah`;
                zone.querySelector('.dropzone-ok').classList.replace('hidden', 'grid');
                zone.classList.remove('border-dashed', 'border-slate-200');
                zone.classList.add('border-teal-500', 'bg-teal-50/50');
            };

            input.addEventListener('change', update);
            zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('border-teal-500', 'bg-teal-50/50'); });
            zone.addEventListener('dragleave', () => { if (!input.files.length) zone.classList.remove('border-teal-500', 'bg-teal-50/50'); });
            zone.addEventListener('drop', (e) => {
                e.preventDefault();
                input.files = e.dataTransfer.files;
                update();
            });
        });

        /* ---------- Simpan otomatis (tanpa kata sandi & file) ---------- */
        const skipSave = (el) => !el.name || el.type === 'password' || el.type === 'file' || el.name === '_token';

        const saveDraft = () => {
            const data = {};
            [...form.elements].forEach((el) => {
                if (skipSave(el)) return;
                if (el.type === 'checkbox' || el.type === 'radio') {
                    if (el.checked) (data[el.name] ??= []).push(el.value);
                } else if (el.value) {
                    data[el.name] = el.value;
                }
            });
            storage.set(DRAFT_KEY, data);

            const badge = document.getElementById('autosave');
            const jam = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('autosave-text').textContent = `Tersimpan otomatis · ${jam}`;
            badge.classList.add('opacity-100');
            clearTimeout(saveDraft.timer);
            saveDraft.timer = setTimeout(() => badge.classList.remove('opacity-100'), 2500);
        };

        const restoreDraft = () => {
            const data = storage.get(DRAFT_KEY);
            if (!data) return;
            [...form.elements].forEach((el) => {
                if (skipSave(el) || !(el.name in data)) return;
                if (el.type === 'checkbox' || el.type === 'radio') {
                    el.checked = data[el.name].includes(el.value);
                } else {
                    el.value = data[el.name];
                }
            });
        };

        let saveTimer;
        form.addEventListener('input', () => { clearTimeout(saveTimer); saveTimer = setTimeout(saveDraft, 600); });
        form.addEventListener('change', () => { clearTimeout(saveTimer); saveTimer = setTimeout(saveDraft, 300); });

        /* ---------- Konfeti ---------- */
        function confetti() {
            if (document.documentElement.classList.contains('no-motion') || matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            const canvas = document.getElementById('confetti');
            const ctx = canvas.getContext('2d');
            canvas.width = innerWidth;
            canvas.height = innerHeight;
            const colors = ['#14a3a6', '#0b2545', '#3b82f6', '#f59e0b', '#ec4899', '#22c55e'];
            const pieces = Array.from({ length: 160 }, () => ({
                x: canvas.width / 2, y: canvas.height / 2,
                vx: (Math.random() - .5) * 18, vy: Math.random() * -18 - 4,
                size: Math.random() * 8 + 4, rot: Math.random() * 360, vr: (Math.random() - .5) * 12,
                color: colors[Math.floor(Math.random() * colors.length)],
            }));
            const start = performance.now();
            const frame = (now) => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                pieces.forEach((p) => {
                    p.vy += .45; p.vx *= .99; p.x += p.vx; p.y += p.vy; p.rot += p.vr;
                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.rot * Math.PI / 180);
                    ctx.fillStyle = p.color;
                    ctx.fillRect(-p.size / 2, -p.size / 4, p.size, p.size / 2);
                    ctx.restore();
                });
                if (now - start < 3500) requestAnimationFrame(frame);
                else ctx.clearRect(0, 0, canvas.width, canvas.height);
            };
            requestAnimationFrame(frame);
        }

        /* ---------- Mulai ---------- */
        restoreDraft();
        updateSkills();
    })();
</script>
</body>
</html>
