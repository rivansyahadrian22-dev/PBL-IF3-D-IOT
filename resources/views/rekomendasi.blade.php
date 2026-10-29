@extends('layouts.app')

@section('title', 'Rekomendasi Pekerjaan')

@php
    $akses = config('tunaker.akses');

    // Data contoh ada di config/lowongan.php — ganti dengan hasil rekomendasi dari ai-service / database
    $lowongan = config('lowongan.data');

    $tipeKerja = ['Full Time', 'Part Time', 'Remote', 'Hybrid', 'Magang'];
    $lokasi = collect($lowongan)->pluck('lokasi')->unique()->sort()->values();
    $kelengkapan = 78;

    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
@endphp

@section('content')
<div class="mx-auto max-w-7xl">
    {{-- ============ JUDUL ============ --}}
    <nav class="flex items-center gap-2 text-xs font-medium text-slate-500" aria-label="Breadcrumb">
        <a href="{{ route('beranda') }}" class="hover:text-teal-600">Beranda</a>
        <span aria-hidden="true">/</span>
        <span class="text-navy-900">Rekomendasi Pekerjaan</span>
    </nav>
    <div class="mt-2 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 sm:text-3xl">Rekomendasi Pekerjaan Khusus Untuk Anda</h1>
            <p class="mt-1 max-w-2xl text-sm">Lowongan di bawah dipilih berdasarkan keahlian, lokasi, dan cara komunikasimu. Semua perusahaannya sudah terverifikasi ramah Tuli.</p>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-teal-50 px-3 py-1.5 text-xs font-semibold text-teal-600 ring-1 ring-teal-100">
            <span class="relative flex h-2 w-2"><span class="absolute h-full w-full animate-ping rounded-full bg-teal-500 opacity-75"></span><span class="relative h-2 w-2 rounded-full bg-teal-500"></span></span>
            Diperbarui hari ini, 08.00
        </span>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1fr_20rem]">
        {{-- ============ DAFTAR ============ --}}
        <div class="min-w-0">
            {{-- Toolbar --}}
            <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-3 md:flex-row">
                    <div class="relative flex-1">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                        <input id="cari" type="search" placeholder="Cari posisi atau perusahaan…" class="{{ $input }} pl-11">
                    </div>
                    <div class="flex gap-3">
                        <select id="urutkan" class="{{ $input }} md:w-48" aria-label="Urutkan">
                            <option value="cocok">Paling cocok</option>
                            <option value="gaji">Gaji tertinggi</option>
                            <option value="baru">Terbaru</option>
                        </select>
                        <button type="button" id="filter-toggle" class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-slate-200 px-4 text-sm font-semibold text-navy-900 xl:hidden">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/></svg>
                            Filter
                        </button>
                    </div>
                </div>
                <div class="mt-3 flex gap-2 overflow-x-auto pb-1" role="tablist">
                    @foreach (['semua' => 'Semua Rekomendasi', 'bisindo' => 'Interview BISINDO', 'tertulis' => 'Komunikasi tertulis', 'jarak-jauh' => 'Remote / Hybrid', 'pemula' => 'Tanpa pengalaman'] as $kunci => $teks)
                        <button type="button" data-tab="{{ $kunci }}"
                                class="tab-btn shrink-0 rounded-full border px-3.5 py-1.5 text-xs font-semibold transition {{ $loop->first ? 'border-navy-900 bg-navy-900 text-white' : 'border-slate-200 text-slate-600 hover:border-teal-500' }}">{{ $teks }}</button>
                    @endforeach
                </div>
            </div>

            <p class="mt-4 text-sm"><b id="jumlah" class="text-navy-900">{{ count($lowongan) }}</b> lowongan ditemukan</p>

            <div id="daftar" class="mt-3 grid gap-4 md:grid-cols-2">
                @foreach ($lowongan as $slug => $job)
                    @php
                        $warnaCocok = $job['cocok'] >= 90 ? 'bg-emerald-500' : ($job['cocok'] >= 80 ? 'bg-teal-500' : 'bg-amber-500');
                        $gajiTeks = 'Rp ' . str_replace('.', ',', $job['gaji'][0]) . ' – ' . str_replace('.', ',', $job['gaji'][1]) . ' jt';
                    @endphp
                    <article class="job flex flex-col rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                             data-slug="{{ $slug }}" data-posisi="{{ $job['posisi'] }}" data-cari="{{ strtolower($job['posisi'] . ' ' . $job['perusahaan']) }}"
                             data-tipe="{{ $job['tipe'] }}" data-lokasi="{{ $job['lokasi'] }}" data-akses="{{ implode(' ', $job['akses']) }}"
                             data-pemula="{{ $job['pengalaman'] === 'Tanpa pengalaman' ? 1 : 0 }}"
                             data-cocok="{{ $job['cocok'] }}" data-gaji="{{ $job['gaji'][1] }}" data-gaji-min="{{ $job['gaji'][0] }}" data-hari="{{ $job['hari'] }}">
                        <div class="flex items-start gap-3">
                            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-gradient-to-br {{ $job['warna'] }} text-2xl shadow" aria-hidden="true">{{ $job['emoji'] }}</span>
                            <div class="min-w-0 flex-1">
                                <h2 class="font-extrabold leading-snug text-navy-900">{{ $job['posisi'] }}</h2>
                                <p class="flex items-center gap-1 text-sm">
                                    <span class="truncate">{{ $job['perusahaan'] }}</span>
                                    <svg class="h-4 w-4 shrink-0 text-teal-500" viewBox="0 0 24 24" fill="currentColor" aria-label="Terverifikasi"><path fill-rule="evenodd" d="M8.6 3.6a3.75 3.75 0 0 1 6.8 0 3.75 3.75 0 0 1 4.8 4.8 3.75 3.75 0 0 1 0 6.8 3.75 3.75 0 0 1-4.8 4.8 3.75 3.75 0 0 1-6.8 0 3.75 3.75 0 0 1-4.8-4.8 3.75 3.75 0 0 1 0-6.8 3.75 3.75 0 0 1 4.8-4.8Zm7.01 6.33a.75.75 0 1 0-1.22-.87l-3.24 4.53-1.62-1.62a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.09l3.75-5.25Z" clip-rule="evenodd"/></svg>
                                </p>
                            </div>
                            <span class="shrink-0 rounded-full {{ $warnaCocok }} px-2.5 py-1 text-xs font-bold text-white">{{ $job['cocok'] }}% Cocok</span>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-x-3 gap-y-1 text-xs text-slate-500">
                            <span>📍 {{ $job['lokasi'] }}</span>
                            <span>🕒 {{ $job['tipe'] }}</span>
                            <span>🎯 {{ $job['pengalaman'] }}</span>
                        </div>

                        <p class="mt-3 flex gap-2 rounded-xl bg-surface p-3 text-xs leading-relaxed text-navy-900">
                            <span aria-hidden="true">✨</span>
                            <span><b>Kenapa cocok?</b> {{ $job['alasan'] }}</span>
                        </p>

                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach ($job['akses'] as $a)
                                <span class="rounded-md bg-teal-50 px-2 py-1 text-[11px] font-semibold text-teal-600">{{ $akses[$a] }}</span>
                            @endforeach
                        </div>

                        <div class="mt-4 flex items-end justify-between gap-3">
                            <p class="text-sm font-extrabold text-navy-900">{{ $gajiTeks }} <span class="text-xs font-medium text-slate-400">/ bulan</span></p>
                            <p class="text-[11px] text-slate-400">{{ $job['hari'] === 0 ? 'Hari ini' : $job['hari'] . ' hari lalu' }}</p>
                        </div>

                        <div class="mt-auto flex gap-2 pt-4">
                            <button type="button" class="bookmark grid h-10 w-10 shrink-0 place-items-center rounded-lg border border-slate-200 text-slate-500 transition hover:text-navy-900" aria-label="Simpan lowongan" aria-pressed="false">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.59 3.32c1.1.13 1.91 1.08 1.91 2.19V21L12 17.25 4.5 21V5.51c0-1.11.81-2.06 1.91-2.19a48.5 48.5 0 0 1 11.18 0Z"/></svg>
                            </button>
                            <a href="{{ route('lowongan.detail', $slug) }}" class="grid flex-1 place-items-center rounded-lg border border-slate-200 py-2.5 text-xs font-semibold text-navy-900 transition hover:border-navy-900">Lihat Detail</a>
                            <x-lowongan.lamar :job="$job" class="flex-1 rounded-lg bg-navy-900 py-2.5 text-xs font-semibold text-white transition hover:bg-teal-600">Lamar Sekarang</x-lowongan.lamar>
                        </div>
                    </article>
                @endforeach
            </div>

            <div id="kosong" class="mt-3 hidden rounded-2xl border border-dashed border-slate-200 bg-white p-10 text-center">
                <p class="text-4xl" aria-hidden="true">🔍</p>
                <p class="mt-3 font-bold text-navy-900">Belum ada lowongan yang sesuai</p>
                <p class="mt-1 text-sm">Coba ubah kata kunci atau kurangi filter.</p>
                <button type="button" class="reset-filter mt-4 rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white">Reset Filter</button>
            </div>

            <nav id="halaman" class="mt-6 flex items-center justify-center gap-2" aria-label="Halaman"></nav>
        </div>

        {{-- ============ PANEL KANAN ============ --}}
        <aside id="panel-filter" class="hidden space-y-4 xl:block">
            {{-- Kecocokan profil --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 p-5 text-white">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-teal-500/30 blur-2xl" aria-hidden="true"></div>
                <div class="relative flex items-center gap-4">
                    <span class="relative grid h-16 w-16 shrink-0 place-items-center">
                        <svg class="h-16 w-16 -rotate-90" viewBox="0 0 36 36"><circle cx="18" cy="18" r="15" fill="none" stroke="rgb(255 255 255 / .15)" stroke-width="4"/><circle cx="18" cy="18" r="15" fill="none" stroke="#14a3a6" stroke-width="4" stroke-linecap="round" stroke-dasharray="{{ round(94.2 * $kelengkapan / 100, 1) }} 94.2"/></svg>
                        <span class="absolute text-sm font-extrabold">{{ $kelengkapan }}%</span>
                    </span>
                    <div>
                        <p class="font-extrabold">Kecocokan Profil</p>
                        <p class="text-xs text-slate-300">Tambahkan sertifikat supaya rekomendasi lebih sesuai.</p>
                    </div>
                </div>
                <a href="#" class="relative mt-4 block rounded-lg bg-white/10 py-2 text-center text-xs font-bold ring-1 ring-white/20 transition hover:bg-white/20">Perbarui Profil</a>
            </div>

            {{-- Filter --}}
            <form id="form-filter" class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm" onsubmit="return false">
                <div class="flex items-center justify-between">
                    <p class="font-extrabold text-navy-900">Filter</p>
                    <button type="button" class="reset-filter text-xs font-semibold text-teal-600 hover:underline">Reset</button>
                </div>

                <fieldset class="mt-4">
                    <legend class="text-xs font-bold uppercase tracking-wider text-slate-500">Aksesibilitas lingkungan</legend>
                    <div class="mt-2 space-y-2">
                        @foreach ($akses as $kunci => $teks)
                            <label class="flex cursor-pointer items-center gap-2.5 text-sm text-navy-900">
                                <input type="checkbox" name="akses" value="{{ $kunci }}" class="h-4 w-4 rounded border-slate-300 accent-teal-600"> {{ $teks }}
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <fieldset class="mt-5">
                    <legend class="text-xs font-bold uppercase tracking-wider text-slate-500">Tipe pekerjaan</legend>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach ($tipeKerja as $tipe)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="tipe" value="{{ $tipe }}" class="peer sr-only">
                                <span class="chip inline-block rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold transition hover:border-teal-500 peer-checked:border-navy-900 peer-checked:bg-navy-900 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15">{{ $tipe }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <label class="mt-5 block">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Lokasi</span>
                    <select name="lokasi" class="{{ $input }} mt-2">
                        <option value="">Semua lokasi</option>
                        @foreach ($lokasi as $l)
                            <option>{{ $l }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="mt-5 block">
                    <span class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-500">
                        Gaji minimal <span id="gaji-label" class="normal-case tracking-normal text-teal-600">Semua</span>
                    </span>
                    <input type="range" name="gaji" min="0" max="8" step="1" value="0" class="mt-3 w-full accent-teal-600">
                    <span class="mt-1 flex justify-between text-[11px] text-slate-400"><span>Rp 0</span><span>Rp 8 jt+</span></span>
                </label>
            </form>

            {{-- Bantuan --}}
            <div class="rounded-2xl border border-teal-100 bg-teal-50 p-5">
                <p class="text-2xl" aria-hidden="true">🤖</p>
                <p class="mt-2 font-extrabold text-navy-900">Bingung memilih?</p>
                <p class="mt-1 text-sm">Tanya Konsultasi AI atau tonton panduan memilih lowongan dalam BISINDO.</p>
                <div class="mt-4 grid gap-2">
                    <a href="{{ route('konsultasi') }}" class="rounded-lg bg-navy-900 py-2.5 text-center text-xs font-bold text-white transition hover:bg-navy-800">Tanya Konsultasi AI</a>
                    <button type="button" class="video-btn rounded-lg border border-teal-500 bg-white py-2.5 text-xs font-bold text-teal-600 transition hover:bg-teal-50"
                            data-video="" data-judul="Cara memilih lowongan yang cocok">Panduan BISINDO</button>
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
        const PER_HALAMAN = 6;
        const SIMPAN_KEY = 'tunaker_lowongan_disimpan';

        const daftar = document.getElementById('daftar');
        const cards = [...daftar.querySelectorAll('.job')];
        const formFilter = document.getElementById('form-filter');
        let tab = 'semua';
        let halaman = 1;

        /* ---------- Filter, urutkan, halaman ---------- */
        const terapkan = (resetHalaman = true) => {
            if (resetHalaman) halaman = 1;
            const kata = document.getElementById('cari').value.trim().toLowerCase();
            const aksesDipilih = [...formFilter.querySelectorAll('[name=akses]:checked')].map((c) => c.value);
            const tipeDipilih = [...formFilter.querySelectorAll('[name=tipe]:checked')].map((c) => c.value);
            const lokasi = formFilter.lokasi.value;
            const gajiMin = Number(formFilter.gaji.value);

            const cocok = cards.filter((c) => {
                const d = c.dataset;
                const aksesKartu = d.akses.split(' ');
                if (kata && !d.cari.includes(kata)) return false;
                if (tab === 'bisindo' && !aksesKartu.includes('bisindo')) return false;
                if (tab === 'tertulis' && !aksesKartu.some((a) => ['tertulis', 'chat'].includes(a))) return false;
                if (tab === 'jarak-jauh' && !['Remote', 'Hybrid'].includes(d.tipe)) return false;
                if (tab === 'pemula' && d.pemula !== '1') return false;
                if (!aksesDipilih.every((a) => aksesKartu.includes(a))) return false;
                if (tipeDipilih.length && !tipeDipilih.includes(d.tipe)) return false;
                if (lokasi && d.lokasi !== lokasi) return false;
                if (gajiMin && Number(d.gaji) < gajiMin) return false;
                return true;
            });

            const urut = document.getElementById('urutkan').value;
            cocok.sort((a, b) => urut === 'gaji' ? b.dataset.gaji - a.dataset.gaji
                : urut === 'baru' ? a.dataset.hari - b.dataset.hari
                : b.dataset.cocok - a.dataset.cocok);

            const totalHalaman = Math.max(1, Math.ceil(cocok.length / PER_HALAMAN));
            halaman = Math.min(halaman, totalHalaman);
            const tampil = cocok.slice((halaman - 1) * PER_HALAMAN, halaman * PER_HALAMAN);

            cards.forEach((c) => c.classList.add('hidden'));
            tampil.forEach((c) => {
                daftar.appendChild(c);
                c.classList.remove('hidden', 'pop-in');
                void c.offsetWidth;
                c.classList.add('pop-in');
            });

            document.getElementById('jumlah').textContent = cocok.length;
            document.getElementById('kosong').classList.toggle('hidden', cocok.length > 0);
            renderHalaman(totalHalaman, cocok.length);
        };

        const renderHalaman = (total, jumlah) => {
            const nav = document.getElementById('halaman');
            nav.innerHTML = '';
            if (jumlah <= PER_HALAMAN) return;
            const tombol = (label, ke, aktif = false, mati = false) => {
                const b = document.createElement('button');
                b.type = 'button';
                b.innerHTML = label;
                b.disabled = mati;
                b.className = 'grid h-10 min-w-10 place-items-center rounded-lg px-3 text-sm font-semibold transition disabled:opacity-40 ' +
                    (aktif ? 'bg-navy-900 text-white' : 'border border-slate-200 bg-white text-navy-900 hover:border-teal-500');
                if (aktif) b.setAttribute('aria-current', 'page');
                b.addEventListener('click', () => {
                    halaman = ke;
                    terapkan(false);
                    document.getElementById('jumlah').scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
                nav.appendChild(b);
            };
            tombol('← Sebelumnya', halaman - 1, false, halaman === 1);
            for (let i = 1; i <= total; i++) tombol(i, i, i === halaman);
            tombol('Berikutnya →', halaman + 1, false, halaman === total);
        };

        document.querySelectorAll('.tab-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                tab = btn.dataset.tab;
                document.querySelectorAll('.tab-btn').forEach((b) => {
                    const aktif = b === btn;
                    b.classList.toggle('border-navy-900', aktif);
                    b.classList.toggle('bg-navy-900', aktif);
                    b.classList.toggle('text-white', aktif);
                    b.classList.toggle('border-slate-200', !aktif);
                    b.classList.toggle('text-slate-600', !aktif);
                });
                terapkan();
            });
        });

        let tundaCari;
        document.getElementById('cari').addEventListener('input', () => { clearTimeout(tundaCari); tundaCari = setTimeout(terapkan, 250); });
        document.getElementById('urutkan').addEventListener('change', () => terapkan());
        formFilter.addEventListener('change', () => terapkan());
        formFilter.gaji.addEventListener('input', () => {
            const v = Number(formFilter.gaji.value);
            document.getElementById('gaji-label').textContent = v ? `≥ Rp ${v} jt` : 'Semua';
        });

        document.querySelectorAll('.reset-filter').forEach((btn) => btn.addEventListener('click', () => {
            formFilter.reset();
            document.getElementById('gaji-label').textContent = 'Semua';
            document.getElementById('cari').value = '';
            document.querySelector('.tab-btn[data-tab="semua"]').click();
        }));

        document.getElementById('filter-toggle').addEventListener('click', () => {
            const panel = document.getElementById('panel-filter');
            panel.classList.toggle('hidden');
            if (!panel.classList.contains('hidden')) panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        /* ---------- Simpan lowongan ---------- */
        const disimpan = new Set(storage.get(SIMPAN_KEY) || []);
        const tandaiSimpan = (btn, aktif) => {
            btn.setAttribute('aria-pressed', aktif);
            btn.classList.toggle('bg-navy-900', aktif);
            btn.classList.toggle('text-white', aktif);
            btn.classList.toggle('border-navy-900', aktif);
            btn.querySelector('svg').setAttribute('fill', aktif ? 'currentColor' : 'none');
        };
        cards.forEach((card) => {
            const btn = card.querySelector('.bookmark');
            const posisi = card.dataset.posisi;
            tandaiSimpan(btn, disimpan.has(posisi));
            btn.addEventListener('click', () => {
                const aktif = !disimpan.has(posisi);
                aktif ? disimpan.add(posisi) : disimpan.delete(posisi);
                storage.set(SIMPAN_KEY, [...disimpan]);
                tandaiSimpan(btn, aktif);
                toast(aktif ? `"${posisi}" disimpan` : `"${posisi}" dihapus dari simpanan`, aktif ? '🔖' : '🗑️');
            });
        });

        terapkan();
    })();
</script>
@endpush
