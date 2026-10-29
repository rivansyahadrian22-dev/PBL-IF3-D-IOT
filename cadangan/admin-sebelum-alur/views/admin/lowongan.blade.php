@extends('admin.layouts.app')

@section('title', 'Lowongan Kerja')

@php
    $akses = config('tunaker.akses');
    $statusLowongan = \App\Support\Admin\ContohOperasional::STATUS_LOWONGAN;
    $tipeKerja = ['Full Time', 'Part Time', 'Remote', 'Hybrid', 'Magang'];

    $koleksi = collect($rows);
    $sektor = $koleksi->pluck('sektor')->unique()->sort()->values();
    $perusahaanAktif = collect($perusahaan)->where('status', 'aktif')->sortBy('nama')->values();

    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $labelKecil = 'mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500';
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-admin.judul judul="Manajemen Lowongan Kerja" crumb="Lowongan Kerja" :induk="[['Mitra', 'admin.perusahaan']]" lencana="Ramah Tuli"
                   deskripsi="Kelola lowongan dari perusahaan mitra, tinjau akomodasi untuk teman Tuli, dan pantau jumlah pelamar tiap lowongan.">
        <button type="button" id="ekspor" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">
            <x-admin.ikon nama="unduh" class="h-4 w-4" tebal="2" /> Export Lowongan
        </button>
        <button type="button" id="buka-tambah" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
            + Buat Lowongan Baru
        </button>
    </x-admin.judul>

    <x-admin.tab :item="[['Perusahaan', 'admin.perusahaan'], ['Lowongan Kerja', 'admin.lowongan']]" />

    {{-- ============ STATISTIK ============ --}}
    <section class="grid grid-cols-2 gap-4 xl:grid-cols-4" aria-label="Ringkasan lowongan">
        <x-admin.kartu label="Total Lowongan" :nilai="$koleksi->count()" id="s-total" ket="Semua status" ikon="lowongan" />
        <x-admin.kartu label="Perusahaan Mitra" :nilai="$koleksi->pluck('perusahaan')->unique()->count()" id="s-perusahaan" ket="Punya lowongan terdaftar" ikon="perusahaan" warna="bg-blue-50 text-blue-600" />
        <x-admin.kartu label="Total Pelamar" :nilai="number_format($koleksi->sum('pelamar'), 0, ',', '.')" id="s-pelamar" ket="Dari seluruh lowongan" ikon="pengguna" warna="bg-teal-50 text-teal-600" />
        <x-admin.kartu tag="button" data-kartu-status="review" aria-pressed="false" label="Perlu Review" :nilai="$koleksi->where('status', 'review')->count()" id="s-review" ket="Akomodasi belum dicek, klik untuk menyaring" ikon="peringatan" warna="bg-amber-100 text-amber-700" ton="peringatan" class="kartu-status w-full" />
    </section>

    {{-- ============ FILTER ============ --}}
    <form id="filter" class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:p-5" onsubmit="return false">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
            <label class="block"><span class="{{ $labelKecil }}">Cari lowongan</span><input type="search" name="q" placeholder="Posisi atau perusahaan" class="{{ $input }}"></label>
            <label class="block"><span class="{{ $labelKecil }}">Status</span>
                <select name="status" class="{{ $input }}"><option value="">Semua status</option>@foreach ($statusLowongan as $k => $t)<option value="{{ $k }}">{{ $t }}</option>@endforeach</select></label>
            <label class="block"><span class="{{ $labelKecil }}">Tipe kerja</span>
                <select name="tipe" class="{{ $input }}"><option value="">Semua tipe</option>@foreach ($tipeKerja as $t)<option>{{ $t }}</option>@endforeach</select></label>
            <label class="block"><span class="{{ $labelKecil }}">Sektor</span>
                <select name="sektor" class="{{ $input }}"><option value="">Semua sektor</option>@foreach ($sektor as $t)<option>{{ $t }}</option>@endforeach</select></label>
            <label class="block"><span class="{{ $labelKecil }}">Fasilitas ramah Tuli</span>
                <select name="akses" class="{{ $input }}"><option value="">Semua fasilitas</option>@foreach ($akses as $k => $t)<option value="{{ $k }}">{{ $t }}</option>@endforeach</select></label>
        </div>
        <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
            <span class="text-xs font-semibold text-slate-500">Filter aktif:</span>
            <div id="chip-aktif" class="flex flex-wrap gap-2"></div>
            <button type="button" id="atur-ulang" class="ml-auto text-xs font-semibold text-teal-600 hover:underline">Reset filter</button>
        </div>
    </form>

    {{-- ============ DAFTAR ============ --}}
    <section aria-label="Daftar lowongan">
        <div id="daftar" class="space-y-3"></div>
        <div id="kosong" class="hidden rounded-2xl border border-dashed border-slate-200 bg-white p-10 text-center">
            <p class="font-bold text-navy-900">Tidak ada lowongan yang cocok</p>
            <p class="mt-1 text-sm">Coba ubah kata kunci atau reset filter.</p>
        </div>
        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500">
            <p id="info"></p>
            <nav id="halaman" class="flex flex-wrap items-center gap-1.5" aria-label="Halaman"></nav>
        </div>
    </section>
