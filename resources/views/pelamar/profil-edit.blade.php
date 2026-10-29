@extends('pelamar.layouts.app')

@section('title', 'Edit Profil')

@php
    // Data contoh ada di config/profil.php — ganti dengan auth()->user() & relasinya
    $p = config('profil.profil');
    $f = config('profil.form');
    $berkas = config('profil.berkas');
    $privasi = config('profil.privasi');

    $awal = [
        'pendidikan' => collect(config('profil.pendidikan'))->map(fn ($r) => ['judul' => $r[1], 'lembaga' => $r[2], 'periode' => $r[3], 'ket' => $r[4]])->all(),
        'keahlian' => collect(config('profil.keahlian'))->map(fn ($lv, $nama) => ['nama' => $nama, 'level' => $lv])->values()->all(),
        'bahasa' => collect(config('profil.bahasa'))->map(fn ($r) => ['nama' => $r[0], 'level' => $r[1]])->all(),
    ];

    $tingkatSkill = ['Pemula', 'Menengah', 'Mahir'];
    $tingkatBahasa = ['Dasar', 'Menengah', 'Mahir', 'Bahasa ibu'];

    $opsiKomunikasi = ['BISINDO' => '🤟', 'SIBI' => '✋', 'Tulisan / Chat' => '💬', 'Membaca Gerak Bibir' => '👄', 'Lisan' => '🗣️'];
    $opsiNotif = ['Visual (lampu/layar)' => '💡', 'Getar' => '📳', 'WhatsApp teks' => '📲', 'Email' => '📧'];
    $opsiAkomodasi = ['Instruksi kerja tertulis' => '📝', 'Subtitle saat rapat' => '🔡', 'Alarm visual (lampu)' => '💡', 'Koordinasi lewat chat' => '📲', 'Rekan kerja paham isyarat dasar' => '🤝'];
    $opsiRapat = ['Subtitle langsung / notulen tertulis', 'Chat saat rapat berlangsung', 'Juru bahasa isyarat', 'Tidak ada preferensi khusus'];

    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $kapital = 'mb-1.5 block text-sm font-semibold text-navy-900';
    $kecil = 'mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500';
    $kartu = 'scroll-mt-28 rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6';
    $chip = 'chip inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-slate-200 px-3.5 py-2 text-sm font-medium transition hover:border-teal-500 peer-checked:border-teal-500 peer-checked:bg-teal-500 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15';
    $hapus = 'grid h-9 w-9 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-500';
    $ikonHapus = '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>';

    $dokumen = [
        ['cv', '📄', 'Curriculum Vitae (CV)', $berkas[0], 2, '.pdf'],
        ['portofolio', '🎨', 'Portofolio', $berkas[1], 8, '.pdf,image/*'],
        ['kartu', '🪪', 'Kartu Penyandang Disabilitas', $berkas[2], 2, '.pdf,image/*'],
        ['sertifikat', '🏅', 'Sertifikat tambahan', $berkas[3], 5, '.pdf,image/*'],
    ];
@endphp

