@extends('admin.layouts.app')

@section('title', 'Data RFID & Smart ID')

@php
    $statusKartu = \App\Support\Admin\ContohOperasional::STATUS_KARTU;
    $gate = \App\Support\Admin\ContohOperasional::GATE;
    $koleksi = collect($rows);
    $batch = $koleksi->pluck('batch')->unique()->sortDesc()->values();
    $aktif = $koleksi->where('status', 'aktif')->count();

    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $labelKecil = 'mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500';
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-admin.judul judul="Manajemen Kartu Smart ID & RFID" crumb="Kartu Smart ID" :induk="[['Pencari Kerja', 'admin.pencari']]"
                   deskripsi="Kelola kartu identitas pintar (ISO 14443A) yang dipakai pencari kerja untuk masuk dan melamar cepat dengan tap, tanpa perlu mendengar atau mengetik.">
        <button type="button" id="ekspor" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">
            <x-admin.ikon nama="unduh" class="h-4 w-4" tebal="2" /> Unduh Rekap Serial (CSV)
        </button>
        <button type="button" id="buka-tambah" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
            + Daftarkan Kartu RFID Baru
        </button>
    </x-admin.judul>

    <x-admin.tab :item="[['Daftar Pencari Kerja', 'admin.pencari'], ['Kartu Smart ID', 'admin.rfid']]" />

    <section class="grid grid-cols-2 gap-4 xl:grid-cols-4" aria-label="Ringkasan kartu">
        <x-admin.kartu tag="button" data-kartu-status="" aria-pressed="false" label="Total Kartu Terbit" :nilai="number_format($koleksi->count(), 0, ',', '.')" id="s-total" ket="Sejak program dimulai" ikon="kartu" class="kartu-status w-full" />
        <x-admin.kartu tag="button" data-kartu-status="aktif" aria-pressed="false" label="Kartu Aktif & Terhubung" :nilai="number_format($aktif, 0, ',', '.')" id="s-aktif" :ket="round($aktif / max($koleksi->count(), 1) * 100, 1) . '% dari total kartu'" ikon="sinyal" warna="bg-emerald-50 text-emerald-600" class="kartu-status w-full" />
        <x-admin.kartu tag="button" data-kartu-status="menunggu" aria-pressed="false" label="Menunggu Aktivasi" :nilai="$koleksi->where('status', 'menunggu')->count()" id="s-menunggu" ket="Kartu sudah dicetak, belum diaktifkan" ikon="jam" warna="bg-amber-100 text-amber-700" ton="peringatan" class="kartu-status w-full" />
        <x-admin.kartu tag="button" data-kartu-status="hilang" aria-pressed="false" label="Rusak / Hilang" :nilai="$koleksi->where('status', 'hilang')->count()" id="s-hilang" ket="Perlu diblokir atau diterbitkan ulang" ikon="peringatan" warna="bg-red-100 text-red-600" ton="bahaya" class="kartu-status w-full" />
    </section>

    <section class="rounded-3xl border border-slate-100 bg-white shadow-sm">
        <form id="filter" class="p-5 sm:p-6" onsubmit="return false">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <label class="block"><span class="{{ $labelKecil }}">Cari</span><input type="search" name="q" placeholder="Nama, ID kartu, atau serial" class="{{ $input }}"></label>
                <label class="block"><span class="{{ $labelKecil }}">Status kartu</span>
                    <select name="status" class="{{ $input }}"><option value="">Semua status</option>@foreach ($statusKartu as $k => $t)<option value="{{ $k }}">{{ $t }}</option>@endforeach</select></label>
                <label class="block"><span class="{{ $labelKecil }}">Batch</span>
                    <select name="batch" class="{{ $input }}"><option value="">Semua batch</option>@foreach ($batch as $b)<option>{{ $b }}</option>@endforeach</select></label>
                <label class="block"><span class="{{ $labelKecil }}">Lokasi tap terakhir</span>
                    <select name="gate" class="{{ $input }}"><option value="">Semua lokasi</option>@foreach ($gate as $g)<option>{{ $g }}</option>@endforeach</select></label>
            </div>
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="text-xs font-semibold text-slate-500">Filter aktif:</span>
                <div id="chip-aktif" class="flex flex-wrap gap-2"></div>
                <button type="button" id="atur-ulang" class="ml-auto text-xs font-semibold text-teal-600 hover:underline">Reset filter</button>
            </div>
        </form>

        <div id="tabel-wadah" class="overflow-x-auto border-t border-slate-100">
            <table class="w-full min-w-[60rem] text-left text-sm">
                <caption class="sr-only">Daftar kartu Smart ID dan RFID</caption>
                <thead class="bg-surface text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3">ID Kartu & Serial</th>
                        <th scope="col" class="px-3 py-3" aria-sort="ascending"><button type="button" data-urut="nama" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-navy-900">Pemilik <span data-panah aria-hidden="true"></span></button></th>
                        <th scope="col" class="px-3 py-3">Aksesibilitas</th>
                        <th scope="col" class="px-3 py-3">Aktivasi & Batch</th>
                        <th scope="col" class="px-3 py-3" aria-sort="none"><button type="button" data-urut="tap" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-navy-900">Tap Terakhir <span data-panah aria-hidden="true"></span></button></th>
                        <th scope="col" class="px-3 py-3">Status</th>
                        <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>
        <div id="kosong" class="hidden border-t border-slate-100 p-10 text-center">
            <p class="font-bold text-navy-900">Tidak ada kartu yang cocok</p>
            <p class="mt-1 text-sm">Coba ubah kata kunci atau reset filter.</p>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 text-xs text-slate-500 sm:px-6">
            <p id="info"></p>
            <nav id="halaman" class="flex flex-wrap items-center gap-1.5" aria-label="Halaman"></nav>
        </div>
    </section>

    <aside class="flex flex-wrap items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-navy-900 text-white"><x-admin.ikon nama="kunci" class="h-6 w-6" /></span>
        <div class="min-w-0 flex-1 basis-72">
            <p class="font-extrabold text-navy-900">Protokol Keamanan Data RFID & Enkripsi ISO 14443A</p>
            <p class="text-sm">Data kartu dienkripsi dan hanya menyimpan kode identitas, bukan data pribadi. Rotasi master key dilakukan terjadwal oleh admin utama.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button type="button" id="buka-sdk" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">Dokumentasi Reader SDK</button>
            <button type="button" id="buka-rotasi" class="rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-600">Rotasikan Master Key</button>
        </div>
    </aside>