</div>

{{-- ============ MODAL BUAT LOWONGAN ============ --}}
<div id="modal-tambah" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="t-judul">
    <div class="pop-in flex max-h-[92vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-5 sm:p-6">
            <div>
                <h2 id="t-judul" class="text-lg font-extrabold text-navy-900">Buat Lowongan Baru</h2>
                <p class="text-sm">Lowongan baru masuk dengan status <b>Perlu Review</b> sampai akomodasinya dicek.</p>
            </div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-navy-900" aria-label="Tutup"><x-admin.ikon nama="tambah" class="h-5 w-5 rotate-45" tebal="2" /></button>
        </div>
        <form id="form-tambah" class="flex min-h-0 flex-1 flex-col" novalidate>
            <div class="grid flex-1 gap-4 overflow-y-auto p-5 sm:grid-cols-2 sm:p-6">
                <div class="field sm:col-span-2"><label for="t-posisi" class="{{ $labelKecil }}">Nama posisi</label>
                    <input id="t-posisi" name="posisi" type="text" required placeholder="Contoh: Staff Administrasi" class="{{ $input }}"></div>
                <div class="field sm:col-span-2"><label for="t-perusahaan" class="{{ $labelKecil }}">Perusahaan</label>
                    <select id="t-perusahaan" name="perusahaan" required class="{{ $input }}"><option value="">Pilih perusahaan</option>@foreach ($perusahaanAktif as $p)<option>{{ $p['nama'] }}</option>@endforeach</select></div>
                <div class="field"><label for="t-tipe" class="{{ $labelKecil }}">Tipe kerja</label>
                    <select id="t-tipe" name="tipe" class="{{ $input }}">@foreach ($tipeKerja as $t)<option>{{ $t }}</option>@endforeach</select></div>
                <div class="field"><label for="t-kuota" class="{{ $labelKecil }}">Kuota</label>
                    <input id="t-kuota" name="kuota" type="number" min="1" max="99" required value="1" class="{{ $input }}"></div>
                <div class="field sm:col-span-2"><label for="t-lokasi" class="{{ $labelKecil }}">Lokasi</label>
                    <input id="t-lokasi" name="lokasi" type="text" required placeholder="Contoh: Bandung atau Remote" class="{{ $input }}"></div>
                <fieldset class="sm:col-span-2">
                    <legend class="{{ $labelKecil }}">Akomodasi yang disiapkan</legend>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($akses as $k => $t)
                            <label><input type="checkbox" name="akses" value="{{ $k }}" class="peer sr-only"><span class="chip inline-block cursor-pointer rounded-full border border-slate-200 px-3.5 py-2 text-xs font-semibold transition hover:border-teal-500 peer-checked:border-navy-900 peer-checked:bg-navy-900 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15">{{ $t }}</span></label>
                        @endforeach
                    </div>
                </fieldset>
            </div>
            <div class="flex justify-end gap-3 border-t border-slate-100 px-5 py-4 sm:px-6">
                <button type="button" class="modal-close rounded-lg px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Batal</button>
                <button type="submit" class="rounded-lg bg-navy-900 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-teal-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

@php
    $dataJson = [
        'rows' => $rows,
        'akses' => $akses,
        'status' => $statusLowongan,
        'sektorPerusahaan' => collect($perusahaan)->pluck('sektor', 'nama')->all(),
        'urlPelamar' => url('/lowongan'),
        'urlLamaran' => route('admin.lamaran'),
    ];
