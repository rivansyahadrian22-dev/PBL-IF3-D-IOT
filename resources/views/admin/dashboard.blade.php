@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@php
    $antreanItem = [
        ['pencari', 'Pencari kerja menunggu verifikasi', 'pengguna', 'admin.pencari', ['status' => 'menunggu']],
        ['perusahaan', 'Perusahaan menunggu verifikasi', 'perusahaan', 'admin.perusahaan', ['status' => 'verifikasi']],
        ['lowongan', 'Lowongan perlu review akomodasi', 'lowongan', 'admin.lowongan', ['status' => 'review']],
        ['kartu', 'Kartu menunggu aktivasi', 'kartu', 'admin.rfid', ['status' => 'menunggu']],
    ];
    $antreanAwal = collect([
        'pencari' => count($menungguIds), 'perusahaan' => count($antrean['perusahaanIds']),
        'lowongan' => count($antrean['lowonganIds']), 'kartu' => count($antrean['kartuIds']),
    ]);
    $penyerapan = $statistik['terverifikasi'] ? (int) round($statistik['bekerja'] / $statistik['terverifikasi'] * 100) : 0;
    $naik = $statistik['naikPersen'];

    // [label, angka (id), keterangan, warna ikon, ikon, link]
    $kartu = [
        ['Total Pencari Kerja', $statistik['total'], 'stat-total', $statistik['baruBulanIni'] . ' pendaftar baru bulan ini', 'bg-navy-900/5 text-navy-900',
         'M15 19.13a9.38 9.38 0 0 0 2.63.37 9.34 9.34 0 0 0 4.12-.95 4.13 4.13 0 0 0-7.53-2.49M15 19.13v-.01c0-1.11-.28-2.16-.79-3.07M15 19.13v.1A12.32 12.32 0 0 1 8.62 21c-2.33 0-4.51-.65-6.37-1.77l-.01-.11a6.38 6.38 0 0 1 11.96-3.07M12 6.38a3.38 3.38 0 1 1-6.75 0 3.38 3.38 0 0 1 6.75 0Zm8.25 2.25a2.63 2.63 0 1 1-5.25 0 2.63 2.63 0 0 1 5.25 0Z'],
        ['Menunggu Verifikasi', $statistik['menunggu'], 'stat-menunggu', 'Perlu dicek dokumen dan identitasnya', 'bg-amber-50 text-amber-600',
         'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
        ['Lowongan Aktif', $lowonganAktif, null, 'Dari ' . $perusahaan . ' perusahaan mitra', 'bg-teal-50 text-teal-600',
         'M20.25 14.15v4.25c0 1.1-.78 2.04-1.86 2.18-2.08.28-4.21.42-6.39.42s-4.31-.14-6.39-.42c-1.08-.14-1.86-1.09-1.86-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.66V8.71c0-1.08-.77-2.01-1.84-2.17a48.4 48.4 0 0 0-3.41-.39M20.25 14.15a2.2 2.2 0 0 1-1.42.53H5.17c-.54 0-1.04-.2-1.42-.53m0 0A2.18 2.18 0 0 1 3 12.49V8.71c0-1.08.77-2.01 1.84-2.17a48.5 48.5 0 0 1 3.41-.39m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.89m7.5 0a48.7 48.7 0 0 0-7.5 0'],
        ['Sudah Bekerja', $statistik['bekerja'], 'stat-bekerja', 'Tingkat penyerapan ' . $penyerapan . '% dari yang terverifikasi', 'bg-emerald-50 text-emerald-600',
         'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
    ];
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    {{-- ============ JUDUL ============ --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div class="max-w-2xl">
            <h1 class="text-2xl font-extrabold text-navy-900 sm:text-3xl">Dashboard Admin</h1>
            <p class="mt-1 text-sm leading-relaxed">Ringkasan layanan TUNAKER: pendaftaran pencari kerja, verifikasi, dan penyerapan kerja penyandang tunarungu.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.pencari') }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">Kelola Pencari Kerja</a>
            <button type="button" id="unduh-laporan" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Unduh Laporan
            </button>
        </div>
    </div>

    {{-- ============ STATISTIK ============ --}}
    <section class="grid grid-cols-2 gap-4 xl:grid-cols-4" aria-label="Ringkasan angka">
        @foreach ($kartu as [$label, $angka, $idAngka, $ket, $warna, $ikon])
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $label }}</p>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl {{ $warna }}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}"/></svg>
                    </span>
                </div>
                <p class="mt-2 text-3xl font-extrabold text-navy-900" @if ($idAngka) id="{{ $idAngka }}" @endif>{{ number_format($angka, 0, ',', '.') }}</p>
                <p class="mt-1 text-xs font-semibold text-slate-500">{{ $ket }}</p>
                @if ($loop->first)
                    <p class="mt-2 inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-bold {{ $naik >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                        <span aria-hidden="true">{{ $naik >= 0 ? '↑' : '↓' }}</span> {{ abs($naik) }}% dibanding bulan lalu
                    </p>
                @elseif ($loop->index === 1)
                    <a href="{{ route('admin.pencari', ['status' => 'menunggu']) }}" class="mt-2 inline-block text-[11px] font-bold text-teal-600 hover:underline">Tinjau sekarang →</a>
                @endif
            </div>
        @endforeach
    </section>

    {{-- ============ GRAFIK ============ --}}
    <section class="grid gap-6 xl:grid-cols-[1fr_22rem]">
        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="text-lg font-extrabold text-navy-900">Tren Pendaftaran & Penyerapan Kerja</h2>
                    <p id="tren-ringkas" class="text-sm"></p>
                </div>
                <div class="flex gap-1 rounded-xl bg-surface p-1" role="tablist" aria-label="Rentang waktu">
                    @foreach (['bulan' => 'Bulan', 'kuartal' => 'Kuartal', 'tahun' => 'Tahun'] as $kunci => $teks)
                        <button type="button" role="tab" data-rentang="{{ $kunci }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                class="rentang-btn rounded-lg px-3.5 py-1.5 text-xs font-bold transition {{ $loop->first ? 'bg-navy-900 text-white shadow' : 'text-slate-500 hover:text-navy-900' }}">{{ $teks }}</button>
                    @endforeach
                </div>
            </div>

            <div id="chart-wrap" class="relative mt-4">
                <svg id="chart" viewBox="0 0 640 270" class="block h-auto w-full touch-pan-y rounded-lg focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-500/30" tabindex="0" role="img"
                     aria-label="Grafik garis pendaftaran dan penyerapan kerja. Gunakan tombol panah kiri dan kanan untuk membaca tiap titik."></svg>
                <div id="chart-tip" class="pointer-events-none absolute hidden whitespace-nowrap rounded-lg bg-navy-900 px-3 py-2 text-xs text-white shadow-xl" role="status"></div>
            </div>

            <div class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-semibold text-navy-900">
                <span class="inline-flex items-center gap-2"><svg width="26" height="8" aria-hidden="true"><line x1="0" y1="4" x2="26" y2="4" stroke="#0b2545" stroke-width="3" stroke-linecap="round"/></svg> Pendaftaran pencari kerja</span>
                <span class="inline-flex items-center gap-2"><svg width="26" height="8" aria-hidden="true"><line x1="0" y1="4" x2="26" y2="4" stroke="#14a3a6" stroke-width="3" stroke-linecap="round" stroke-dasharray="6 4"/></svg> Penyerapan kerja</span>
            </div>

            <table class="sr-only">
                <caption>Data grafik tren</caption>
                <thead><tr><th>Periode</th><th>Pendaftaran</th><th>Penyerapan kerja</th></tr></thead>
                <tbody id="chart-tabel"></tbody>
            </table>
        </div>

        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-lg font-extrabold text-navy-900">Perlu Ditindak</h2>
                    <p class="text-sm">Pekerjaan yang menunggu admin.</p>
                </div>
                <span id="antrean-total" class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700" aria-live="polite">{{ $antreanAwal->sum() }}</span>
            </div>

            <ul class="mt-4 space-y-3">
                @foreach ($antreanItem as [$kunci, $label, $ikon, $rute, $param])
                    <li>
                        <a href="{{ route($rute, $param) }}" data-antrean="{{ $kunci }}" class="flex items-center gap-3 rounded-xl border border-slate-100 p-3.5 transition hover:border-teal-500 hover:bg-teal-50/40 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-teal-500/30">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-surface text-navy-900"><x-admin.ikon :nama="$ikon" /></span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-sm font-bold text-navy-900">{{ $label }}</span>
                                <span data-antrean-ket class="block text-xs font-semibold text-teal-600">Tinjau sekarang →</span>
                            </span>
                            <span data-antrean-angka class="grid h-8 min-w-8 place-items-center rounded-full bg-amber-100 px-2 text-sm font-extrabold text-amber-700">{{ $antreanAwal[$kunci] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <p id="antrean-beres" class="mt-4 hidden rounded-xl bg-emerald-50 p-3 text-sm font-semibold text-emerald-700">Semua sudah beres. Tidak ada yang menunggu.</p>
            <a href="{{ route('admin.laporan') }}" class="mt-5 block text-sm font-semibold text-teal-600 hover:underline">Lihat rincian komunikasi dan penempatan di Statistik & Laporan →</a>
        </div>
    </section>

    {{-- ============ AKTIVITAS ============ --}}
    <section class="rounded-3xl border border-slate-100 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 p-5 sm:p-6">
            <div>
                <h2 class="text-lg font-extrabold text-navy-900">Aktivitas Pelamar & Verifikasi Terbaru</h2>
                <p class="text-sm">Pendaftar terbaru beserta lowongan yang mereka lamar.</p>
            </div>
            <a href="{{ route('admin.pencari') }}" class="text-sm font-semibold text-teal-600 hover:underline">Lihat semua pencari kerja →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[52rem] text-left text-sm">
                <thead class="bg-surface text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3">Pencari Kerja</th>
                        <th scope="col" class="px-5 py-3">Lowongan Dilamar</th>
                        <th scope="col" class="px-5 py-3">Komunikasi</th>
                        <th scope="col" class="px-5 py-3">Dokumen</th>
                        <th scope="col" class="px-5 py-3">Status</th>
                        <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($aktivitas as $a)
                        <tr class="baris-aktivitas transition hover:bg-surface/60" data-id="{{ $a['id'] }}" data-status="{{ $a['status'] }}">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-teal-500 to-navy-800 text-xs font-bold text-white" aria-hidden="true">{{ collect(explode(' ', $a['nama']))->take(2)->map(fn ($k) => mb_substr($k, 0, 1))->implode('') }}</span>
                                    <div class="min-w-0">
                                        <p class="font-bold text-navy-900">{{ $a['nama'] }}</p>
                                        <p class="text-xs text-slate-500">{{ $a['id'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <p class="font-semibold text-navy-900">{{ $a['posisi'] }}</p>
                                <p class="text-xs text-slate-500">{{ $a['perusahaan'] }}</p>
                            </td>
                            <td class="px-5 py-3.5"><span class="whitespace-nowrap rounded-md bg-teal-50 px-2 py-1 text-[11px] font-semibold text-teal-600">{{ $a['komunikasi'] }}</span></td>
                            <td class="px-5 py-3.5">
                                <span class="whitespace-nowrap rounded-md px-2 py-1 text-[11px] font-semibold {{ $a['dokumen'] === 'Lengkap' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-700' }}">{{ $a['dokumen'] }}</span>
                            </td>
                            <td class="px-5 py-3.5" data-sel-status></td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.pencari', ['q' => $a['id']]) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-navy-900 transition hover:border-navy-900">Detail</a>
                                    <button type="button" data-verifikasi class="hidden rounded-lg bg-navy-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-teal-600">Verifikasi</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 text-xs text-slate-500 sm:px-6">
            <p id="aktivitas-info"></p>
            <nav id="aktivitas-halaman" class="flex items-center gap-1.5" aria-label="Halaman aktivitas"></nav>
        </div>
    </section>
</div>

@php $dataJson = compact('tren', 'donut', 'menungguIds', 'bekerjaIds', 'statistik', 'antrean'); @endphp
<script type="application/json" id="data-dashboard">@json($dataJson)</script>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { toast } = window.TunakerUI;
        const { dataAdmin, lencana, unduhCsv, hitungAntrean } = window.TunakerAdmin;
        const data = JSON.parse(document.getElementById('data-dashboard').textContent);
        const $ = (id) => document.getElementById(id);
        const angka = (n) => Number(n).toLocaleString('id-ID');

        /* ---------- Grafik tren ---------- */
        const W = 640, H = 270, M = { l: 40, r: 16, t: 16, b: 32 };
        const WARNA = { daftar: '#0b2545', kerja: '#14a3a6' };
        const svg = $('chart');
        const tip = $('chart-tip');
        let rentang = 'bulan';
        let aktif = null;

        const langkahBagus = (v) => {
            const p = 10 ** Math.floor(Math.log10(Math.max(v, 1)));
            return ([1, 2, 3, 4, 5, 6, 8, 10].map((k) => k * p).find((k) => k >= v)) ?? 10 * p;
        };

        const gambar = () => {
            const g = data.tren[rentang];
            const n = g.label.length;
            const langkah = langkahBagus(Math.max(...g.daftar, ...g.kerja, 1) / 4);
            const maks = langkah * 4;
            const x = (i) => M.l + (n === 1 ? (W - M.l - M.r) / 2 : i * (W - M.l - M.r) / (n - 1));
            const y = (v) => M.t + (1 - v / maks) * (H - M.t - M.b);
            const kurva = (arr) => arr.reduce((d, v, i) => i === 0
                ? `M${x(0)},${y(v)}`
                : `${d} C${(x(i - 1) + x(i)) / 2},${y(arr[i - 1])} ${(x(i - 1) + x(i)) / 2},${y(v)} ${x(i)},${y(v)}`, '');

            let isi = `<defs><linearGradient id="isi-area" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="${WARNA.daftar}" stop-opacity=".22"/><stop offset="1" stop-color="${WARNA.daftar}" stop-opacity="0"/></linearGradient></defs>`;
            for (let k = 0; k <= 4; k++) {
                const nilai = langkah * k;
                isi += `<line x1="${M.l}" x2="${W - M.r}" y1="${y(nilai)}" y2="${y(nilai)}" stroke="#e2e8f0" stroke-width="1"/>`
                    + `<text x="${M.l - 8}" y="${y(nilai) + 4}" text-anchor="end" font-size="11" fill="#64748b">${nilai}</text>`;
            }
            g.label.forEach((l, i) => { isi += `<text x="${x(i)}" y="${H - 10}" text-anchor="middle" font-size="11" fill="#64748b">${l}</text>`; });
            isi += `<path d="${kurva(g.daftar)} L${x(n - 1)},${y(0)} L${x(0)},${y(0)} Z" fill="url(#isi-area)"/>`
                + `<path d="${kurva(g.kerja)}" fill="none" stroke="${WARNA.kerja}" stroke-width="2.5" stroke-dasharray="7 5" stroke-linecap="round"/>`
                + `<path d="${kurva(g.daftar)}" fill="none" stroke="${WARNA.daftar}" stroke-width="2.75" stroke-linecap="round"/>`;
            g.daftar.forEach((v, i) => { isi += `<circle cx="${x(i)}" cy="${y(v)}" r="3.5" fill="#fff" stroke="${WARNA.daftar}" stroke-width="2"/>`; });
            isi += `<g id="sorot" class="hidden"><line id="sorot-garis" y1="${M.t}" y2="${H - M.b}" stroke="#94a3b8" stroke-dasharray="3 3"/>`
                + `<circle id="sorot-d" r="5.5" fill="${WARNA.daftar}" stroke="#fff" stroke-width="2"/><circle id="sorot-k" r="5.5" fill="${WARNA.kerja}" stroke="#fff" stroke-width="2"/></g>`;
            svg.innerHTML = isi;
            svg._geo = { n, x, y, g };

            $('tren-ringkas').textContent = `${angka(g.daftar.reduce((a, b) => a + b, 0))} pendaftar dan ${angka(g.kerja.reduce((a, b) => a + b, 0))} penempatan kerja pada rentang ini.`;
            $('chart-tabel').innerHTML = g.label.map((l, i) => `<tr><td>${l}</td><td>${g.daftar[i]}</td><td>${g.kerja[i]}</td></tr>`).join('');
            sembunyi();
        };

        const tampil = (i) => {
            const { n, x, y, g } = svg._geo;
            aktif = Math.max(0, Math.min(n - 1, i));
            const px = x(aktif);
            svg.querySelector('#sorot').classList.remove('hidden');
            const garis = svg.querySelector('#sorot-garis');
            garis.setAttribute('x1', px); garis.setAttribute('x2', px);
            const d = svg.querySelector('#sorot-d'); d.setAttribute('cx', px); d.setAttribute('cy', y(g.daftar[aktif]));
            const k = svg.querySelector('#sorot-k'); k.setAttribute('cx', px); k.setAttribute('cy', y(g.kerja[aktif]));

            tip.innerHTML = `<b class="block">${g.label[aktif]}</b>Pendaftaran: <b>${g.daftar[aktif]}</b><br>Penyerapan kerja: <b>${g.kerja[aktif]}</b>`;
            tip.classList.remove('hidden');
            tip.style.left = `${px / W * 100}%`;
            tip.style.top = `${Math.min(y(g.daftar[aktif]), y(g.kerja[aktif])) / H * 100}%`;
            tip.style.transform = `translate(${aktif < n / 3 ? '-15%' : aktif > n * 2 / 3 ? '-85%' : '-50%'}, calc(-100% - 12px))`;
        };

        const sembunyi = () => { aktif = null; tip.classList.add('hidden'); svg.querySelector('#sorot')?.classList.add('hidden'); };

        svg.addEventListener('pointermove', (e) => {
            const r = svg.getBoundingClientRect();
            const px = (e.clientX - r.left) * (W / r.width);
            const { n } = svg._geo;
            tampil(Math.round((px - M.l) / (W - M.l - M.r) * (n - 1)));
        });
        svg.addEventListener('pointerleave', sembunyi);
        svg.addEventListener('keydown', (e) => {
            if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
            e.preventDefault();
            tampil((aktif ?? (e.key === 'ArrowRight' ? -1 : svg._geo.n)) + (e.key === 'ArrowRight' ? 1 : -1));
        });
        svg.addEventListener('blur', sembunyi);

        document.querySelectorAll('.rentang-btn').forEach((btn) => btn.addEventListener('click', () => {
            rentang = btn.dataset.rentang;
            document.querySelectorAll('.rentang-btn').forEach((b) => {
                const pilih = b === btn;
                b.setAttribute('aria-selected', pilih);
                b.classList.toggle('bg-navy-900', pilih);
                b.classList.toggle('text-white', pilih);
                b.classList.toggle('shadow', pilih);
                b.classList.toggle('text-slate-500', !pilih);
            });
            gambar();
        }));
        gambar();

        /* ---------- Perlu ditindak ---------- */
        const antrean = data.antrean;
        const segarkanAntrean = () => {
            const n = {
                pencari: dataAdmin.hitungMenunggu(data.menungguIds),
                perusahaan: hitungAntrean(antrean.perusahaanIds, 'tunaker_admin_perusahaan', 'verifikasi'),
                lowongan: hitungAntrean(antrean.lowonganIds, 'tunaker_admin_lowongan', 'review'),
                kartu: hitungAntrean(antrean.kartuIds, 'tunaker_admin_rfid', 'menunggu'),
            };
            let total = 0;
            document.querySelectorAll('[data-antrean]').forEach((a) => {
                const jumlah = n[a.dataset.antrean];
                total += jumlah;
                const angka = a.querySelector('[data-antrean-angka]');
                angka.textContent = jumlah;
                angka.className = `grid h-8 min-w-8 place-items-center rounded-full px-2 text-sm font-extrabold ${jumlah ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'}`;
                a.querySelector('[data-antrean-ket]').textContent = jumlah ? 'Tinjau sekarang →' : 'Tidak ada yang menunggu';
            });
            $('antrean-total').textContent = total;
            $('antrean-total').className = `rounded-full px-3 py-1 text-xs font-bold ${total ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'}`;
            $('antrean-beres').classList.toggle('hidden', total > 0);
        };

        /* ---------- Aktivitas & verifikasi ---------- */
        const baris = [...document.querySelectorAll('.baris-aktivitas')];
        const PER = 5;
        let halaman = 1;

        const segarkanBaris = (b) => {
            b.querySelector('[data-sel-status]').innerHTML = lencana(b.dataset.status);
            b.querySelector('[data-verifikasi]').classList.toggle('hidden', b.dataset.status !== 'menunggu');
        };

        const segarkanAngka = () => {
            $('stat-menunggu').textContent = angka(dataAdmin.hitungMenunggu(data.menungguIds));
            $('stat-total').textContent = angka(data.statistik.total + dataAdmin.baru().length);
            // pelamar yang diterima lewat Data Lamaran di browser ini ikut dihitung sebagai sudah bekerja
            const baruBekerja = Object.keys(dataAdmin.bekerja()).filter((id) => !data.bekerjaIds.includes(id)).length;
            $('stat-bekerja').textContent = angka(data.statistik.bekerja + baruBekerja);
            segarkanAntrean();
            window.dispatchEvent(new Event('tunaker-admin-berubah'));
        };

        const tampilkanHalaman = () => {
            const totalHal = Math.ceil(baris.length / PER);
            halaman = Math.min(halaman, totalHal);
            baris.forEach((b, i) => b.classList.toggle('hidden', i < (halaman - 1) * PER || i >= halaman * PER));
            $('aktivitas-info').textContent = `Menampilkan ${(halaman - 1) * PER + 1}–${Math.min(halaman * PER, baris.length)} dari ${baris.length} aktivitas terbaru`;
            const nav = $('aktivitas-halaman');
            nav.innerHTML = '';
            const tombol = (label, ke, pilih = false, mati = false) => {
                const b = document.createElement('button');
                b.type = 'button';
                b.textContent = label;
                b.disabled = mati;
                b.className = 'grid h-9 min-w-9 place-items-center rounded-lg px-2.5 text-xs font-bold transition disabled:opacity-40 ' + (pilih ? 'bg-navy-900 text-white' : 'border border-slate-200 text-navy-900 hover:border-teal-500');
                if (pilih) b.setAttribute('aria-current', 'page');
                b.addEventListener('click', () => { halaman = ke; tampilkanHalaman(); });
                nav.appendChild(b);
            };
            tombol('←', halaman - 1, false, halaman === 1);
            for (let i = 1; i <= totalHal; i++) tombol(i, i, i === halaman);
            tombol('→', halaman + 1, false, halaman === totalHal);
        };

        const ubah = dataAdmin.status();
        baris.forEach((b) => {
            b.dataset.status = ubah[b.dataset.id] ?? b.dataset.status;
            segarkanBaris(b);
            b.querySelector('[data-verifikasi]').addEventListener('click', () => {
                dataAdmin.ubahStatus(b.dataset.id, 'terverifikasi');
                b.dataset.status = 'terverifikasi';
                segarkanBaris(b);
                segarkanAngka();
                toast(`${b.querySelector('td p.font-bold').textContent} sudah diverifikasi.`, '✅');
            });
        });
        segarkanAngka();
        tampilkanHalaman();

        /* ---------- Unduh laporan ---------- */
        $('unduh-laporan').addEventListener('click', () => {
            const g = data.tren[rentang];
            const s = data.statistik;
            const hariIni = new Date().toISOString().slice(0, 10);
            unduhCsv(`laporan-tunaker-${hariIni}.csv`, [
                ['Laporan TUNAKER', hariIni], [],
                ['Ringkasan', 'Jumlah'],
                ['Total pencari kerja', s.total], ['Terverifikasi (termasuk yang sudah bekerja)', s.terverifikasi],
                ['Menunggu verifikasi', s.menunggu], ['Sudah bekerja', s.bekerja], ['Ditolak', s.ditolak], [],
                ['Komunikasi utama', 'Jumlah'], ...data.donut.map((d) => [d.label, d.jumlah]), [],
                [`Tren (${rentang})`, 'Pendaftaran', 'Penyerapan kerja'], ...g.label.map((l, i) => [l, g.daftar[i], g.kerja[i]]),
            ]);
            toast('Laporan diunduh sebagai file CSV.', '⬇️');
        });
    })();
</script>
@endpush