</div>

{{-- ============ MODAL DAFTARKAN KARTU ============ --}}
<div id="modal-tambah" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="t-judul">
    <div class="pop-in flex max-h-[92vh] w-full max-w-lg flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-5 sm:p-6">
            <div><h2 id="t-judul" class="text-lg font-extrabold text-navy-900">Daftarkan Kartu RFID Baru</h2><p class="text-sm">Kartu baru berstatus <b>Menunggu Aktivasi</b> sampai pemilik menempelkannya di reader.</p></div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-navy-900" aria-label="Tutup"><x-admin.ikon nama="tambah" class="h-5 w-5 rotate-45" tebal="2" /></button>
        </div>
        <form id="form-tambah" class="flex min-h-0 flex-1 flex-col" novalidate>
            <div class="grid flex-1 gap-4 overflow-y-auto p-5 sm:p-6">
                <div class="field"><label for="t-nama" class="{{ $labelKecil }}">Nama pemilik</label>
                    <input id="t-nama" name="nama" type="text" required placeholder="Nama pencari kerja" class="{{ $input }}"></div>
                <div class="field"><label for="t-serial" class="{{ $labelKecil }}">Serial / UID kartu</label>
                    <input id="t-serial" name="serial" type="text" required pattern="([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}" data-pattern-msg="Format: 6 pasang heksadesimal dipisah titik dua, contoh 04:A3:5F:19:C2:7B." placeholder="04:A3:5F:19:C2:7B" class="{{ $input }} font-mono"></div>
                <div class="field"><label for="t-komunikasi" class="{{ $labelKecil }}">Komunikasi utama</label>
                    <select id="t-komunikasi" name="komunikasi" class="{{ $input }}">@foreach (\App\Support\Admin\ContohAdmin::KOMUNIKASI as $k)<option>{{ $k }}</option>@endforeach</select></div>
            </div>
            <div class="flex justify-end gap-3 border-t border-slate-100 px-5 py-4 sm:px-6">
                <button type="button" class="modal-close rounded-lg px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Batal</button>
                <button type="submit" class="rounded-lg bg-navy-900 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-teal-600">Daftarkan</button>
            </div>
        </form>
    </div>
</div>