@endphp
<script type="application/json" id="data-halaman">@json($dataJson)</script>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { buatDaftar, simpanan, badge, esc, angka, tanggal, inisial, bukaDetail, formModal, unduhCsv, hariIni, tutup, beritahu } = window.TunakerAdmin;
        const { toast } = window.TunakerUI;
        const $ = (id) => document.getElementById(id);
        const awal = JSON.parse($('data-halaman').textContent);
        const simpan = simpanan('tunaker_admin_lowongan');
        const NADA = { aktif: 'hijau', review: 'amber', ditutup: 'abu', draft: 'biru' };
        const GRADASI = ['from-teal-500 to-emerald-600', 'from-blue-500 to-indigo-600', 'from-pink-500 to-rose-600', 'from-amber-400 to-orange-500', 'from-violet-500 to-purple-600', 'from-sky-500 to-cyan-600'];
        let rows = simpan.gabung(awal.rows);

        const warna = (teks) => GRADASI[[...teks].reduce((a, c) => a + c.charCodeAt(0), 0) % GRADASI.length];
        const gaji = (g) => `Rp ${String(g[0]).replace('.', ',')} – ${String(g[1]).replace('.', ',')} jt`;
        const labelAkses = (l) => l.akses.map((a) => awal.akses[a]).join(', ') || '-';

        const baris = (l) => {
            const review = l.status === 'review';
            const chips = l.akses.slice(0, 3).map((a) => `<span class="rounded-md bg-teal-50 px-2 py-1 text-[11px] font-semibold text-teal-600">${esc(awal.akses[a])}</span>`).join('');
            const opsi = Object.entries(awal.status).map(([k, t]) => `<option value="${k}" ${k === l.status ? 'selected' : ''}>${t}</option>`).join('');
            return `<article data-id="${l.id}" class="flex flex-wrap items-center gap-4 rounded-2xl border p-4 shadow-sm transition hover:shadow-md ${review ? 'border-amber-300 bg-amber-50/60' : 'border-slate-100 bg-white'}">
                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-gradient-to-br ${warna(l.sektor)} text-sm font-extrabold text-white" aria-hidden="true">${esc(inisial(l.perusahaan.replace(/^(PT|CV)\s+/, '')))}</span>
                <div class="min-w-0 flex-1 basis-64">
                    <div class="flex flex-wrap items-center gap-2"><h2 class="font-extrabold text-navy-900">${esc(l.posisi)}</h2>${badge(l.tipe, 'biru')}</div>
                    <p class="text-sm text-slate-500">${esc(l.perusahaan)} · ${esc(l.lokasi)} · ${esc(l.sektor)}</p>
                    <div class="mt-2 flex flex-wrap items-center gap-1.5">${chips}${review ? badge('Menunggu review akomodasi', 'amber') : ''}</div>
                </div>
                <a href="${awal.urlLamaran}?lowongan=${encodeURIComponent(l.id)}" class="rounded-xl px-3 py-1 text-center transition hover:bg-surface focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-teal-500/30" title="Lihat ${l.pelamar} lamaran untuk lowongan ini">
                    <span class="block text-2xl font-extrabold text-navy-900">${angka(l.pelamar)}</span>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Pelamar</span>
                    <span class="block text-[11px] font-semibold text-teal-600">${angka(l.siapVerifikasi)} siap diverifikasi →</span>
                </a>
                <div class="flex flex-wrap items-center gap-2">
                    <select data-status aria-label="Status ${esc(l.posisi)}" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-navy-900 focus:border-teal-500 focus:outline-none">${opsi}</select>
                    <button type="button" data-detail class="rounded-lg border border-slate-200 px-3.5 py-2 text-xs font-semibold text-navy-900 transition hover:border-navy-900">Lihat Detail</button>
                    ${review ? '<button type="button" data-setujui class="rounded-lg bg-navy-900 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-teal-600">Setujui</button>' : ''}
                </div></article>`;
        };

        const daftar = buatDaftar({
            form: $('filter'), rows: () => rows, wadah: $('daftar'), info: $('info'), nav: $('halaman'), kosong: $('kosong'),
            chipEl: $('chip-aktif'), reset: $('atur-ulang'), perHalaman: 6, satuan: 'lowongan', baris,
            urut: { kolom: 'baru', arah: -1 },
            pembanding: { baru: (a, b) => a.dibuat.localeCompare(b.dibuat) || a.id.localeCompare(b.id) },
            saring: (l, v) => (!v.q || `${l.posisi} ${l.perusahaan}`.toLowerCase().includes(v.q.trim().toLowerCase()))
                && (!v.status || l.status === v.status) && (!v.tipe || l.tipe === v.tipe) && (!v.sektor || l.sektor === v.sektor) && (!v.akses || l.akses.includes(v.akses)),
            chip: { status: (v) => awal.status[v], tipe: (v) => v, sektor: (v) => v, akses: (v) => awal.akses[v] },
            setelah: () => {
                $('s-total').textContent = angka(rows.length);
                $('s-perusahaan').textContent = angka(new Set(rows.map((l) => l.perusahaan)).size);
                $('s-pelamar').textContent = angka(rows.reduce((a, l) => a + l.pelamar, 0));
                $('s-review').textContent = angka(rows.filter((l) => l.status === 'review').length);
            },
        });

        const ubahStatus = (id, status, pesan) => {
            simpan.ubah(id, { status });
            rows = simpan.gabung(awal.rows);
            beritahu();
            daftar.render();
            toast(pesan, '✅');
        };

        const detail = (l) => bukaDetail({
            inisial: inisial(l.perusahaan.replace(/^(PT|CV)\s+/, '')), judul: l.posisi, sub: l.perusahaan, lencana: [badge(awal.status[l.status], NADA[l.status]), badge(l.tipe, 'biru')],
            pasangan: [['ID lowongan', l.id], ['Sektor', l.sektor], ['Lokasi', l.lokasi], ['Kuota', `${l.kuota} orang`], ['Pelamar', angka(l.pelamar)], ['Siap diverifikasi', angka(l.siapVerifikasi)],
                ['Estimasi gaji', `${gaji(l.gaji)} / bulan`], ['Dibuat', tanggal(l.dibuat)], ['Batas lamar', tanggal(l.batas)], ['Akomodasi', labelAkses(l)]],
            aksi: [
                ...(l.slug ? [{ teks: 'Lihat di sisi pelamar', gaya: 'netral', klik: () => window.open(`${awal.urlPelamar}/${l.slug}`, '_blank') }] : []),
                ...(l.status === 'review' ? [{ teks: 'Setujui & Aktifkan', klik: () => ubahStatus(l.id, 'aktif', `${l.posisi} disetujui dan aktif.`) }] : []),
                ...(l.status === 'aktif' ? [{ teks: 'Tutup Lowongan', gaya: 'bahaya', klik: () => ubahStatus(l.id, 'ditutup', `${l.posisi} ditutup.`) }] : []),
                ...(['ditutup', 'draft'].includes(l.status) ? [{ teks: 'Aktifkan Lagi', klik: () => ubahStatus(l.id, 'aktif', `${l.posisi} diaktifkan.`) }] : []),
            ],
        });

        $('daftar').addEventListener('click', (e) => {
            const id = e.target.closest('article[data-id]')?.dataset.id;
            const l = rows.find((x) => x.id === id);
            if (!l) return;
            if (e.target.closest('[data-detail]')) detail(l);
            if (e.target.closest('[data-setujui]')) ubahStatus(l.id, 'aktif', `${l.posisi} disetujui dan aktif.`);
        });
        $('daftar').addEventListener('change', (e) => {
            if (!e.target.matches('[data-status]')) return;
            const l = rows.find((x) => x.id === e.target.closest('article').dataset.id);
            ubahStatus(l.id, e.target.value, `Status ${l.posisi}: ${awal.status[e.target.value]}.`);
        });

        document.querySelector('.kartu-status').addEventListener('click', () => {
            const f = $('filter').elements.status;
            f.value = f.value === 'review' ? '' : 'review';
            daftar.render(true);
        });

        $('ekspor').addEventListener('click', () => {
            const data = daftar.hasil();
            if (!data.length) { toast('Tidak ada data untuk diexport.', 'ℹ️'); return; }
            unduhCsv(`lowongan-${hariIni()}.csv`, [['ID', 'Posisi', 'Perusahaan', 'Sektor', 'Lokasi', 'Tipe', 'Kuota', 'Pelamar', 'Status', 'Akomodasi', 'Dibuat', 'Batas lamar'],
                ...data.map((l) => [l.id, l.posisi, l.perusahaan, l.sektor, l.lokasi, l.tipe, l.kuota, l.pelamar, awal.status[l.status], labelAkses(l), l.dibuat, l.batas])]);
            toast(`${angka(data.length)} lowongan diexport sebagai CSV.`, '⬇️');
        });

        formModal({
            modal: 'modal-tambah', form: 'form-tambah', buka: 'buka-tambah',
            kirim: (d, tutupModal) => {
                const terbesar = Math.max(0, ...rows.map((l) => Number(l.id.split('-').pop())));
                // TODO: kirim ke backend (POST /admin/lowongan-kerja) setelah database tersedia
                simpan.tambah({
                    id: `LWG-${String(terbesar + 1).padStart(4, '0')}`, slug: null, posisi: d.posisi.trim(), perusahaan: d.perusahaan, perusahaanId: null,
                    sektor: awal.sektorPerusahaan[d.perusahaan] ?? 'Lainnya', lokasi: d.lokasi.trim(), tipe: d.tipe, kuota: Number(d.kuota),
                    akses: new FormData($('form-tambah')).getAll('akses'), gaji: [4, 6], dibuat: hariIni(), batas: '', status: 'review', pelamar: 0, siapVerifikasi: 0,
                });
                rows = simpan.gabung(awal.rows);
                tutupModal();
                beritahu();
                daftar.render(true);
                toast(`${d.posisi.trim()} dibuat dan menunggu review.`, '✅');
            },
        });

        const param = new URLSearchParams(location.search);
        if (param.get('q')) $('filter').elements.q.value = param.get('q');
        if (param.get('status')) $('filter').elements.status.value = param.get('status');
        daftar.render(true);
    })();
</script>
@endpush
