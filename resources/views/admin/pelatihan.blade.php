@extends('admin.layouts.app')

@section('title', 'Pelatihan & Sertifikasi')

@php
    $koleksi = collect($rows);
    $kategori = $koleksi->pluck('kategori')->unique()->sort()->values();
    $dukungan = ['BISINDO penuh + subtitle', 'BISINDO penuh', 'Juru bahasa sesi live', 'Video BISINDO + teks', 'Subtitle lengkap', 'Teks dan contoh email'];
    $lulus = $koleksi->whereNotNull('lulus');

    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $labelKecil = 'mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500';

    $tab = ['semua' => 'Semua Program', 'berjalan' => 'Sedang Berjalan', 'dibuka' => 'Pendaftaran Dibuka', 'selesai' => 'Selesai', 'draft' => 'Draft', 'update' => 'Perlu Update Bahasa Isyarat'];
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-admin.judul judul="Manajemen Program Pelatihan & Sertifikasi" crumb="Pelatihan & Sertifikasi"
                   deskripsi="Kelola program pelatihan, kuota peserta, dan sertifikasi. Pastikan setiap materi punya dukungan bahasa isyarat atau subtitle.">
        <button type="button" id="ekspor" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">
            <x-admin.ikon nama="unduh" class="h-4 w-4" tebal="2" /> Unduh Laporan
        </button>
        <button type="button" id="buka-tambah" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
            + Tambah Modul / Batch Baru
        </button>
    </x-admin.judul>

    <section class="grid grid-cols-2 gap-4 xl:grid-cols-4" aria-label="Ringkasan pelatihan">
        <x-admin.kartu label="Peserta Aktif" :nilai="$koleksi->where('status', 'berjalan')->sum('terisi')" id="s-peserta" ket="Di batch yang sedang berjalan" ikon="pengguna" />
        <x-admin.kartu label="Program Berjalan" :nilai="$koleksi->where('status', 'berjalan')->count()" id="s-berjalan" ket="Batch sedang berlangsung" ikon="pelatihan" warna="bg-blue-50 text-blue-600" />
        <x-admin.kartu label="Pendaftaran Dibuka" :nilai="$koleksi->where('status', 'dibuka')->count()" id="s-dibuka" ket="Batch menerima peserta" ikon="tambah" warna="bg-teal-50 text-teal-600" />
        <x-admin.kartu label="Tingkat Kelulusan" :nilai="$lulus->count() ? round($lulus->avg('lulus'), 1) . '%' : '-'" id="s-lulus" ket="Rata-rata batch yang sudah selesai" ikon="centang" warna="bg-emerald-50 text-emerald-600" />
    </section>

    <form id="filter" class="space-y-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:p-5" onsubmit="return false">
        <input type="hidden" name="tab" value="semua">
        <div class="flex gap-2 overflow-x-auto pb-1" role="tablist" aria-label="Status program">
            @foreach ($tab as $kunci => $teks)
                <button type="button" role="tab" data-tab="{{ $kunci }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        class="tab-btn shrink-0 rounded-full border px-4 py-2 text-xs font-semibold transition {{ $loop->first ? 'border-navy-900 bg-navy-900 text-white' : 'border-slate-200 text-slate-600 hover:border-teal-500' }}">
                    {{ $teks }} <span class="opacity-70" data-hitung="{{ $kunci }}"></span>
                </button>
            @endforeach
        </div>
        <div class="grid gap-3 sm:grid-cols-3">
            <label class="block"><span class="{{ $labelKecil }}">Cari program</span><input type="search" name="q" placeholder="Judul atau instruktur" class="{{ $input }}"></label>
            <label class="block"><span class="{{ $labelKecil }}">Kategori</span>
                <select name="kategori" class="{{ $input }}"><option value="">Semua kategori</option>@foreach ($kategori as $k)<option>{{ $k }}</option>@endforeach</select></label>
            <label class="block"><span class="{{ $labelKecil }}">Sertifikasi</span>
                <select name="sertifikasi" class="{{ $input }}"><option value="">Semua</option>@foreach (['BNSP', 'Kemnaker', 'Internal'] as $k)<option>{{ $k }}</option>@endforeach</select></label>
        </div>
        <div class="flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
            <span class="text-xs font-semibold text-slate-500">Filter aktif:</span>
            <div id="chip-aktif" class="flex flex-wrap gap-2"></div>
            <button type="button" id="atur-ulang" class="ml-auto text-xs font-semibold text-teal-600 hover:underline">Reset filter</button>
        </div>
    </form>

    <section aria-label="Daftar program">
        <div id="daftar" class="grid gap-5 md:grid-cols-2 xl:grid-cols-3"></div>
        <div id="kosong" class="hidden rounded-2xl border border-dashed border-slate-200 bg-white p-10 text-center">
            <p class="font-bold text-navy-900">Tidak ada program yang cocok</p>
            <p class="mt-1 text-sm">Coba pilih tab lain atau reset filter.</p>
        </div>
        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500">
            <p id="info"></p>
            <nav id="halaman" class="flex flex-wrap items-center gap-1.5" aria-label="Halaman"></nav>
        </div>
    </section>