@php $dataJson = ['rows' => $rows, 'status' => $statusKartu]; @endphp
<script type="application/json" id="data-halaman">@json($dataJson)</script>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { buatDaftar, simpanan, badge, esc, angka, tanggal, tanggalJam, inisial, bukaDetail, formModal, unduhCsv, hariIni, beritahu } = window.TunakerAdmin;
        const { toast } = window.TunakerUI;
        const $ = (id) => document.getElementById(id);
        const awal = JSON.parse($('data-halaman').textContent);
        const simpan = simpanan('tunaker_admin_rfid');
        const NADA = { aktif: 'hijau', menunggu: 'amber', hilang: 'merah' };
        let rows = simpan.gabung(awal.rows);

        const sekarang = () => { const d = new Date(); return `${hariIni()} ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`; };

        const baris = (k) => `<tr data-id="${k.id}" class="transition hover:bg-surface/60">
            <td class="px-5 py-3.5"><p class="whitespace-nowrap font-bold text-navy-900">${esc(k.id)}</p><p class="font-mono text-xs text-slate-500">${esc(k.serial)}</p></td>
            <td class="px-3 py-3.5"><div class="flex items-center gap-3">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-teal-500 to-navy-800 text-xs font-bold text-white" aria-hidden="true">${esc(inisial(k.nama))}</span>
                <div class="min-w-0"><p class="font-bold text-navy-900">${esc(k.nama)}</p><p class="text-xs text-slate-500">${esc(k.nik)}</p></div></div></td>
            <td class="px-3 py-3.5"><span class="whitespace-nowrap rounded-md bg-teal-50 px-2 py-1 text-[11px] font-semibold text-teal-600">${esc(k.komunikasi)}</span></td>
            <td class="px-3 py-3.5"><p class="whitespace-nowrap font-semibold text-navy-900">${esc(k.batch)}</p><p class="whitespace-nowrap text-xs text-slate-500">Terbit ${tanggal(k.diterbitkan)}</p></td>
            <td class="px-3 py-3.5">${k.tap ? `<p class="whitespace-nowrap font-semibold text-navy-900">${tanggalJam(k.tap)}</p><p class="text-xs text-slate-500">${esc(k.gate)}</p>` : '<span class="text-xs text-slate-400">Belum pernah dipakai</span>'}</td>
            <td class="px-3 py-3.5">${badge(awal.status[k.status], NADA[k.status])}</td>
            <td class="px-5 py-3.5"><div class="flex justify-end gap-2">
                <button type="button" data-detail class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-navy-900 transition hover:border-navy-900">Detail</button>
                ${k.status === 'menunggu' ? '<button type="button" data-aktifkan class="rounded-lg bg-navy-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-teal-600">Aktifkan</button>' : ''}
            </div></td></tr>`;

        const daftar = buatDaftar({
            form: $('filter'), rows: () => rows, wadah: $('tabel'), tabel: $('tabel-wadah'), info: $('info'), nav: $('halaman'), kosong: $('kosong'),
            chipEl: $('chip-aktif'), reset: $('atur-ulang'), perHalaman: 8, satuan: 'kartu', baris,
            urut: { kolom: 'nama', arah: 1 }, arahAwal: { nama: 1, tap: -1 },
            pembanding: { nama: (a, b) => a.nama.localeCompare(b.nama, 'id'), tap: (a, b) => (a.tap ?? '').localeCompare(b.tap ?? '') || a.id.localeCompare(b.id) },
            saring: (k, v) => (!v.q || `${k.nama} ${k.id} ${k.serial}`.toLowerCase().includes(v.q.trim().toLowerCase()))
                && (!v.status || k.status === v.status) && (!v.batch || k.batch === v.batch) && (!v.gate || k.gate === v.gate),
            chip: { status: (v) => awal.status[v], batch: (v) => v, gate: (v) => v },
            setelah: () => {
                const hit = (s) => rows.filter((k) => k.status === s).length;
                $('s-total').textContent = angka(rows.length);
                $('s-aktif').textContent = angka(hit('aktif'));
                $('s-aktif').nextElementSibling.textContent = `${(hit('aktif') / Math.max(rows.length, 1) * 100).toFixed(1).replace('.', ',')}% dari total kartu`;
                $('s-menunggu').textContent = angka(hit('menunggu'));
                $('s-hilang').textContent = angka(hit('hilang'));
                const f = $('filter').elements;
                document.querySelectorAll('.kartu-status').forEach((el) => {
                    const pilih = el.dataset.kartuStatus !== '' && f.status.value === el.dataset.kartuStatus;
                    el.classList.toggle('ring-2', pilih); el.classList.toggle('ring-teal-500', pilih); el.setAttribute('aria-pressed', pilih);
                });
            },
        });

        const ubah = (k, sebagian, pesan) => {
            simpan.ubah(k.id, sebagian);
            rows = simpan.gabung(awal.rows);
            beritahu();
            daftar.render();
            toast(pesan, '✅');
        };
        const aktifkan = (k) => ubah(k, { status: 'aktif', tap: sekarang(), gate: 'Gate Disnaker Pusat' }, `Kartu ${k.nama} diaktifkan.`);

        const detail = (k) => bukaDetail({
            inisial: inisial(k.nama), judul: k.nama, sub: `${k.id} · ${k.serial}`, lencana: [badge(awal.status[k.status], NADA[k.status]), badge(k.komunikasi, 'teal')],
            pasangan: [['ID kartu', k.id], ['Serial / UID', k.serial], ['NIK', k.nik], ['Batch', k.batch], ['Diterbitkan', tanggal(k.diterbitkan)],
                ['Tap terakhir', k.tap ? tanggalJam(k.tap) : 'Belum pernah'], ['Lokasi tap', k.gate ?? '-'], ['Komunikasi utama', k.komunikasi]],
            aksi: [
                ...(k.status === 'menunggu' ? [{ teks: 'Aktifkan Kartu', klik: () => aktifkan(k) }] : []),
                ...(k.status === 'aktif' ? [{ teks: 'Blokir / Tandai Hilang', gaya: 'bahaya', klik: () => ubah(k, { status: 'hilang' }, `Kartu ${k.nama} diblokir.`) }] : []),
                ...(k.status === 'hilang' ? [{ teks: 'Terbitkan Ulang Kartu', klik: () => ubah(k, { status: 'menunggu', tap: null, gate: null }, `Kartu pengganti ${k.nama} menunggu aktivasi.`) }] : []),
            ],
        });

        $('tabel').addEventListener('click', (e) => {
            const k = rows.find((x) => x.id === e.target.closest('tr[data-id]')?.dataset.id);
            if (!k) return;
            if (e.target.closest('[data-detail]')) detail(k);
            if (e.target.closest('[data-aktifkan]')) aktifkan(k);
        });

        document.querySelectorAll('.kartu-status').forEach((el) => el.addEventListener('click', () => {
            const f = $('filter').elements;
            f.status.value = el.dataset.kartuStatus === '' || f.status.value === el.dataset.kartuStatus ? '' : el.dataset.kartuStatus;
            daftar.render(true);
        }));

        $('ekspor').addEventListener('click', () => {
            const data = daftar.hasil();
            if (!data.length) { toast('Tidak ada data untuk diexport.', 'ℹ️'); return; }
            unduhCsv(`rekap-serial-${hariIni()}.csv`, [['ID kartu', 'Serial', 'Pemilik', 'NIK (disamarkan)', 'Komunikasi', 'Batch', 'Diterbitkan', 'Status', 'Tap terakhir', 'Lokasi tap'],
                ...data.map((k) => [k.id, k.serial, k.nama, k.nik, k.komunikasi, k.batch, k.diterbitkan, awal.status[k.status], k.tap ?? '', k.gate ?? ''])]);
            toast(`${angka(data.length)} kartu diexport sebagai CSV.`, '⬇️');
        });

        $('buka-sdk').addEventListener('click', () => bukaDetail({
            inisial: 'SDK', judul: 'Dokumentasi Reader SDK', sub: 'Integrasi pembaca kartu RFID',
            pasangan: [['Standar kartu', 'ISO/IEC 14443A (13,56 MHz)'], ['Cara kerja', 'Reader mengirim UID kartu ke server lewat HTTPS'], ['Status', 'Dokumentasi lengkap menyusul setelah reader dipasang'], ['Kontak teknis', 'Tim TUNAKER']],
            aksi: [],
        }));
        $('buka-rotasi').addEventListener('click', () => bukaDetail({
            inisial: 'KEY', judul: 'Rotasikan Master Key', sub: 'Tindakan ini memengaruhi semua kartu aktif',
            pasangan: [['Dampak', 'Semua reader harus menerima key baru sebelum kartu bisa dipakai lagi'], ['Saran', 'Lakukan di luar jam layanan dan beri pengumuman lebih dulu'], ['Status fitur', 'Belum tersambung ke reader dan backend']],
            aksi: [{ teks: 'Saya mengerti', gaya: 'bahaya', klik: () => toast('Rotasi key belum bisa dijalankan: reader dan backend belum tersambung.', 'ℹ️') }],
        }));

        formModal({
            modal: 'modal-tambah', form: 'form-tambah', buka: 'buka-tambah',
            kirim: (d, tutupModal) => {
                const terbesar = Math.max(0, ...rows.map((k) => Number(k.id.split('-').pop())));
                const tahun = new Date().getFullYear();
                // TODO: kirim ke backend (POST /admin/rfid) setelah database tersedia
                simpan.tambah({
                    id: `RFID-${tahun}-${String(terbesar + 1).padStart(4, '0')}`, serial: d.serial.toUpperCase(), pencariId: null, nama: d.nama.trim(), nik: 'Belum diisi',
                    komunikasi: d.komunikasi, batch: `Batch ${hariIni().slice(0, 7)}`, status: 'menunggu', tap: null, gate: null, diterbitkan: hariIni(),
                });
                rows = simpan.gabung(awal.rows);
                tutupModal();
                beritahu();
                daftar.render(true);
                toast(`Kartu untuk ${d.nama.trim()} didaftarkan, menunggu aktivasi.`, '✅');
            },
        });

        const param = new URLSearchParams(location.search);
        if (param.get('q')) $('filter').elements.q.value = param.get('q');
        if (param.get('status')) $('filter').elements.status.value = param.get('status');
        daftar.render(true);
    })();
</script>
@endpush
