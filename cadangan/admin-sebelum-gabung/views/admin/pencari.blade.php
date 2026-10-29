@extends('admin.layouts.app')

@section('title', 'Pencari Kerja')

@php
    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $labelKecil = 'mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500';
    $s = $statistik;

    // [kunci status untuk filter, label, id angka, nilai awal, warna ikon, ikon, keterangan]
    $kartu = [
        ['', 'Total Pencari Kerja', 's-total', $s['total'], 'bg-navy-900/5 text-navy-900', 'M15 19.13a9.38 9.38 0 0 0 2.63.37 9.34 9.34 0 0 0 4.12-.95 4.13 4.13 0 0 0-7.53-2.49M15 19.13v-.01c0-1.11-.28-2.16-.79-3.07M15 19.13v.1A12.32 12.32 0 0 1 8.62 21c-2.33 0-4.51-.65-6.37-1.77l-.01-.11a6.38 6.38 0 0 1 11.96-3.07M12 6.38a3.38 3.38 0 1 1-6.75 0 3.38 3.38 0 0 1 6.75 0Zm8.25 2.25a2.63 2.63 0 1 1-5.25 0 2.63 2.63 0 0 1 5.25 0Z', 'Semua yang terdaftar'],
        ['terverifikasi', 'Terverifikasi', 's-terverifikasi', $s['terverifikasi'] - $s['bekerja'], 'bg-blue-50 text-blue-600', 'M9 12.75 11.25 15 15 9.75m-3-7.04A11.96 11.96 0 0 1 3.6 6 11.99 11.99 0 0 0 3 9.75c0 5.59 3.82 10.29 9 11.62 5.18-1.33 9-6.03 9-11.62 0-1.31-.21-2.57-.6-3.75h-.15c-3.2 0-6.1-1.25-8.25-3.29Z', 'Sudah dicek, belum bekerja'],
        ['menunggu', 'Menunggu Verifikasi', 's-menunggu', $s['menunggu'], 'bg-amber-50 text-amber-600', 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'Perlu ditinjau admin'],
        ['bekerja', 'Sudah Bekerja', 's-bekerja', $s['bekerja'], 'bg-emerald-50 text-emerald-600', 'M20.25 14.15v4.25c0 1.1-.78 2.04-1.86 2.18-2.08.28-4.21.42-6.39.42s-4.31-.14-6.39-.42c-1.08-.14-1.86-1.09-1.86-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.66V8.71c0-1.08-.77-2.01-1.84-2.17a48.4 48.4 0 0 0-3.41-.39M20.25 14.15a2.2 2.2 0 0 1-1.42.53H5.17c-.54 0-1.04-.2-1.42-.53m0 0A2.18 2.18 0 0 1 3 12.49V8.71c0-1.08.77-2.01 1.84-2.17a48.5 48.5 0 0 1 3.41-.39m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.89m7.5 0a48.7 48.7 0 0 0-7.5 0', 'Sudah ditempatkan di perusahaan'],
    ];
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    {{-- ============ JUDUL ============ --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div class="max-w-2xl">
            <nav class="flex items-center gap-2 text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600">Dashboard Admin</a>
                <span aria-hidden="true">/</span>
                <span class="text-navy-900">Pencari Kerja</span>
            </nav>
            <h1 class="mt-2 text-2xl font-extrabold text-navy-900 sm:text-3xl">Manajemen Pencari Kerja</h1>
            <p class="mt-1 text-sm leading-relaxed">Cari, saring, dan verifikasi pencari kerja penyandang tunarungu. Klik angka di bawah untuk menyaring berdasarkan status.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button type="button" id="ekspor" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Export CSV
            </button>
            <button type="button" id="buka-tambah" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
                + Tambah Pencari Kerja
            </button>
        </div>
    </div>

    {{-- ============ STATISTIK (juga berfungsi sebagai penyaring cepat) ============ --}}
    <section class="grid grid-cols-2 gap-4 xl:grid-cols-4" aria-label="Ringkasan dan penyaring cepat">
        @foreach ($kartu as [$kunci, $label, $idAngka, $nilai, $warna, $ikon, $ket])
            <button type="button" data-kartu-status="{{ $kunci }}" aria-pressed="false"
                    class="kartu-status group rounded-2xl border border-slate-100 bg-white p-5 text-left shadow-sm transition hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-teal-500/30">
                <span class="flex items-start justify-between gap-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $label }}</span>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl {{ $warna }}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}"/></svg>
                    </span>
                </span>
                <span id="{{ $idAngka }}" class="mt-2 block text-3xl font-extrabold text-navy-900">{{ number_format($nilai, 0, ',', '.') }}</span>
                <span class="mt-1 block text-xs font-semibold text-slate-500">{{ $ket }}</span>
            </button>
        @endforeach
    </section>

    {{-- ============ FILTER ============ --}}
    <form id="filter" class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:p-5" onsubmit="return false">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
            <label class="block lg:col-span-1">
                <span class="{{ $labelKecil }}">Cari spesifik</span>
                <input type="search" name="q" placeholder="Nama, email, atau ID" class="{{ $input }}">
            </label>
            <label class="block">
                <span class="{{ $labelKecil }}">Komunikasi</span>
                <select name="komunikasi" class="{{ $input }}">
                    <option value="">Semua</option>
                    @foreach ($opsi['komunikasi'] as $k)<option>{{ $k }}</option>@endforeach
                </select>
            </label>
            <label class="block">
                <span class="{{ $labelKecil }}">Status</span>
                <select name="status" class="{{ $input }}">
                    <option value="">Semua status</option>
                    @foreach ($opsi['status'] as $kunci => $teks)<option value="{{ $kunci }}">{{ $teks }}</option>@endforeach
                </select>
            </label>
            <label class="block">
                <span class="{{ $labelKecil }}">Pendidikan terakhir</span>
                <select name="pendidikan" class="{{ $input }}">
                    <option value="">Semua</option>
                    @foreach ($opsi['pendidikan'] as $p)<option>{{ $p }}</option>@endforeach
                </select>
            </label>
            <label class="block">
                <span class="{{ $labelKecil }}">Kota</span>
                <select name="kota" class="{{ $input }}">
                    <option value="">Semua kota</option>
                    @foreach ($opsi['kota'] as $k)<option>{{ $k }}</option>@endforeach
                </select>
            </label>
        </div>
        <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
            <span class="text-xs font-semibold text-slate-500">Filter aktif:</span>
            <div id="chip-aktif" class="flex flex-wrap gap-2"></div>
            <button type="button" id="atur-ulang" class="ml-auto text-xs font-semibold text-teal-600 hover:underline">Reset filter</button>
        </div>
    </form>

    {{-- ============ TABEL ============ --}}
    <section class="rounded-3xl border border-slate-100 bg-white shadow-sm">
        <div id="bar-pilih" class="hidden flex-wrap items-center gap-3 rounded-t-3xl border-b border-teal-100 bg-teal-50 px-5 py-3">
            <p class="text-sm font-semibold text-navy-900"><span id="jumlah-pilih">0</span> dipilih</p>
            <div class="ml-auto flex flex-wrap gap-2">
                <button type="button" id="verifikasi-pilih" class="rounded-lg bg-navy-900 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-teal-600">Verifikasi yang dipilih</button>
                <button type="button" id="ekspor-pilih" class="rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-bold text-navy-900 transition hover:border-navy-900">Export yang dipilih</button>
                <button type="button" id="batal-pilih" class="rounded-lg px-3.5 py-2 text-xs font-bold text-slate-600 transition hover:bg-white">Batal pilih</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[60rem] text-left text-sm">
                <caption class="sr-only">Daftar pencari kerja</caption>
                <thead class="bg-surface text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th scope="col" class="w-12 px-4 py-3"><input type="checkbox" id="pilih-semua" class="h-4 w-4 rounded border-slate-300 accent-teal-600" aria-label="Pilih semua di halaman ini"></th>
                        <th scope="col" class="px-3 py-3" data-kolom="nama" aria-sort="none"><button type="button" data-urut="nama" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-navy-900">Pencari Kerja <span data-panah aria-hidden="true"></span></button></th>
                        <th scope="col" class="px-3 py-3">Komunikasi</th>
                        <th scope="col" class="px-3 py-3">Kota & Pendidikan</th>
                        <th scope="col" class="px-3 py-3">Bidang</th>
                        <th scope="col" class="px-3 py-3" data-kolom="daftar" aria-sort="descending"><button type="button" data-urut="daftar" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-navy-900">Tgl Daftar <span data-panah aria-hidden="true"></span></button></th>
                        <th scope="col" class="px-3 py-3">Status</th>
                        <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>

        <div id="kosong" class="hidden p-10 text-center">
            <p class="font-bold text-navy-900">Tidak ada pencari kerja yang cocok</p>
            <p class="mt-1 text-sm">Coba ubah kata kunci atau reset filter.</p>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 text-xs text-slate-500">
            <p id="info"></p>
            <nav id="halaman" class="flex flex-wrap items-center gap-1.5" aria-label="Halaman"></nav>
        </div>
    </section>
</div>

{{-- ============ MODAL DETAIL ============ --}}
<div id="modal-detail" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="d-nama">
    <div class="pop-in flex max-h-[92vh] w-full max-w-lg flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-start gap-4 bg-gradient-to-br from-navy-900 to-navy-700 p-5 text-white sm:p-6">
            <span id="d-inisial" class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-white/10 text-lg font-extrabold ring-1 ring-white/20" aria-hidden="true"></span>
            <div class="min-w-0 flex-1">
                <h2 id="d-nama" tabindex="-1" class="text-lg font-extrabold leading-snug focus:outline-none"></h2>
                <p id="d-id" class="text-sm text-slate-300"></p>
                <div id="d-status" class="mt-2"></div>
            </div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-300 hover:bg-white/10 hover:text-white" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <dl id="d-isi" class="grid flex-1 gap-x-6 gap-y-4 overflow-y-auto p-5 sm:grid-cols-2 sm:p-6"></dl>
        <div class="flex flex-wrap justify-end gap-2 border-t border-slate-100 p-4">
            <button type="button" id="d-tolak" class="hidden rounded-lg border border-red-200 px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">Tolak</button>
            <button type="button" id="d-verifikasi" class="hidden rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-600">Verifikasi</button>
            <button type="button" class="modal-close rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">Tutup</button>
        </div>
    </div>
</div>

{{-- ============ MODAL TAMBAH ============ --}}
<div id="modal-tambah" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="t-judul">
    <div class="pop-in flex max-h-[92vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-5 sm:p-6">
            <div>
                <h2 id="t-judul" tabindex="-1" class="text-lg font-extrabold text-navy-900 focus:outline-none">Tambah Pencari Kerja</h2>
                <p class="text-sm">Untuk pendaftaran yang dibantu admin, misalnya lewat komunitas atau SLB.</p>
            </div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-navy-900" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="form-tambah" class="flex min-h-0 flex-1 flex-col" novalidate>
            <div class="grid flex-1 gap-4 overflow-y-auto p-5 sm:grid-cols-2 sm:p-6">
                <div class="field sm:col-span-2">
                    <label for="t-nama" class="{{ $labelKecil }}">Nama lengkap</label>
                    <input id="t-nama" name="nama" type="text" required autocomplete="off" placeholder="Nama sesuai KTP" class="{{ $input }}">
                </div>
                <div class="field">
                    <label for="t-email" class="{{ $labelKecil }}">Email</label>
                    <input id="t-email" name="email" type="email" required autocomplete="off" placeholder="nama@email.com" class="{{ $input }}">
                </div>
                <div class="field">
                    <label for="t-wa" class="{{ $labelKecil }}">No. WhatsApp</label>
                    <input id="t-wa" name="wa" type="tel" required inputmode="numeric" pattern="08[0-9]{8,12}" data-pattern-msg="Nomor diawali 08 dan berisi 10–14 angka." placeholder="08xxxxxxxxxx" class="{{ $input }}">
                </div>
                <div class="field">
                    <label for="t-kota" class="{{ $labelKecil }}">Kota</label>
                    <input id="t-kota" name="kota" type="text" required placeholder="Contoh: Bandung" class="{{ $input }}">
                </div>
                <div class="field">
                    <label for="t-pendidikan" class="{{ $labelKecil }}">Pendidikan terakhir</label>
                    <select id="t-pendidikan" name="pendidikan" required class="{{ $input }}">
                        <option value="">Pilih pendidikan</option>
                        @foreach ($opsi['pendidikan'] as $p)<option>{{ $p }}</option>@endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="t-komunikasi" class="{{ $labelKecil }}">Komunikasi utama</label>
                    <select id="t-komunikasi" name="komunikasi" required class="{{ $input }}">
                        <option value="">Pilih komunikasi</option>
                        @foreach ($opsi['komunikasi'] as $k)<option>{{ $k }}</option>@endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="t-kondisi" class="{{ $labelKecil }}">Kondisi pendengaran</label>
                    <select id="t-kondisi" name="kondisi" class="{{ $input }}">
                        <option>Tuli</option>
                        <option>Hard of Hearing</option>
                    </select>
                </div>
                <div class="field sm:col-span-2">
                    <label for="t-bidang" class="{{ $labelKecil }}">Bidang pekerjaan diminati</label>
                    <select id="t-bidang" name="bidang" class="{{ $input }}">
                        @foreach ($opsi['bidang'] as $b)<option>{{ $b }}</option>@endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 border-t border-slate-100 px-5 py-4 sm:px-6">
                <button type="button" class="modal-close rounded-lg px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Batal</button>
                <button type="submit" class="rounded-lg bg-navy-900 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-teal-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

@php $dataJson = ['pencari' => $pencari, 'statistik' => $statistik]; @endphp
<script type="application/json" id="data-pencari">@json($dataJson)</script>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { toast, openModal, checkField } = window.TunakerUI;
        const { dataAdmin, lencana, esc, inisial, tanggal, unduhCsv, STATUS } = window.TunakerAdmin;
        const $ = (id) => document.getElementById(id);
        const awal = JSON.parse($('data-pencari').textContent);
        const form = $('filter');
        const PER = 8;
        const angka = (n) => Number(n).toLocaleString('id-ID');

        let semua = [];
        let urut = { kolom: 'daftar', arah: -1 };
        let halaman = 1;
        const dipilih = new Set();

        const muat = () => {
            const ubah = dataAdmin.status();
            semua = [...dataAdmin.baru(), ...awal.pencari].map((r) => ({ ...r, status: ubah[r.id] ?? r.status }));
        };

        const tutup = (el) => el.classList.replace('grid', 'hidden');
        const beritahu = () => window.dispatchEvent(new Event('tunaker-admin-berubah'));

        /* ---------- Saring & urutkan ---------- */
        const saring = () => {
            const q = form.q.value.trim().toLowerCase();
            const cocok = semua.filter((r) =>
                (!q || [r.nama, r.id, r.email].some((t) => t.toLowerCase().includes(q)))
                && (!form.komunikasi.value || r.komunikasi === form.komunikasi.value)
                && (!form.status.value || r.status === form.status.value)
                && (!form.pendidikan.value || r.pendidikan === form.pendidikan.value)
                && (!form.kota.value || r.kota === form.kota.value));
            return cocok.sort((a, b) => urut.arah * (urut.kolom === 'nama' ? a.nama.localeCompare(b.nama, 'id') : a.daftar.localeCompare(b.daftar) || a.id.localeCompare(b.id)));
        };

        /* ---------- Tampilan ---------- */
        const barisHtml = (r) => {
            const pilih = dipilih.has(r.id);
            return `<tr data-id="${esc(r.id)}" class="transition hover:bg-surface/60 ${pilih ? 'bg-teal-50/50' : ''}">
                <td class="w-12 px-4 py-3.5"><input type="checkbox" data-pilih class="h-4 w-4 rounded border-slate-300 accent-teal-600" ${pilih ? 'checked' : ''} aria-label="Pilih ${esc(r.nama)}"></td>
                <td class="px-3 py-3.5"><div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-teal-500 to-navy-800 text-xs font-bold text-white" aria-hidden="true">${esc(inisial(r.nama))}</span>
                    <div class="min-w-0"><p class="font-bold text-navy-900">${esc(r.nama)}</p><p class="truncate text-xs text-slate-500">${esc(r.email)}</p></div></div></td>
                <td class="px-3 py-3.5"><span class="whitespace-nowrap rounded-md bg-teal-50 px-2 py-1 text-[11px] font-semibold text-teal-600">${esc(r.komunikasi)}</span><p class="mt-1 text-[11px] text-slate-500">${esc(r.kondisi)}</p></td>
                <td class="px-3 py-3.5"><p class="font-semibold text-navy-900">${esc(r.kota)}</p><p class="text-xs text-slate-500">${esc(r.pendidikan)}</p></td>
                <td class="px-3 py-3.5 text-slate-600">${esc(r.bidang)}</td>
                <td class="whitespace-nowrap px-3 py-3.5 text-slate-500">${tanggal(r.daftar)}</td>
                <td class="px-3 py-3.5">${lencana(r.status)}</td>
                <td class="px-4 py-3.5"><div class="flex justify-end gap-2">
                    <button type="button" data-aksi="detail" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-navy-900 transition hover:border-navy-900">Detail</button>
                    ${r.status === 'menunggu' ? '<button type="button" data-aksi="verifikasi" class="rounded-lg bg-navy-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-teal-600">Verifikasi</button>' : ''}
                </div></td></tr>`;
        };

        const render = (reset = false) => {
            if (reset) halaman = 1;
            const daftar = saring();
            const totalHal = Math.max(1, Math.ceil(daftar.length / PER));
            halaman = Math.min(halaman, totalHal);
            const tampil = daftar.slice((halaman - 1) * PER, halaman * PER);

            $('tabel').innerHTML = tampil.map(barisHtml).join('');
            $('kosong').classList.toggle('hidden', daftar.length > 0);
            $('info').textContent = daftar.length
                ? `Menampilkan ${(halaman - 1) * PER + 1}–${(halaman - 1) * PER + tampil.length} dari ${angka(daftar.length)} pencari kerja`
                : 'Tidak ada data';

            const nav = $('halaman');
            nav.innerHTML = '';
            const tombol = (label, ke, pilih = false, mati = false) => {
                const b = document.createElement('button');
                b.type = 'button';
                b.textContent = label;
                b.disabled = mati;
                b.className = 'grid h-9 min-w-9 place-items-center rounded-lg px-2.5 text-xs font-bold transition disabled:opacity-40 ' + (pilih ? 'bg-navy-900 text-white' : 'border border-slate-200 text-navy-900 hover:border-teal-500');
                if (pilih) b.setAttribute('aria-current', 'page');
                b.addEventListener('click', () => { halaman = ke; render(); });
                nav.appendChild(b);
            };
            if (daftar.length > PER) {
                tombol('←', halaman - 1, false, halaman === 1);
                const rentang = new Set([1, totalHal, halaman - 1, halaman, halaman + 1]);
                let terakhir = 0;
                [...rentang].filter((n) => n >= 1 && n <= totalHal).sort((a, b) => a - b).forEach((n) => {
                    if (n - terakhir > 1) nav.insertAdjacentHTML('beforeend', '<span class="px-1 text-slate-400" aria-hidden="true">…</span>');
                    tombol(n, n, n === halaman);
                    terakhir = n;
                });
                tombol('→', halaman + 1, false, halaman === totalHal);
            }

            // panah urutan
            document.querySelectorAll('[data-kolom]').forEach((th) => {
                const aktif = th.dataset.kolom === urut.kolom;
                th.setAttribute('aria-sort', aktif ? (urut.arah === 1 ? 'ascending' : 'descending') : 'none');
                th.querySelector('[data-panah]').textContent = aktif ? (urut.arah === 1 ? '↑' : '↓') : '';
            });

            renderChip();
            renderPilihan();
            renderAngka();
        };

        const renderAngka = () => {
            const hitung = (st) => semua.filter((r) => r.status === st).length;
            $('s-total').textContent = angka(semua.length);
            $('s-menunggu').textContent = angka(hitung('menunggu'));
            $('s-bekerja').textContent = angka(hitung('bekerja'));
            $('s-terverifikasi').textContent = angka(hitung('terverifikasi'));
            document.querySelectorAll('.kartu-status').forEach((k) => {
                const pilih = k.dataset.kartuStatus === form.status.value && k.dataset.kartuStatus !== '';
                k.setAttribute('aria-pressed', pilih);
                k.classList.toggle('ring-2', pilih);
                k.classList.toggle('ring-teal-500', pilih);
            });
        };

        const LABEL = { komunikasi: (v) => v, status: (v) => STATUS[v][0], pendidikan: (v) => v, kota: (v) => v };
        const renderChip = () => {
            const wadah = $('chip-aktif');
            wadah.innerHTML = '';
            Object.keys(LABEL).forEach((nama) => {
                const v = form[nama].value;
                if (!v) return;
                const chip = document.createElement('button');
                chip.type = 'button';
                chip.className = 'inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold text-white';
                chip.textContent = LABEL[nama](v) + ' ';
                chip.insertAdjacentHTML('beforeend', '<span aria-hidden="true">✕</span>');
                chip.setAttribute('aria-label', `Hapus filter ${LABEL[nama](v)}`);
                chip.addEventListener('click', () => { form[nama].value = ''; render(true); });
                wadah.appendChild(chip);
            });
            if (!wadah.children.length) wadah.innerHTML = '<span class="text-xs text-slate-400">Tidak ada</span>';
        };

        const renderPilihan = () => {
            const ids = [...$('tabel').querySelectorAll('tr[data-id]')].map((tr) => tr.dataset.id);
            $('bar-pilih').classList.toggle('hidden', dipilih.size === 0);
            $('bar-pilih').classList.toggle('flex', dipilih.size > 0);
            $('jumlah-pilih').textContent = dipilih.size;
            const semuaDipilih = ids.length > 0 && ids.every((id) => dipilih.has(id));
            const sebagian = ids.some((id) => dipilih.has(id));
            $('pilih-semua').checked = semuaDipilih;
            $('pilih-semua').indeterminate = sebagian && !semuaDipilih;
        };

        /* ---------- Aksi status ---------- */
        const setStatus = (ids, status, pesan) => {
            dataAdmin.ubahStatus(ids, status);
            muat();
            beritahu();
            render();
            toast(pesan, status === 'ditolak' ? '🚫' : '✅');
        };

        /* ---------- Detail ---------- */
        let sedangDibuka = null;
        const bukaDetail = (id) => {
            const r = semua.find((x) => x.id === id);
            if (!r) return;
            sedangDibuka = r.id;
            $('d-inisial').textContent = inisial(r.nama);
            $('d-nama').textContent = r.nama;
            $('d-id').textContent = r.id;
            $('d-status').innerHTML = lencana(r.status);
            const baris = [['Email', r.email], ['WhatsApp', r.wa], ['Kota', r.kota], ['Pendidikan', r.pendidikan], ['Kondisi pendengaran', r.kondisi],
                ['Komunikasi utama', r.komunikasi], ['Bidang diminati', r.bidang], ['Tanggal daftar', tanggal(r.daftar)], ['Tanggal mulai bekerja', tanggal(r.bekerja)]];
            $('d-isi').innerHTML = baris.map(([k, v]) => `<div><dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">${k}</dt><dd class="mt-0.5 break-words text-sm font-semibold text-navy-900">${esc(v)}</dd></div>`).join('');
            $('d-verifikasi').classList.toggle('hidden', r.status !== 'menunggu');
            $('d-tolak').classList.toggle('hidden', r.status !== 'menunggu');
            openModal('modal-detail');
            $('d-nama').focus();
        };
        $('d-verifikasi').addEventListener('click', () => { const r = semua.find((x) => x.id === sedangDibuka); tutup($('modal-detail')); setStatus(r.id, 'terverifikasi', `${r.nama} sudah diverifikasi.`); });
        $('d-tolak').addEventListener('click', () => { const r = semua.find((x) => x.id === sedangDibuka); tutup($('modal-detail')); setStatus(r.id, 'ditolak', `Pendaftaran ${r.nama} ditolak.`); });

        /* ---------- Tabel: klik & pilih ---------- */
        $('tabel').addEventListener('click', (e) => {
            const baris = e.target.closest('tr[data-id]');
            if (!baris) return;
            const id = baris.dataset.id;
            const aksi = e.target.closest('[data-aksi]')?.dataset.aksi;
            if (aksi === 'detail') bukaDetail(id);
            if (aksi === 'verifikasi') { const r = semua.find((x) => x.id === id); setStatus(id, 'terverifikasi', `${r.nama} sudah diverifikasi.`); }
        });
        $('tabel').addEventListener('change', (e) => {
            if (!e.target.matches('[data-pilih]')) return;
            const baris = e.target.closest('tr');
            e.target.checked ? dipilih.add(baris.dataset.id) : dipilih.delete(baris.dataset.id);
            baris.classList.toggle('bg-teal-50/50', e.target.checked);
            renderPilihan();
        });
        $('pilih-semua').addEventListener('change', (e) => {
            $('tabel').querySelectorAll('tr[data-id]').forEach((tr) => {
                e.target.checked ? dipilih.add(tr.dataset.id) : dipilih.delete(tr.dataset.id);
                tr.querySelector('[data-pilih]').checked = e.target.checked;
                tr.classList.toggle('bg-teal-50/50', e.target.checked);
            });
            renderPilihan();
        });
        $('batal-pilih').addEventListener('click', () => { dipilih.clear(); render(); });
        $('verifikasi-pilih').addEventListener('click', () => {
            const ids = semua.filter((r) => dipilih.has(r.id) && r.status === 'menunggu').map((r) => r.id);
            if (!ids.length) { toast('Tidak ada yang menunggu verifikasi di antara pilihan.', 'ℹ️'); return; }
            dipilih.clear();
            setStatus(ids, 'terverifikasi', `${ids.length} pencari kerja sudah diverifikasi.`);
        });

        /* ---------- Urut, filter, reset ---------- */
        document.querySelectorAll('[data-urut]').forEach((b) => b.addEventListener('click', () => {
            urut = { kolom: b.dataset.urut, arah: urut.kolom === b.dataset.urut ? -urut.arah : (b.dataset.urut === 'nama' ? 1 : -1) };
            render(true);
        }));
        let tunda;
        form.q.addEventListener('input', () => { clearTimeout(tunda); tunda = setTimeout(() => render(true), 200); });
        form.addEventListener('change', () => render(true));
        $('atur-ulang').addEventListener('click', () => { form.reset(); render(true); });
        document.querySelectorAll('.kartu-status').forEach((k) => k.addEventListener('click', () => {
            const st = k.dataset.kartuStatus;
            form.status.value = form.status.value === st ? '' : st;
            render(true);
        }));

        /* ---------- Export CSV ---------- */
        const kolomCsv = ['ID', 'Nama', 'Email', 'WhatsApp', 'Kota', 'Pendidikan', 'Komunikasi', 'Kondisi pendengaran', 'Bidang', 'Status', 'Tanggal daftar', 'Tanggal bekerja'];
        const ekspor = (daftar, nama) => {
            if (!daftar.length) { toast('Tidak ada data untuk diexport.', 'ℹ️'); return; }
            unduhCsv(`${nama}-${new Date().toLocaleDateString('sv-SE')}.csv`, [kolomCsv, ...daftar.map((r) =>
                [r.id, r.nama, r.email, r.wa, r.kota, r.pendidikan, r.komunikasi, r.kondisi, r.bidang, STATUS[r.status][0], r.daftar, r.bekerja ?? ''])]);
            toast(`${angka(daftar.length)} data diexport sebagai CSV.`, '⬇️');
        };
        $('ekspor').addEventListener('click', () => ekspor(saring(), 'pencari-kerja'));
        $('ekspor-pilih').addEventListener('click', () => ekspor(semua.filter((r) => dipilih.has(r.id)), 'pencari-kerja-pilihan'));

        /* ---------- Tambah ---------- */
        const formTambah = $('form-tambah');
        $('buka-tambah').addEventListener('click', () => {
            formTambah.reset();
            formTambah.querySelectorAll('.field.is-invalid').forEach((f) => f.classList.remove('is-invalid'));
            formTambah.querySelectorAll('.field-error').forEach((p) => p.classList.add('hidden'));
            openModal('modal-tambah');
            $('t-judul').focus();
        });
        formTambah.addEventListener('change', (e) => { if (e.target.closest('.field.is-invalid')) checkField(e.target); });
        formTambah.addEventListener('input', (e) => { if (e.target.closest('.field.is-invalid')) checkField(e.target); });
        formTambah.addEventListener('submit', (e) => {
            e.preventDefault();
            const salah = [...formTambah.querySelectorAll('[required]')].filter((el) => !checkField(el));
            if (salah.length) { salah[0].focus(); return; }

            const fd = Object.fromEntries(new FormData(formTambah));
            const nomorTerbesar = Math.max(0, ...semua.map((r) => Number(r.id.split('-').pop()) || 0));
            const tahun = new Date().getFullYear();
            // TODO: kirim ke backend (POST /admin/pencari-kerja) setelah database tersedia
            dataAdmin.tambahBaru({
                id: `TNK-${tahun}-${String(nomorTerbesar + 1).padStart(4, '0')}`, nama: fd.nama.trim(), email: fd.email.trim(), wa: fd.wa.trim(), kota: fd.kota.trim(),
                pendidikan: fd.pendidikan, komunikasi: fd.komunikasi, kondisi: fd.kondisi, bidang: fd.bidang, status: 'menunggu',
                daftar: new Date().toLocaleDateString('sv-SE'), bekerja: null,
            });
            muat();
            tutup($('modal-tambah'));
            urut = { kolom: 'daftar', arah: -1 };
            beritahu();
            render(true);
            toast(`${fd.nama.trim()} ditambahkan dan menunggu verifikasi.`, '✅');
        });

        /* ---------- Mulai ---------- */
        muat();
        const param = new URLSearchParams(location.search);
        if (param.get('q')) form.q.value = param.get('q');
        if (STATUS[param.get('status')]) form.status.value = param.get('status');
        render(true);
    })();
</script>
@endpush