</div>

{{-- ============ MODAL TAMBAH ============ --}}
<div id="modal-tambah" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="t-judul">
    <div class="pop-in flex max-h-[92vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-5 sm:p-6">
            <div><h2 id="t-judul" class="text-lg font-extrabold text-navy-900">Tambah Modul / Batch Baru</h2><p class="text-sm">Batch baru langsung membuka pendaftaran.</p></div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-navy-900" aria-label="Tutup"><x-admin.ikon nama="tambah" class="h-5 w-5 rotate-45" tebal="2" /></button>
        </div>
        <form id="form-tambah" class="flex min-h-0 flex-1 flex-col" novalidate>
            <div class="grid flex-1 gap-4 overflow-y-auto p-5 sm:grid-cols-2 sm:p-6">
                <div class="field sm:col-span-2"><label for="t-judul-program" class="{{ $labelKecil }}">Judul program</label>
                    <input id="t-judul-program" name="judul" type="text" required placeholder="Contoh: Desain Grafis untuk Pemula" class="{{ $input }}"></div>
                <div class="field"><label for="t-kategori" class="{{ $labelKecil }}">Kategori</label>
                    <select id="t-kategori" name="kategori" class="{{ $input }}">@foreach ($kategori as $k)<option>{{ $k }}</option>@endforeach</select></div>
                <div class="field"><label for="t-instruktur" class="{{ $labelKecil }}">Instruktur</label>
                    <input id="t-instruktur" name="instruktur" type="text" required placeholder="Nama instruktur" class="{{ $input }}"></div>
                <div class="field"><label for="t-kuota" class="{{ $labelKecil }}">Kuota peserta</label>
                    <input id="t-kuota" name="kuota" type="number" min="1" max="500" required value="25" class="{{ $input }}"></div>
                <div class="field"><label for="t-mulai" class="{{ $labelKecil }}">Tanggal mulai</label>
                    <input id="t-mulai" name="mulai" type="date" required class="{{ $input }}"></div>
                <div class="field"><label for="t-minggu" class="{{ $labelKecil }}">Durasi (minggu)</label>
                    <input id="t-minggu" name="minggu" type="number" min="1" max="52" value="4" required class="{{ $input }}"></div>
                <div class="field"><label for="t-lokasi" class="{{ $labelKecil }}">Lokasi</label>
                    <select id="t-lokasi" name="lokasi" class="{{ $input }}"><option>Online</option><option>Hybrid</option><option>Onsite</option></select></div>
                <div class="field"><label for="t-bahasa" class="{{ $labelKecil }}">Dukungan bahasa</label>
                    <select id="t-bahasa" name="bahasa" class="{{ $input }}">@foreach ($dukungan as $d)<option>{{ $d }}</option>@endforeach</select></div>
                <div class="field"><label for="t-sertifikasi" class="{{ $labelKecil }}">Sertifikasi</label>
                    <select id="t-sertifikasi" name="sertifikasi" class="{{ $input }}"><option>BNSP</option><option>Kemnaker</option><option>Internal</option></select></div>
                <label class="chip flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3.5 text-sm sm:col-span-2">
                    <input type="checkbox" name="tuli" value="1" class="h-4 w-4 rounded border-slate-300 accent-teal-600"> Instruktur adalah teman Tuli
                </label>
            </div>
            <div class="flex justify-end gap-3 border-t border-slate-100 px-5 py-4 sm:px-6">
                <button type="button" class="modal-close rounded-lg px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Batal</button>
                <button type="submit" class="rounded-lg bg-navy-900 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-teal-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

