@extends('admin.layouts.app')

@section('title', 'Data Perusahaan')

@php
    $statusPerusahaan = \App\Support\Admin\ContohOperasional::STATUS_PERUSAHAAN;
    $koleksi = collect($rows);
    $sektor = $koleksi->pluck('sektor')->unique()->sort()->values();

    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $labelKecil = 'mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500';
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-admin.judul judul="Data Perusahaan" crumb="Data Perusahaan"
                   deskripsi="Kelola perusahaan mitra yang menyediakan lowongan untuk pencari kerja tunarungu. Admin dapat menambah, memverifikasi, menandai ramah tunarungu, dan menonaktifkan perusahaan.">
        <button type="button" id="ekspor" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">
            <x-admin.ikon nama="unduh" class="h-4 w-4" tebal="2" /> Export CSV
        </button>
        <button type="button" id="buka-tambah" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
            + Tambah Perusahaan
        </button>
    </x-admin.judul>

    <section class="grid grid-cols-2 gap-4 xl:grid-cols-4" aria-label="Ringkasan perusahaan">
        <x-admin.kartu tag="button" data-kartu-status="" aria-pressed="false" label="Total Perusahaan" :nilai="$koleksi->count()" id="s-total" ket="Terdaftar di sistem" ikon="perusahaan" class="kartu-status w-full" />
        <x-admin.kartu tag="button" data-kartu-status="aktif" aria-pressed="false" label="Perusahaan Aktif" :nilai="$koleksi->where('status', 'aktif')->count()" id="s-aktif" ket="Memiliki akses ke sistem" ikon="centang" warna="bg-emerald-50 text-emerald-600" class="kartu-status w-full" />
        <x-admin.kartu tag="button" data-kartu-ramah="1" aria-pressed="false" label="Ramah Tunarungu" :nilai="$koleksi->where('ramah', true)->count()" id="s-ramah" ket="Menyediakan akomodasi" ikon="perisai" warna="bg-teal-50 text-teal-600" class="kartu-ramah w-full" />
        <x-admin.kartu tag="button" data-kartu-status="verifikasi" aria-pressed="false" label="Menunggu Verifikasi" :nilai="$koleksi->where('status', 'verifikasi')->count()" id="s-verifikasi" ket="Perlu ditinjau admin" ikon="jam" warna="bg-amber-100 text-amber-700" ton="peringatan" class="kartu-status w-full" />
    </section>

    <section class="rounded-3xl border border-slate-100 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 p-5 sm:p-6">
            <h2 class="text-lg font-extrabold text-navy-900">Daftar Perusahaan</h2>
        </div>

        <form id="filter" class="border-t border-slate-100 px-5 py-4 sm:px-6" onsubmit="return false">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <label class="block"><span class="{{ $labelKecil }}">Cari</span><input type="search" name="q" placeholder="Nama perusahaan atau NIB" class="{{ $input }}"></label>
                <label class="block"><span class="{{ $labelKecil }}">Status</span>
                    <select name="status" class="{{ $input }}"><option value="">Semua status</option>@foreach ($statusPerusahaan as $k => $t)<option value="{{ $k }}">{{ $t }}</option>@endforeach</select></label>
                <label class="block"><span class="{{ $labelKecil }}">Sektor</span>
                    <select name="sektor" class="{{ $input }}"><option value="">Semua sektor</option>@foreach ($sektor as $t)<option>{{ $t }}</option>@endforeach</select></label>
                <label class="block"><span class="{{ $labelKecil }}">Aksesibilitas</span>
                    <select name="ramah" class="{{ $input }}"><option value="">Semua</option><option value="ya">Ramah Tunarungu</option><option value="tidak">Umum</option></select></label>
            </div>
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="text-xs font-semibold text-slate-500">Filter aktif:</span>
                <div id="chip-aktif" class="flex flex-wrap gap-2"></div>
                <button type="button" id="atur-ulang" class="ml-auto text-xs font-semibold text-teal-600 hover:underline">Reset filter</button>
            </div>
        </form>

        <div id="tabel-wadah" class="overflow-x-auto border-t border-slate-100">
            <table class="w-full min-w-[56rem] text-left text-sm">
                <caption class="sr-only">Daftar perusahaan mitra</caption>
                <thead class="bg-surface text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3" aria-sort="ascending"><button type="button" data-urut="nama" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-navy-900">Perusahaan <span data-panah aria-hidden="true"></span></button></th>
                        <th scope="col" class="px-3 py-3">Sektor</th>
                        <th scope="col" class="px-3 py-3">Lokasi</th>
                        <th scope="col" class="px-3 py-3" aria-sort="none"><button type="button" data-urut="lowongan" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-navy-900">Lowongan <span data-panah aria-hidden="true"></span></button></th>
                        <th scope="col" class="px-3 py-3">Aksesibilitas</th>
                        <th scope="col" class="px-3 py-3">Status</th>
                        <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>
        <div id="kosong" class="hidden border-t border-slate-100 p-10 text-center">
            <p class="font-bold text-navy-900">Tidak ada perusahaan yang cocok</p>
            <p class="mt-1 text-sm">Coba ubah kata kunci atau reset filter.</p>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 text-xs text-slate-500 sm:px-6">
            <p id="info"></p>
            <nav id="halaman" class="flex flex-wrap items-center gap-1.5" aria-label="Halaman"></nav>
        </div>
    </section>

    <aside class="flex gap-3 rounded-2xl border border-teal-100 bg-teal-50 p-4 text-sm">
        <x-admin.ikon nama="info" class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" />
        <p><b class="text-navy-900">Catatan:</b> data perusahaan menjadi sumber informasi lowongan kerja. Perusahaan yang sudah diverifikasi dan menyediakan akomodasi tunarungu mendapat label <b>Ramah Tunarungu</b> dan diprioritaskan dalam rekomendasi untuk pencari kerja.</p>
    </aside>