@section('content')
<div class="mx-auto max-w-7xl pb-24 lg:pb-0">
    {{-- ============ JUDUL ============ --}}
    <nav class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500" aria-label="Breadcrumb">
        <a href="{{ route('beranda') }}" class="hover:text-teal-600">Beranda</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('profil') }}" class="hover:text-teal-600">Profil Saya</a>
        <span aria-hidden="true">/</span>
        <span class="text-navy-900">Edit Profil</span>
    </nav>
    <div class="mt-2 flex flex-wrap items-end justify-between gap-4">
        <div class="max-w-2xl">
            <h1 class="text-2xl font-extrabold text-navy-900 sm:text-3xl">Edit Profil</h1>
            <p class="mt-1 text-sm leading-relaxed">Perbarui data pribadi, cara berkomunikasi, dan dokumenmu. Perusahaan hanya melihat profil ini saat kamu melamar.</p>
        </div>
        <div class="hidden gap-3 lg:flex">
            <a href="{{ route('profil') }}" class="batal inline-flex items-center rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">Batal</a>
            <button type="submit" form="form-profil" class="simpan inline-flex items-center gap-2 rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800 disabled:pointer-events-none disabled:opacity-70">💾 <span>Simpan Perubahan</span></button>
        </div>
    </div>

    <form id="form-profil" class="mt-6 grid gap-6 lg:grid-cols-[1fr_20rem]" data-tujuan="{{ route('profil') }}" novalidate enctype="multipart/form-data">
        @csrf
        <div class="min-w-0 space-y-6">

            {{-- ---------- 1. IDENTITAS ---------- --}}
            <section id="identitas" class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">1</span> Identitas Dasar</h2>

                <div class="mt-5 flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                    <span id="avatar" class="relative grid h-24 w-24 shrink-0 place-items-center overflow-hidden rounded-3xl bg-gradient-to-br from-teal-500 to-navy-700 text-3xl font-extrabold text-white shadow-lg">
                        <span id="avatar-inisial">{{ $p['inisial'] }}</span>
                        <img id="avatar-img" src="" alt="Foto profil baru" class="absolute inset-0 hidden h-full w-full object-cover">
                    </span>
                    <div>
                        <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-teal-500">
                            Ganti Foto
                            <input id="foto" type="file" name="foto" accept="image/*" data-maks="1" class="sr-only">
                        </label>
                        <p id="foto-info" class="mt-2 text-xs text-slate-500">JPG / PNG, maksimal 1 MB. Gunakan foto wajah yang jelas.</p>
                    </div>
                </div>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div class="grid gap-5 sm:col-span-2 sm:grid-cols-2">
                        <div class="field">
                            <x-pelamar.daftar.label for="nama" hint="Tulis nama lengkap sesuai KTP.">Nama Lengkap</x-pelamar.daftar.label>
                            <input id="nama" name="nama" type="text" required autocomplete="name" value="{{ $p['nama'] }}" class="{{ $input }}">
                        </div>
                        <div class="field">
                            <label for="headline" class="{{ $kapital }}">Jabatan / Headline</label>
                            <input id="headline" name="headline" type="text" value="{{ $p['peran'] }}" placeholder="Contoh: Junior Graphic Designer" class="{{ $input }}">
                        </div>
                    </div>
                    <div class="field">
                        <x-pelamar.daftar.label for="email" hint="Email untuk masuk akun dan menerima kabar lamaran.">Email</x-pelamar.daftar.label>
                        <input id="email" name="email" type="email" required autocomplete="email" value="{{ $f['email'] }}" class="{{ $input }}">
                    </div>
                    <div class="field">
                        <x-pelamar.daftar.label for="whatsapp" hint="Nomor HP yang punya WhatsApp. Kami kirim kabar lewat pesan teks, bukan telepon.">No. WhatsApp</x-pelamar.daftar.label>
                        <input id="whatsapp" name="whatsapp" type="tel" required inputmode="numeric" pattern="08[0-9]{8,12}" data-pattern-msg="Nomor diawali 08 dan berisi 10–14 angka." value="{{ $f['whatsapp'] }}" class="{{ $input }}">
                    </div>
                    <div class="field">
                        <label for="tanggal_lahir" class="{{ $kapital }}">Tanggal Lahir</label>
                        <input id="tanggal_lahir" name="tanggal_lahir" type="date" required value="{{ $f['tanggal_lahir'] }}" class="{{ $input }}">
                    </div>
                    <div class="field">
                        <span class="{{ $kapital }}">Jenis Kelamin</span>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach (['Laki-laki' => '👨', 'Perempuan' => '👩'] as $jk => $emoji)
                                <label>
                                    <input type="radio" name="jenis_kelamin" value="{{ $jk }}" required @checked($f['jenis_kelamin'] === $jk) class="peer sr-only">
                                    <span class="chip flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-200 py-2.5 text-sm font-medium transition hover:border-teal-500 peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-600 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15"><span aria-hidden="true">{{ $emoji }}</span> {{ $jk }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="field sm:col-span-2">
                        <x-pelamar.daftar.label for="kota" hint="Kota tempat kamu tinggal sekarang. Dipakai untuk mencari lowongan terdekat.">Kota / Kabupaten</x-pelamar.daftar.label>
                        <input id="kota" name="kota" type="text" required value="{{ $p['lokasi'] }}" class="{{ $input }}">
                    </div>
                    <div class="field sm:col-span-2">
                        <label for="tentang" class="mb-1.5 flex items-center justify-between text-sm font-semibold text-navy-900">
                            <span>Tentang Saya</span>
                            <span data-counter="tentang" class="text-xs font-medium text-slate-400">0/300</span>
                        </label>
                        <textarea id="tentang" name="tentang" rows="3" maxlength="300" placeholder="Ceritakan singkat keahlian dan cara kerjamu." class="{{ $input }}">{{ $f['tentang'] }}</textarea>
                    </div>
                    <label class="chip flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-surface p-4 sm:col-span-2">
                        <span>
                            <span class="block text-sm font-bold text-navy-900">● Siap bekerja</span>
                            <span class="block text-xs text-slate-500">Lencana ini terlihat oleh perusahaan mitra.</span>
                        </span>
                        <input type="checkbox" name="siap_bekerja" data-single @checked($f['siap_bekerja']) class="peer sr-only">
                        <span class="relative h-6 w-11 shrink-0 rounded-full bg-slate-300 transition after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:bg-teal-500 peer-checked:after:translate-x-5 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/20"></span>
                    </label>
                </div>
            </section>

            {{-- ---------- 2. KOMUNIKASI ---------- --}}
            <section id="komunikasi" class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">2</span> Kondisi & Komunikasi</h2>
                <p class="mt-1 text-sm">Membantu perusahaan menyiapkan dukungan yang tepat sebelum wawancara.</p>

                <div class="mt-5 space-y-5">
                    <div class="field">
                        <x-pelamar.daftar.label for="kondisi" hint="Tuli: tidak bisa mendengar. Hard of Hearing: masih bisa mendengar sedikit.">Kondisi Pendengaran</x-pelamar.daftar.label>
                        <select id="kondisi" name="kondisi" required class="{{ $input }}">
                            @foreach (['Tuli (Deaf)', 'Hard of Hearing (Kurang Dengar)', 'Lainnya'] as $opsi)
                                <option @selected($f['kondisi'] === $opsi)>{{ $opsi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <x-pelamar.daftar.label hint="Pilih cara berkomunikasi yang paling nyaman untukmu. Boleh lebih dari satu.">Preferensi Komunikasi</x-pelamar.daftar.label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($opsiKomunikasi as $nama => $emoji)
                                <label>
                                    <input type="checkbox" name="komunikasi" value="{{ $nama }}" @checked(in_array($nama, $f['komunikasi'])) class="peer sr-only">
                                    <span class="{{ $chip }}"><span aria-hidden="true">{{ $emoji }}</span> {{ $nama }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="field">
                            <label for="rapat" class="{{ $kapital }}">Saat rapat</label>
                            <select id="rapat" name="rapat" class="{{ $input }}">
                                @foreach ($opsiRapat as $opsi)
                                    <option @selected($f['rapat'] === $opsi)>{{ $opsi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <span class="{{ $kapital }}">Butuh juru bahasa saat wawancara?</span>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach (['Ya' => '🙋', 'Kadang' => '🤔', 'Tidak' => '👌'] as $opsi => $emoji)
                                    <label>
                                        <input type="radio" name="jbi" value="{{ $opsi }}" required @checked($f['jbi'] === $opsi) class="peer sr-only">
                                        <span class="chip flex cursor-pointer flex-col items-center gap-0.5 rounded-xl border border-slate-200 py-2 text-sm font-semibold text-navy-900 transition hover:border-teal-500 peer-checked:border-teal-500 peer-checked:bg-teal-500 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15"><span class="text-xl" aria-hidden="true">{{ $emoji }}</span> {{ $opsi }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <span class="{{ $kapital }}">Cara menerima notifikasi</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($opsiNotif as $nama => $emoji)
                                <label>
                                    <input type="checkbox" name="notifikasi" value="{{ $nama }}" @checked(in_array($nama, $f['notifikasi'])) class="peer sr-only">
                                    <span class="{{ $chip }} peer-checked:border-navy-900 peer-checked:bg-navy-900"><span aria-hidden="true">{{ $emoji }}</span> {{ $nama }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Tidak ada panggilan suara. Semua kabar dikirim sebagai teks atau tanda visual.</p>
                    </div>

                    <div class="field">
                        <span class="{{ $kapital }}">Dukungan lain di tempat kerja <span class="font-normal text-slate-400">(opsional)</span></span>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($opsiAkomodasi as $nama => $emoji)
                                <label>
                                    <input type="checkbox" name="akomodasi" value="{{ $nama }}" @checked(in_array($nama, $f['akomodasi'])) class="peer sr-only">
                                    <span class="{{ $chip }} peer-checked:border-navy-900 peer-checked:bg-navy-900"><span aria-hidden="true">{{ $emoji }}</span> {{ $nama }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="field">
                        <label for="catatan" class="mb-1.5 flex items-center justify-between text-sm font-semibold text-navy-900">
                            <span>Catatan akomodasi untuk perusahaan</span>
                            <span data-counter="catatan" class="text-xs font-medium text-slate-400">0/300</span>
                        </label>
                        <textarea id="catatan" name="catatan" rows="3" maxlength="300" placeholder="Contoh: Mohon instruksi kerja dikirim tertulis." class="{{ $input }}">{{ $f['catatan'] }}</textarea>
                    </div>
                </div>
            </section>

            {{-- ---------- 3. PENDIDIKAN ---------- --}}
            <section id="pendidikan" class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">3</span> Pendidikan & Pelatihan</h2>
                <div data-list="pendidikan" class="mt-5 space-y-3"></div>
                <button type="button" data-add="pendidikan" class="mt-4 inline-flex items-center gap-2 rounded-lg border border-dashed border-slate-300 px-4 py-2.5 text-sm font-semibold text-teal-600 transition hover:border-teal-500 hover:bg-teal-50">+ Tambah pendidikan / pelatihan</button>
                <template data-template="pendidikan">
                    <div class="baris relative rounded-2xl border border-slate-100 p-4">
                        <button type="button" data-remove class="{{ $hapus }} absolute right-2 top-2" aria-label="Hapus baris ini">{!! $ikonHapus !!}</button>
                        <div class="grid gap-3 pr-8 sm:grid-cols-2">
                            <label class="block sm:col-span-2"><span class="{{ $kecil }}">Nama pendidikan / pelatihan</span><input data-f="judul" type="text" placeholder="Contoh: Bootcamp Frontend Inklusif" class="{{ $input }}"></label>
                            <label class="block"><span class="{{ $kecil }}">Lembaga</span><input data-f="lembaga" type="text" placeholder="Nama sekolah / penyelenggara" class="{{ $input }}"></label>
                            <label class="block"><span class="{{ $kecil }}">Periode</span><input data-f="periode" type="text" placeholder="2024 atau 2020 – 2023" class="{{ $input }}"></label>
                            <label class="block sm:col-span-2"><span class="{{ $kecil }}">Keterangan</span><textarea data-f="ket" rows="2" placeholder="Apa yang kamu pelajari atau hasilkan?" class="{{ $input }}"></textarea></label>
                        </div>
                    </div>
                </template>
            </section>

            {{-- ---------- 4. KEAHLIAN ---------- --}}
            <section id="keahlian" class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">4</span> Keterampilan & Bahasa</h2>

                <p class="mt-5 {{ $kecil }}">Keahlian teknis</p>
                <div data-list="keahlian" class="space-y-2"></div>
                <button type="button" data-add="keahlian" class="mt-3 inline-flex items-center gap-2 rounded-lg border border-dashed border-slate-300 px-4 py-2.5 text-sm font-semibold text-teal-600 transition hover:border-teal-500 hover:bg-teal-50">+ Tambah keahlian</button>
                <template data-template="keahlian">
                    <div class="baris flex items-center gap-2">
                        <input data-f="nama" type="text" aria-label="Nama keahlian" placeholder="Nama keahlian" class="{{ $input }} flex-1">
                        <select data-f="level" aria-label="Tingkat keahlian" class="{{ $input }} w-32 shrink-0">
                            @foreach ($tingkatSkill as $lv)<option>{{ $lv }}</option>@endforeach
                        </select>
                        <button type="button" data-remove class="{{ $hapus }}" aria-label="Hapus keahlian">{!! $ikonHapus !!}</button>
                    </div>
                </template>

                <p class="mt-7 {{ $kecil }}">Bahasa & komunikasi</p>
                <div data-list="bahasa" class="space-y-2"></div>
                <button type="button" data-add="bahasa" class="mt-3 inline-flex items-center gap-2 rounded-lg border border-dashed border-slate-300 px-4 py-2.5 text-sm font-semibold text-teal-600 transition hover:border-teal-500 hover:bg-teal-50">+ Tambah bahasa</button>
                <template data-template="bahasa">
                    <div class="baris flex items-center gap-2">
                        <input data-f="nama" type="text" aria-label="Nama bahasa" placeholder="Contoh: Bahasa Inggris (tulis)" class="{{ $input }} flex-1">
                        <select data-f="level" aria-label="Tingkat bahasa" class="{{ $input }} w-36 shrink-0">
                            @foreach ($tingkatBahasa as $lv)<option>{{ $lv }}</option>@endforeach
                        </select>
                        <button type="button" data-remove class="{{ $hapus }}" aria-label="Hapus bahasa">{!! $ikonHapus !!}</button>
                    </div>
                </template>
            </section>

            {{-- ---------- 5. DOKUMEN ---------- --}}
            <section id="dokumen" class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">5</span> Dokumen</h2>
                <div class="mt-5 space-y-3">
                    @foreach ($dokumen as [$nama, $emoji, $judul, $ada, $maks, $accept])
                        <div class="rounded-2xl border {{ $ada[3] ? 'border-slate-100' : 'border-dashed border-amber-300 bg-amber-50/40' }} p-4" data-dokumen="{{ $nama }}" data-ada="{{ $ada[3] ? 1 : 0 }}">
                            <div class="flex items-center gap-3">
                                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-surface text-xl" aria-hidden="true">{{ $emoji }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-navy-900">{{ $judul }}</p>
                                    <p class="dok-status truncate text-xs {{ $ada[3] ? 'text-emerald-600' : 'text-amber-600' }}">{{ $ada[3] ? '✓ ' . $ada[1] . ' · ' . $ada[2] : '⚠ Belum diunggah' }}</p>
                                </div>
                                <label class="shrink-0 cursor-pointer rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-bold text-navy-900 transition hover:border-teal-500">
                                    {{ $ada[3] ? 'Ganti' : 'Unggah' }}
                                    <input type="file" name="{{ $nama }}" accept="{{ $accept }}" data-maks="{{ $maks }}" class="sr-only">
                                </label>
                            </div>
                            <p class="mt-2 text-[11px] text-slate-400">Maksimal {{ $maks }} MB.</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- ---------- 6. PRIVASI ---------- --}}
            <section id="privasi" class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">6</span> Privasi</h2>
                <div class="mt-3 divide-y divide-slate-100">
                    @foreach ($privasi as [$kunci, $judul, $ket, $aktif])
                        <label class="flex cursor-pointer items-center justify-between gap-4 py-3.5">
                            <span>
                                <span class="block text-sm font-semibold text-navy-900">{{ $judul }}</span>
                                <span class="block text-xs text-slate-500">{{ $ket }}</span>
                            </span>
                            <input type="checkbox" name="{{ $kunci }}" data-single data-privasi @checked($aktif) class="peer sr-only">
                            <span class="relative h-6 w-11 shrink-0 rounded-full bg-slate-300 transition after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:bg-teal-500 peer-checked:after:translate-x-5 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/20"></span>
                        </label>
                    @endforeach
                </div>
            </section>
        </div>

        {{-- ============ PANEL KANAN ============ --}}
        <aside class="space-y-4 lg:sticky lg:top-24 lg:self-start">
            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <span class="relative grid h-16 w-16 shrink-0 place-items-center">
                        <svg class="h-16 w-16 -rotate-90" viewBox="0 0 36 36"><circle cx="18" cy="18" r="15" fill="none" stroke="#eefafa" stroke-width="4"/><circle id="ring" cx="18" cy="18" r="15" fill="none" stroke="#14a3a6" stroke-width="4" stroke-linecap="round" stroke-dasharray="{{ round(94.2 * $p['kelengkapan'] / 100, 1) }} 94.2" style="transition: stroke-dasharray .5s"/></svg>
                        <span id="persen" class="absolute text-sm font-extrabold text-navy-900">{{ $p['kelengkapan'] }}%</span>
                    </span>
                    <div>
                        <p class="font-extrabold text-navy-900">Kelengkapan Profil</p>
                        <p id="persen-ket" class="text-xs text-slate-500">Masih ada yang bisa dilengkapi</p>
                    </div>
                </div>
                <ul id="checklist" class="mt-4 space-y-1.5 text-sm"></ul>
            </div>

            <div class="hidden rounded-3xl border border-slate-100 bg-white p-5 shadow-sm lg:block">
                <button type="submit" class="simpan flex w-full items-center justify-center gap-2 rounded-xl bg-navy-900 py-3.5 text-sm font-bold text-white shadow-lg shadow-navy-900/20 transition hover:bg-teal-600 disabled:pointer-events-none disabled:opacity-70">💾 <span>Simpan Perubahan</span></button>
                <a href="{{ route('profil') }}" class="batal mt-2 block rounded-xl py-3 text-center text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Batal</a>
                <p id="terakhir" class="mt-3 text-center text-[11px] text-slate-400">Belum ada perubahan yang disimpan.</p>
            </div>

            <div class="rounded-3xl border border-teal-100 bg-teal-50 p-5">
                <p class="text-2xl" aria-hidden="true">💡</p>
                <p class="mt-2 text-sm font-bold text-navy-900">Kenapa bagian komunikasi penting?</p>
                <p class="mt-1 text-sm leading-relaxed">Perusahaan memakainya untuk menyiapkan juru bahasa, subtitle, atau instruksi tertulis sebelum wawancara.</p>
            </div>
        </aside>
    </form>
</div>

{{-- Bilah simpan tetap di layar HP --}}
<div class="fixed inset-x-0 bottom-0 z-30 flex items-center gap-3 border-t border-slate-200 bg-white/95 px-4 py-3 shadow-[0_-8px_24px_rgb(11_37_69/0.08)] backdrop-blur lg:hidden">
    <a href="{{ route('profil') }}" class="batal rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-navy-900">Batal</a>
    <button type="submit" form="form-profil" class="simpan flex flex-1 items-center justify-center gap-2 rounded-xl bg-navy-900 py-3 text-sm font-bold text-white disabled:opacity-70">💾 <span>Simpan Perubahan</span></button>
</div>

<script type="application/json" id="data-awal">@json($awal)</script>

<style>
    /* Tombol "Aa" naik supaya tidak menutupi bilah simpan di HP */
    @media (max-width: 1023px) { #a11y-wrap { bottom: 5.25rem; } }
</style>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { storage, toast, checkField } = window.TunakerUI;
        const KEY = 'tunaker_profil_edit';
        const PRIVASI_KEY = 'tunaker_privasi';
        const $ = (id) => document.getElementById(id);
        const form = $('form-profil');
        const awal = JSON.parse($('data-awal').textContent);
        const tersimpan = storage.get(KEY);
        const DAFTAR = ['pendidikan', 'keahlian', 'bahasa'];
        let kotor = false;

        /* ---------- Daftar dinamis (tambah / hapus baris) ---------- */
        const wadah = (nama) => form.querySelector(`[data-list="${nama}"]`);
        const baris = (nama) => [...wadah(nama).querySelectorAll('.baris')];

        const tambahBaris = (nama, nilai = {}) => {
            const tpl = form.querySelector(`template[data-template="${nama}"]`);
            const node = tpl.content.firstElementChild.cloneNode(true);
            node.querySelectorAll('[data-f]').forEach((el) => { if (nilai[el.dataset.f] !== undefined) el.value = nilai[el.dataset.f]; });
            wadah(nama).appendChild(node);
            return node;
        };

        form.addEventListener('click', (e) => {
            const tambah = e.target.closest('[data-add]');
            if (tambah) {
                tambahBaris(tambah.dataset.add).querySelector('input, textarea').focus();
                tandaiKotor();
                return;
            }
            const hapus = e.target.closest('[data-remove]');
            if (hapus) {
                hapus.closest('.baris').remove();
                tandaiKotor();
            }
        });

        /* ---------- Simpan / pulihkan isian ---------- */
        const ambil = () => {
            const simple = {};
            [...form.elements].forEach((el) => {
                if (!el.name || el.type === 'file' || el.type === 'submit' || el.type === 'button' || el.name === '_token') return;
                if (el.type === 'checkbox') {
                    if (el.dataset.single !== undefined) simple[el.name] = el.checked;
                    else { (simple[el.name] ??= []); if (el.checked) simple[el.name].push(el.value); }
                } else if (el.type === 'radio') {
                    if (el.checked) simple[el.name] = el.value;
                } else {
                    simple[el.name] = el.value.trim();
                }
            });
            const lists = {};
            DAFTAR.forEach((n) => {
                lists[n] = baris(n)
                    .map((row) => Object.fromEntries([...row.querySelectorAll('[data-f]')].map((el) => [el.dataset.f, el.value.trim()])))
                    .filter((o) => o.judul || o.nama);
            });
            return { simple, lists };
        };

        const pulihkan = (simple) => {
            [...form.elements].forEach((el) => {
                if (!el.name || el.type === 'file' || !(el.name in simple)) return;
                const v = simple[el.name];
                if (el.type === 'checkbox') el.checked = el.dataset.single !== undefined ? !!v : (v || []).includes(el.value);
                else if (el.type === 'radio') el.checked = el.value === v;
                else el.value = v;
            });
        };

        if (tersimpan?.simple) pulihkan(tersimpan.simple);
        const pak = storage.get(PRIVASI_KEY) || {};
        form.querySelectorAll('[data-privasi]').forEach((t) => { if (t.name in pak) t.checked = !!pak[t.name]; });
        DAFTAR.forEach((n) => (tersimpan?.lists?.[n] ?? awal[n]).forEach((nilai) => tambahBaris(n, nilai)));

        if (tersimpan?.disimpan) {
            $('terakhir').textContent = `Terakhir disimpan: ${new Date(tersimpan.disimpan).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' })}`;
        }

        /* ---------- Penghitung huruf ---------- */
        form.querySelectorAll('textarea[maxlength]').forEach((t) => {
            const c = form.querySelector(`[data-counter="${t.name}"]`);
            const perbarui = () => { if (c) c.textContent = `${t.value.length}/${t.maxLength}`; };
            t.addEventListener('input', perbarui);
            perbarui();
        });

        /* ---------- Foto & dokumen ---------- */
        const fotoImg = $('avatar-img');
        const perbaruiInisial = () => {
            const nama = form.nama.value.trim();
            $('avatar-inisial').textContent = nama ? nama.split(/\s+/).slice(0, 2).map((k) => k[0].toUpperCase()).join('') : '?';
        };
        form.nama.addEventListener('input', perbaruiInisial);
        perbaruiInisial();

        const periksaFile = (input) => {
            const file = input.files[0];
            if (!file) return null;
            const maks = Number(input.dataset.maks);
            if (file.size > maks * 1024 * 1024) {
                toast(`Ukuran file terlalu besar (${(file.size / 1048576).toFixed(1)} MB). Maksimal ${maks} MB.`, '⚠️');
                input.value = '';
                return null;
            }
            return file;
        };

        $('foto').addEventListener('change', (e) => {
            const file = periksaFile(e.target);
            if (!file) return;
            fotoImg.src = URL.createObjectURL(file);
            fotoImg.classList.remove('hidden');
            $('foto-info').textContent = `Foto baru dipilih: ${file.name}`;
        });

        form.querySelectorAll('[data-dokumen] input[type=file]').forEach((input) => {
            input.addEventListener('change', () => {
                const file = periksaFile(input);
                if (!file) return;
                const status = input.closest('[data-dokumen]').querySelector('.dok-status');
                status.textContent = `✓ Akan diunggah: ${file.name}`;
                status.className = 'dok-status truncate text-xs text-teal-600';
            });
        });

        /* ---------- Kelengkapan profil ---------- */
        const nilai = (nama) => (form.elements[nama]?.value || '').trim();
        const terpilih = (nama) => form.querySelectorAll(`[name="${nama}"]:checked`).length;
        const adaFile = (nama) => form.querySelector(`[data-dokumen="${nama}"]`).dataset.ada === '1' || !!form.querySelector(`[name="${nama}"]`).files.length;
        const butir = [
            ['Data diri', '#identitas', () => nilai('nama') && nilai('tanggal_lahir') && nilai('kota') && terpilih('jenis_kelamin')],
            ['Kontak', '#identitas', () => nilai('email') && nilai('whatsapp')],
            ['Tentang saya', '#identitas', () => nilai('tentang').length >= 20],
            ['Komunikasi', '#komunikasi', () => terpilih('komunikasi') && terpilih('jbi')],
            ['Pendidikan', '#pendidikan', () => baris('pendidikan').some((r) => r.querySelector('[data-f=judul]').value.trim())],
            ['Keahlian (min. 3)', '#keahlian', () => baris('keahlian').filter((r) => r.querySelector('[data-f=nama]').value.trim()).length >= 3],
            ['CV', '#dokumen', () => adaFile('cv')],
            ['Foto profil', '#identitas', () => !!$('foto').files.length],
            ['Sertifikat', '#dokumen', () => adaFile('sertifikat')],
        ];

        const hitungKelengkapan = () => {
            const hasil = butir.map(([label, tujuan, cek]) => [label, tujuan, !!cek()]);
            const persen = Math.round(hasil.filter((h) => h[2]).length / hasil.length * 100);
            $('persen').textContent = `${persen}%`;
            $('ring').setAttribute('stroke-dasharray', `${(94.2 * persen / 100).toFixed(1)} 94.2`);
            $('persen-ket').textContent = persen === 100 ? 'Profil sudah lengkap' : persen >= 70 ? 'Hampir lengkap' : 'Masih ada yang bisa dilengkapi';
            $('checklist').replaceChildren(...hasil.map(([label, tujuan, selesai]) => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = tujuan;
                a.className = `flex items-center gap-2 rounded-lg px-2 py-1.5 transition hover:bg-surface ${selesai ? 'text-emerald-600' : 'text-slate-500'}`;
                a.innerHTML = `<span class="grid h-5 w-5 place-items-center rounded-full text-[11px] font-bold ${selesai ? 'bg-emerald-500 text-white' : 'border-2 border-slate-300'}">${selesai ? '✓' : ''}</span>`;
                a.append(label);
                li.appendChild(a);
                return li;
            }));
        };

        const tandaiKotor = () => { kotor = true; hitungKelengkapan(); };
        form.addEventListener('input', tandaiKotor);
        form.addEventListener('change', (e) => { tandaiKotor(); if (e.target.closest('.field.is-invalid')) checkField(e.target); });
        hitungKelengkapan();
        kotor = false;

        /* ---------- Keluar halaman tanpa menyimpan ---------- */
        window.addEventListener('beforeunload', (e) => { if (kotor) { e.preventDefault(); e.returnValue = ''; } });
        document.querySelectorAll('.batal').forEach((a) => a.addEventListener('click', (e) => {
            if (kotor && !confirm('Perubahan belum disimpan. Tinggalkan halaman ini?')) e.preventDefault();
        }));

        /* ---------- Simpan ---------- */
        const validasi = () => {
            const dilihat = new Set();
            const salah = [];
            form.querySelectorAll('[required]').forEach((el) => {
                if (el.type === 'radio') { if (dilihat.has(el.name)) return; dilihat.add(el.name); }
                if (!checkField(el)) salah.push(el);
            });
            if (salah.length) {
                toast(`Ada ${salah.length} kolom yang perlu diperbaiki. Lihat tanda merah.`, '⚠️');
                salah[0].closest('.field').scrollIntoView({ behavior: 'smooth', block: 'center' });
                if (salah[0].type !== 'radio') salah[0].focus({ preventScroll: true });
                return false;
            }
            return true;
        };

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!validasi()) return;

            const tombol = document.querySelectorAll('.simpan');
            tombol.forEach((b) => { b.disabled = true; b.querySelector('span').textContent = 'Menyimpan…'; });

            // TODO: kirim ke backend (PUT /profil) termasuk file; sementara disimpan di browser ini saja
            setTimeout(() => {
                const data = ambil();
                storage.set(KEY, { ...data, disimpan: new Date().toISOString() });
                storage.set(PRIVASI_KEY, Object.fromEntries([...form.querySelectorAll('[data-privasi]')].map((t) => [t.name, t.checked])));
                kotor = false;
                toast('Perubahan tersimpan di browser ini. Backend belum tersambung, jadi file belum terunggah.', '✅');
                setTimeout(() => { location.href = form.dataset.tujuan; }, 1400);
            }, 700);
        });
    })();
</script>
@endpush