@php $dataJson = ['rows' => $rows]; @endphp
<script type="application/json" id="data-halaman">@json($dataJson)</script>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { buatDaftar, simpanan, badge, esc, angka, tanggal, inisial, bukaDetail, formModal, unduhCsv, hariIni, beritahu } = window.TunakerAdmin;
        const { toast } = window.TunakerUI;
        const $ = (id) => document.getElementById(id);
        const awal = JSON.parse($('data-halaman').textContent);
        const simpan = simpanan('tunaker_admin_pelatihan');
        const STATUS = { draft: ['Draft', 'abu'], dibuka: ['Pendaftaran Dibuka', 'teal'], berjalan: ['Sedang Berjalan', 'biru'], selesai: ['Selesai', 'hijau'] };
        const LANGKAH = { draft: ['Buka Pendaftaran', 'dibuka'], dibuka: ['Mulai Batch', 'berjalan'], berjalan: ['Tandai Selesai', 'selesai'] };
        let rows = simpan.gabung(awal.rows);
        let tab = 'semua';

        const kartu = (p) => {
            const persen = p.kuota ? Math.round(p.terisi / p.kuota * 100) : 0;
            const [labelStatus, nadaStatus] = STATUS[p.status];
            const langkah = LANGKAH[p.status];
            return `<article data-id="${p.id}" class="flex flex-col rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="flex flex-wrap items-center gap-2">${badge(p.kategori, 'ungu')}${badge(labelStatus, nadaStatus)}${p.perluUpdate ? badge('Perlu update bahasa isyarat', 'amber') : ''}</div>
                <h2 class="mt-3 font-extrabold leading-snug text-navy-900">${esc(p.judul)}</h2>
                <div class="mt-3 flex items-center gap-3">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-gradient-to-br from-teal-500 to-navy-800 text-xs font-bold text-white" aria-hidden="true">${esc(inisial(p.instruktur))}</span>
                    <div class="min-w-0"><p class="truncate text-sm font-bold text-navy-900">${esc(p.instruktur)}</p><p class="text-xs text-slate-500">${p.instrukturTuli ? 'Instruktur Tuli' : 'Instruktur'} · ${esc(p.lokasi)}</p></div>
                </div>
                <p class="mt-3 rounded-lg bg-teal-50 px-3 py-2 text-xs font-semibold text-teal-700">Dukungan: ${esc(p.bahasa)}</p>
                <div class="mt-4">
                    <div class="flex justify-between text-xs font-semibold"><span class="text-slate-500">Peserta</span><span class="text-navy-900">${p.terisi}/${p.kuota}</span></div>
                    <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-slate-100" role="progressbar" aria-valuenow="${persen}" aria-valuemin="0" aria-valuemax="100" aria-label="Terisi ${persen} persen">
                        <div class="h-full rounded-full ${persen >= 100 ? 'bg-amber-500' : 'bg-gradient-to-r from-teal-500 to-navy-800'}" style="width:${Math.min(persen, 100)}%"></div></div>
                </div>
                <dl class="mt-4 grid grid-cols-2 gap-3 text-xs">
                    <div><dt class="font-bold uppercase tracking-wider text-slate-400">Mulai</dt><dd class="mt-0.5 font-semibold text-navy-900">${tanggal(p.mulai)}</dd></div>
                    <div><dt class="font-bold uppercase tracking-wider text-slate-400">Selesai</dt><dd class="mt-0.5 font-semibold text-navy-900">${tanggal(p.selesai)}</dd></div>
                    <div><dt class="font-bold uppercase tracking-wider text-slate-400">Sertifikasi</dt><dd class="mt-0.5 font-semibold text-navy-900">${esc(p.sertifikasi)}</dd></div>
                    <div><dt class="font-bold uppercase tracking-wider text-slate-400">Kelulusan</dt><dd class="mt-0.5 font-semibold text-navy-900">${p.lulus != null ? p.lulus + '%' : (p.status === 'selesai' ? 'Menunggu penilaian' : '-')}</dd></div>
                </dl>
                <div class="mt-auto grid grid-cols-2 gap-2 pt-5">
                    <button type="button" data-kelola class="rounded-lg border border-slate-200 py-2.5 text-xs font-bold text-navy-900 transition hover:border-navy-900">Kelola Batch</button>
                    ${langkah ? `<button type="button" data-langkah class="rounded-lg bg-navy-900 py-2.5 text-xs font-bold text-white transition hover:bg-teal-600">${langkah[0]}</button>`
                        : '<button type="button" data-kelola class="rounded-lg bg-teal-50 py-2.5 text-xs font-bold text-teal-700 transition hover:bg-teal-100">Lihat Hasil</button>'}
                </div></article>`;
        };

        const cocokTab = (p) => tab === 'semua' || (tab === 'update' ? p.perluUpdate : p.status === tab);

        const daftar = buatDaftar({
            form: $('filter'), rows: () => rows, wadah: $('daftar'), info: $('info'), nav: $('halaman'), kosong: $('kosong'),
            chipEl: $('chip-aktif'), reset: $('atur-ulang'), perHalaman: 6, satuan: 'program', baris: kartu,
            urut: { kolom: 'mulai', arah: -1 }, pembanding: { mulai: (a, b) => a.mulai.localeCompare(b.mulai) },
            saring: (p, v) => cocokTab(p)
                && (!v.q || `${p.judul} ${p.instruktur}`.toLowerCase().includes(v.q.trim().toLowerCase()))
                && (!v.kategori || p.kategori === v.kategori) && (!v.sertifikasi || p.sertifikasi === v.sertifikasi),
            chip: { kategori: (v) => v, sertifikasi: (v) => `Sertifikasi ${v}` },
            setelah: () => {
                const aktif = rows.filter((p) => p.status === 'berjalan');
                const selesai = rows.filter((p) => p.lulus != null);
                $('s-peserta').textContent = angka(aktif.reduce((a, p) => a + p.terisi, 0));
                $('s-berjalan').textContent = aktif.length;
                $('s-dibuka').textContent = rows.filter((p) => p.status === 'dibuka').length;
                $('s-lulus').textContent = selesai.length ? `${(selesai.reduce((a, p) => a + p.lulus, 0) / selesai.length).toFixed(1).replace('.', ',')}%` : '-';
                document.querySelectorAll('[data-hitung]').forEach((el) => {
                    const k = el.dataset.hitung;
                    el.textContent = `(${rows.filter((p) => k === 'semua' || (k === 'update' ? p.perluUpdate : p.status === k)).length})`;
                });
            },
        });

        document.querySelectorAll('.tab-btn').forEach((b) => b.addEventListener('click', () => {
            tab = b.dataset.tab;
            $('filter').elements.tab.value = tab;
            document.querySelectorAll('.tab-btn').forEach((x) => {
                const pilih = x === b;
                x.setAttribute('aria-selected', pilih);
                x.classList.toggle('border-navy-900', pilih); x.classList.toggle('bg-navy-900', pilih); x.classList.toggle('text-white', pilih);
                x.classList.toggle('border-slate-200', !pilih); x.classList.toggle('text-slate-600', !pilih);
            });
            daftar.render(true);
        }));

        const ubah = (id, sebagian, pesan) => {
            simpan.ubah(id, sebagian);
            rows = simpan.gabung(awal.rows);
            beritahu();
            daftar.render();
            toast(pesan, '✅');
        };

        const langkah = (p) => {
            const [teks, berikut] = LANGKAH[p.status];
            ubah(p.id, { status: berikut }, `${p.judul}: ${STATUS[berikut][0]}.`);
        };

        const kelola = (p) => bukaDetail({
            inisial: inisial(p.instruktur), judul: p.judul, sub: `${p.instruktur}${p.instrukturTuli ? ' (Tuli)' : ''}`,
            lencana: [badge(STATUS[p.status][0], STATUS[p.status][1]), badge(p.kategori, 'ungu')],
            pasangan: [['ID program', p.id], ['Lokasi', p.lokasi], ['Kuota', `${p.terisi} dari ${p.kuota} peserta`], ['Sisa kursi', Math.max(p.kuota - p.terisi, 0)],
                ['Mulai', tanggal(p.mulai)], ['Selesai', tanggal(p.selesai)], ['Durasi', `${p.minggu} minggu`], ['Sertifikasi', p.sertifikasi],
                ['Dukungan bahasa', p.bahasa], ['Kelulusan', p.lulus != null ? `${p.lulus}%` : '-']],
            aksi: [
                ...(LANGKAH[p.status] ? [{ teks: LANGKAH[p.status][0], klik: () => langkah(p) }] : []),
                { teks: p.perluUpdate ? 'Tandai Bahasa Isyarat Sudah Diperbarui' : 'Tandai Perlu Update Bahasa Isyarat', gaya: 'netral',
                  klik: () => ubah(p.id, { perluUpdate: !p.perluUpdate }, p.perluUpdate ? 'Materi ditandai sudah diperbarui.' : 'Materi ditandai perlu update bahasa isyarat.') },
            ],
        });

        $('daftar').addEventListener('click', (e) => {
            const p = rows.find((x) => x.id === e.target.closest('article[data-id]')?.dataset.id);
            if (!p) return;
            if (e.target.closest('[data-kelola]')) kelola(p);
            if (e.target.closest('[data-langkah]')) langkah(p);
        });

        $('ekspor').addEventListener('click', () => {
            unduhCsv(`pelatihan-${hariIni()}.csv`, [['ID', 'Judul', 'Kategori', 'Instruktur', 'Status', 'Kuota', 'Terisi', 'Mulai', 'Selesai', 'Sertifikasi', 'Dukungan bahasa', 'Kelulusan (%)'],
                ...daftar.hasil().map((p) => [p.id, p.judul, p.kategori, p.instruktur, STATUS[p.status][0], p.kuota, p.terisi, p.mulai, p.selesai, p.sertifikasi, p.bahasa, p.lulus ?? ''])]);
            toast('Laporan pelatihan diunduh sebagai CSV.', '⬇️');
        });

        formModal({
            modal: 'modal-tambah', form: 'form-tambah', buka: 'buka-tambah',
            kirim: (d, tutupModal) => {
                const terbesar = Math.max(0, ...rows.map((p) => Number(p.id.split('-').pop())));
                const selesai = new Date(d.mulai); selesai.setDate(selesai.getDate() + Number(d.minggu) * 7);
                // TODO: kirim ke backend (POST /admin/pelatihan) setelah database tersedia
                simpan.tambah({
                    id: `PLT-${String(terbesar + 1).padStart(3, '0')}`, judul: d.judul.trim(), kategori: d.kategori, instruktur: d.instruktur.trim(), instrukturTuli: !!d.tuli, bahasa: d.bahasa,
                    kuota: Number(d.kuota), terisi: 0, mulai: d.mulai, selesai: selesai.toLocaleDateString('sv-SE'), minggu: Number(d.minggu), status: 'dibuka', lulus: null,
                    sertifikasi: d.sertifikasi, lokasi: d.lokasi, perluUpdate: false,
                });
                rows = simpan.gabung(awal.rows);
                tutupModal();
                beritahu();
                daftar.render(true);
                toast(`${d.judul.trim()} ditambahkan dan pendaftaran dibuka.`, '✅');
            },
        });

        daftar.render(true);
    })();
</script>
@endpush