</div>

{{-- ============ MODAL TAMBAH ============ --}}
<div id="modal-tambah" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="t-judul">
    <div class="pop-in flex max-h-[92vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-5 sm:p-6">
            <div><h2 id="t-judul" class="text-lg font-extrabold text-navy-900">Tambah Perusahaan</h2><p class="text-sm">Perusahaan baru masuk dengan status <b>Menunggu Verifikasi</b>.</p></div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-navy-900" aria-label="Tutup"><x-admin.ikon nama="tambah" class="h-5 w-5 rotate-45" tebal="2" /></button>
        </div>
        <form id="form-tambah" class="flex min-h-0 flex-1 flex-col" novalidate>
            <div class="grid flex-1 gap-4 overflow-y-auto p-5 sm:grid-cols-2 sm:p-6">
                <div class="field sm:col-span-2"><label for="t-nama" class="{{ $labelKecil }}">Nama perusahaan</label>
                    <input id="t-nama" name="nama" type="text" required placeholder="Contoh: PT Maju Sentosa" class="{{ $input }}"></div>
                <div class="field"><label for="t-nib" class="{{ $labelKecil }}">NIB (13 angka)</label>
                    <input id="t-nib" name="nib" type="text" inputmode="numeric" required pattern="[0-9]{13}" data-pattern-msg="NIB terdiri dari 13 angka." placeholder="9120000000000" class="{{ $input }}"></div>
                <div class="field"><label for="t-sektor" class="{{ $labelKecil }}">Sektor</label>
                    <select id="t-sektor" name="sektor" class="{{ $input }}">@foreach ($sektor as $t)<option>{{ $t }}</option>@endforeach</select></div>
                <div class="field"><label for="t-lokasi" class="{{ $labelKecil }}">Lokasi</label>
                    <input id="t-lokasi" name="lokasi" type="text" required placeholder="Contoh: Bandung" class="{{ $input }}"></div>
                <div class="field"><label for="t-email" class="{{ $labelKecil }}">Email HRD</label>
                    <input id="t-email" name="email" type="email" required placeholder="hrd@perusahaan.co.id" class="{{ $input }}"></div>
                <label class="chip flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3.5 text-sm sm:col-span-2">
                    <input type="checkbox" name="ramah" value="1" class="h-4 w-4 rounded border-slate-300 accent-teal-600"> Perusahaan menyatakan menyediakan akomodasi untuk tunarungu
                </label>
            </div>
            <div class="flex justify-end gap-3 border-t border-slate-100 px-5 py-4 sm:px-6">
                <button type="button" class="modal-close rounded-lg px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Batal</button>
                <button type="submit" class="rounded-lg bg-navy-900 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-teal-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

@php $dataJson = ['rows' => $rows, 'status' => $statusPerusahaan]; @endphp
<script type="application/json" id="data-halaman">@json($dataJson)</script>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { buatDaftar, simpanan, badge, esc, angka, tanggal, inisial, bukaDetail, formModal, unduhCsv, hariIni, beritahu } = window.TunakerAdmin;
        const { toast } = window.TunakerUI;
        const $ = (id) => document.getElementById(id);
        const awal = JSON.parse($('data-halaman').textContent);
        const simpan = simpanan('tunaker_admin_perusahaan');
        const NADA = { aktif: 'hijau', verifikasi: 'amber', nonaktif: 'abu' };
        let rows = simpan.gabung(awal.rows);

        const baris = (p) => `<tr data-id="${p.id}" class="transition hover:bg-surface/60">
            <td class="px-5 py-3.5"><div class="flex items-center gap-3">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-surface text-xs font-extrabold text-navy-900 ring-1 ring-slate-200" aria-hidden="true">${esc(inisial(p.nama.replace(/^(PT|CV)\s+/, '')))}</span>
                <div class="min-w-0"><p class="font-bold text-navy-900">${esc(p.nama)}</p><p class="text-xs text-slate-500">NIB: ${esc(p.nib)}</p></div></div></td>
            <td class="px-3 py-3.5 text-slate-600">${esc(p.sektor)}</td>
            <td class="px-3 py-3.5 text-slate-600">${esc(p.lokasi)}</td>
            <td class="px-3 py-3.5 font-bold text-navy-900">${angka(p.lowongan)}</td>
            <td class="px-3 py-3.5">${p.ramah ? badge('Ramah Tunarungu', 'teal') : badge('Umum', 'abu')}</td>
            <td class="px-3 py-3.5">${badge(awal.status[p.status], NADA[p.status])}</td>
            <td class="px-5 py-3.5"><div class="flex justify-end gap-2">
                <button type="button" data-detail class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-navy-900 transition hover:border-navy-900">Detail</button>
                ${p.status === 'verifikasi' ? '<button type="button" data-verifikasi class="rounded-lg bg-navy-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-teal-600">Verifikasi</button>'
                    : '<button type="button" data-detail class="rounded-lg bg-navy-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-teal-600">Edit</button>'}
            </div></td></tr>`;

        const daftar = buatDaftar({
            form: $('filter'), rows: () => rows, wadah: $('tabel'), tabel: $('tabel-wadah'), info: $('info'), nav: $('halaman'), kosong: $('kosong'),
            chipEl: $('chip-aktif'), reset: $('atur-ulang'), perHalaman: 8, satuan: 'perusahaan', baris,
            urut: { kolom: 'nama', arah: 1 }, arahAwal: { nama: 1, lowongan: -1 },
            pembanding: { nama: (a, b) => a.nama.localeCompare(b.nama, 'id'), lowongan: (a, b) => a.lowongan - b.lowongan || a.nama.localeCompare(b.nama, 'id') },
            saring: (p, v) => (!v.q || `${p.nama} ${p.nib}`.toLowerCase().includes(v.q.trim().toLowerCase()))
                && (!v.status || p.status === v.status) && (!v.sektor || p.sektor === v.sektor)
                && (!v.ramah || (v.ramah === 'ya' ? p.ramah : !p.ramah)),
            chip: { status: (v) => awal.status[v], sektor: (v) => v, ramah: (v) => (v === 'ya' ? 'Ramah Tunarungu' : 'Umum') },
            setelah: () => {
                $('s-total').textContent = angka(rows.length);
                $('s-aktif').textContent = angka(rows.filter((p) => p.status === 'aktif').length);
                $('s-ramah').textContent = angka(rows.filter((p) => p.ramah).length);
                $('s-verifikasi').textContent = angka(rows.filter((p) => p.status === 'verifikasi').length);
                const f = $('filter').elements;
                document.querySelectorAll('.kartu-status').forEach((k) => {
                    const pilih = k.dataset.kartuStatus !== '' && f.status.value === k.dataset.kartuStatus;
                    k.classList.toggle('ring-2', pilih); k.classList.toggle('ring-teal-500', pilih); k.setAttribute('aria-pressed', pilih);
                });
                document.querySelector('.kartu-ramah').classList.toggle('ring-2', f.ramah.value === 'ya');
                document.querySelector('.kartu-ramah').classList.toggle('ring-teal-500', f.ramah.value === 'ya');
            },
        });

        const ubah = (id, sebagian, pesan) => {
            simpan.ubah(id, sebagian);
            rows = simpan.gabung(awal.rows);
            beritahu();
            daftar.render();
            toast(pesan, '✅');
        };

        const detail = (p) => bukaDetail({
            inisial: inisial(p.nama.replace(/^(PT|CV)\s+/, '')), judul: p.nama, sub: `NIB ${p.nib}`,
            lencana: [badge(awal.status[p.status], NADA[p.status]), p.ramah ? badge('Ramah Tunarungu', 'teal') : badge('Umum', 'abu')],
            pasangan: [['ID', p.id], ['Sektor', p.sektor], ['Lokasi', p.lokasi], ['Email HRD', p.email], ['Lowongan terdaftar', angka(p.lowongan)], ['Bergabung', tanggal(p.bergabung)]],
            aksi: [
                ...(p.status === 'verifikasi' ? [{ teks: 'Verifikasi Perusahaan', klik: () => ubah(p.id, { status: 'aktif' }, `${p.nama} diverifikasi dan aktif.`) }] : []),
                ...(p.status === 'aktif' ? [{ teks: 'Nonaktifkan', gaya: 'bahaya', klik: () => ubah(p.id, { status: 'nonaktif' }, `${p.nama} dinonaktifkan.`) }] : []),
                ...(p.status === 'nonaktif' ? [{ teks: 'Aktifkan Lagi', klik: () => ubah(p.id, { status: 'aktif' }, `${p.nama} diaktifkan.`) }] : []),
                { teks: p.ramah ? 'Cabut Label Ramah Tunarungu' : 'Tandai Ramah Tunarungu', gaya: 'netral',
                  klik: () => ubah(p.id, { ramah: !p.ramah }, p.ramah ? 'Label ramah tunarungu dicabut.' : `${p.nama} ditandai Ramah Tunarungu.`) },
            ],
        });

        $('tabel').addEventListener('click', (e) => {
            const p = rows.find((x) => x.id === e.target.closest('tr[data-id]')?.dataset.id);
            if (!p) return;
            if (e.target.closest('[data-detail]')) detail(p);
            if (e.target.closest('[data-verifikasi]')) ubah(p.id, { status: 'aktif' }, `${p.nama} diverifikasi dan aktif.`);
        });

        document.querySelectorAll('.kartu-status').forEach((k) => k.addEventListener('click', () => {
            const f = $('filter').elements;
            f.status.value = k.dataset.kartuStatus === '' || f.status.value === k.dataset.kartuStatus ? '' : k.dataset.kartuStatus;
            f.ramah.value = '';
            daftar.render(true);
        }));
        document.querySelector('.kartu-ramah').addEventListener('click', () => {
            const f = $('filter').elements;
            f.ramah.value = f.ramah.value === 'ya' ? '' : 'ya';
            f.status.value = '';
            daftar.render(true);
        });

        $('ekspor').addEventListener('click', () => {
            const data = daftar.hasil();
            if (!data.length) { toast('Tidak ada data untuk diexport.', 'ℹ️'); return; }
            unduhCsv(`perusahaan-${hariIni()}.csv`, [['ID', 'Nama', 'NIB', 'Sektor', 'Lokasi', 'Email HRD', 'Lowongan', 'Ramah tunarungu', 'Status', 'Bergabung'],
                ...data.map((p) => [p.id, p.nama, p.nib, p.sektor, p.lokasi, p.email, p.lowongan, p.ramah ? 'Ya' : 'Tidak', awal.status[p.status], p.bergabung])]);
            toast(`${angka(data.length)} perusahaan diexport sebagai CSV.`, '⬇️');
        });

        formModal({
            modal: 'modal-tambah', form: 'form-tambah', buka: 'buka-tambah',
            kirim: (d, tutupModal) => {
                const terbesar = Math.max(0, ...rows.map((p) => Number(p.id.split('-').pop())));
                const slug = d.nama.toLowerCase().replace(/[^a-z0-9]+/g, '');
                // TODO: kirim ke backend (POST /admin/perusahaan) setelah database tersedia
                simpan.tambah({
                    id: `PRS-${String(terbesar + 1).padStart(3, '0')}`, nama: d.nama.trim(), nib: d.nib, sektor: d.sektor, lokasi: d.lokasi.trim(), ramah: !!d.ramah,
                    status: 'verifikasi', email: d.email.trim() || `hrd@${slug}.co.id`, bergabung: hariIni(), lowongan: 0,
                });
                rows = simpan.gabung(awal.rows);
                tutupModal();
                beritahu();
                daftar.render(true);
                toast(`${d.nama.trim()} ditambahkan dan menunggu verifikasi.`, '✅');
            },
        });

        const param = new URLSearchParams(location.search);
        if (param.get('q')) $('filter').elements.q.value = param.get('q');
        daftar.render(true);
    })();
</script>
@endpush
