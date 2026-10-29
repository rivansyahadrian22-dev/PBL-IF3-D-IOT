@extends('admin.layouts.app')

@section('title', 'Data Lamaran')

@php
    $koleksi = collect($rows);
    $komunikasi = \App\Support\Admin\ContohAdmin::KOMUNIKASI;
    $opsiLowongan = collect($lowongan)->whereIn('status', ['aktif', 'review'])->sortBy('posisi')->values();

    $proses = $koleksi->whereIn('status', ['review', 'tes'])->count();
    $wawancara = $koleksi->where('status', 'wawancara');
    $hasil = $koleksi->whereIn('status', ['offering', 'diterima'])->count();
    $persen = fn ($n) => $koleksi->count() ? round($n / $koleksi->count() * 100) : 0;

    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $labelKecil = 'mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500';
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-admin.judul judul="Data Lamaran Masuk" crumb="Data Lamaran" :lencana="number_format($koleksi->count(), 0, ',', '.') . ' Berkas Aktif'"
                   deskripsi="Pantau pipeline pelamaran talenta tunarungu, jadwalkan wawancara berbasis JBI atau teks, dan verifikasi kesiapan akomodasi visual.">
        <button type="button" id="ekspor" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">
            <x-admin.ikon nama="unduh" class="h-4 w-4" tebal="2" /> Unduh Rekap Seleksi (CSV)
        </button>
        <button type="button" id="buka-tambah" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
            + Input Lamaran Manual
        </button>
    </x-admin.judul>

    <section class="grid grid-cols-2 gap-4 xl:grid-cols-4" aria-label="Ringkasan lamaran">
        <x-admin.kartu label="Total Lamaran Masuk" :nilai="number_format($koleksi->count(), 0, ',', '.')" id="s-total" ket="Dari seluruh lowongan aktif" ikon="lamaran" />
        <x-admin.kartu label="Tahap Review / Tes" :nilai="number_format($proses, 0, ',', '.')" id="s-proses" :ket="$persen($proses) . '% dari total'" ikon="jam" warna="bg-amber-50 text-amber-600" />
        <x-admin.kartu label="Wawancara Isyarat / Teks" :nilai="number_format($wawancara->count(), 0, ',', '.')" id="s-wawancara" :ket="$wawancara->where('jbi', true)->count() . ' butuh juru bahasa isyarat'" ikon="video" warna="bg-blue-50 text-blue-600" />
        <x-admin.kartu label="Offering / Diterima" :nilai="number_format($hasil, 0, ',', '.')" id="s-hasil" :ket="$persen($hasil) . '% dari total'" ikon="centang" warna="bg-emerald-50 text-emerald-600" />
    </section>

    <section class="rounded-3xl border border-slate-100 bg-white shadow-sm">
        <form id="filter" class="p-5 sm:p-6" onsubmit="return false">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <label class="block"><span class="{{ $labelKecil }}">Cari</span><input type="search" name="q" placeholder="Pelamar, ID kartu, posisi, atau perusahaan" class="{{ $input }}"></label>
                <label class="block"><span class="{{ $labelKecil }}">Tahap seleksi</span>
                    <select name="status" class="{{ $input }}"><option value="">Semua tahap</option>@foreach (['review' => 'Review Berkas', 'tes' => 'Tes / Portofolio', 'wawancara' => 'Wawancara', 'offering' => 'Offering', 'diterima' => 'Diterima', 'ditolak' => 'Tidak Lolos'] as $k => $t)<option value="{{ $k }}">{{ $t }}</option>@endforeach</select></label>
                <label class="block"><span class="{{ $labelKecil }}">Komunikasi</span>
                    <select name="komunikasi" class="{{ $input }}"><option value="">Semua komunikasi</option>@foreach ($komunikasi as $k)<option>{{ $k }}</option>@endforeach</select></label>
                <label class="block"><span class="{{ $labelKecil }}">Prioritas</span>
                    <select name="prioritas" class="{{ $input }}"><option value="">Semua</option><option value="ya">Siap Kerja Cepat</option></select></label>
            </div>
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="text-xs font-semibold text-slate-500">Filter aktif:</span>
                <div id="chip-aktif" class="flex flex-wrap gap-2"></div>
                <button type="button" id="atur-ulang" class="ml-auto text-xs font-semibold text-teal-600 hover:underline">Reset semua filter</button>
            </div>
        </form>

        <div id="tabel-wadah" class="overflow-x-auto border-t border-slate-100">
            <table class="w-full min-w-[64rem] text-left text-sm">
                <caption class="sr-only">Daftar lamaran masuk</caption>
                <thead class="bg-surface text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3" aria-sort="none"><button type="button" data-urut="nama" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-navy-900">Pelamar & Smart ID <span data-panah aria-hidden="true"></span></button></th>
                        <th scope="col" class="px-3 py-3">Posisi & Perusahaan</th>
                        <th scope="col" class="px-3 py-3" aria-sort="descending"><button type="button" data-urut="tanggal" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-navy-900">Tanggal Melamar <span data-panah aria-hidden="true"></span></button></th>
                        <th scope="col" class="px-3 py-3">Pipeline Seleksi</th>
                        <th scope="col" class="px-3 py-3">Preferensi Komunikasi</th>
                        <th scope="col" class="px-3 py-3">Status</th>
                        <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>
        <div id="kosong" class="hidden border-t border-slate-100 p-10 text-center">
            <p class="font-bold text-navy-900">Tidak ada lamaran yang cocok</p>
            <p class="mt-1 text-sm">Coba ubah kata kunci atau reset filter.</p>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 text-xs text-slate-500 sm:px-6">
            <div class="flex flex-wrap items-center gap-3">
                <label class="flex items-center gap-2">Menampilkan
                    <select id="per-halaman" class="rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-xs font-bold text-navy-900 focus:border-teal-500 focus:outline-none"><option>10</option><option>25</option><option>50</option></select>
                </label>
                <p id="info"></p>
            </div>
            <nav id="halaman" class="flex flex-wrap items-center gap-1.5" aria-label="Halaman"></nav>
        </div>
    </section>

    <aside class="flex flex-wrap items-center gap-4 rounded-2xl border border-blue-100 bg-blue-50 p-4">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-navy-900 text-white"><x-admin.ikon nama="perisai" class="h-5 w-5" /></span>
        <div class="min-w-0 flex-1">
            <p class="font-extrabold text-navy-900">Standar Layanan Aksesibilitas Rekrutmen Tunarungu</p>
            <p class="text-sm">Setiap wawancara wajib menyediakan juru bahasa isyarat atau jalur teks yang disepakati pelamar.</p>
        </div>
        <button type="button" id="buka-sop" class="text-sm font-bold text-navy-900 underline-offset-4 hover:underline">Lihat Panduan SOP Wawancara →</button>
    </aside>
</div>

{{-- ============ MODAL INPUT MANUAL ============ --}}
<div id="modal-tambah" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="t-judul">
    <div class="pop-in flex max-h-[92vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-5 sm:p-6">
            <div><h2 id="t-judul" class="text-lg font-extrabold text-navy-900">Input Lamaran Manual</h2><p class="text-sm">Untuk pelamar yang dibantu admin atau mendaftar lewat komunitas.</p></div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-navy-900" aria-label="Tutup"><x-admin.ikon nama="tambah" class="h-5 w-5 rotate-45" tebal="2" /></button>
        </div>
        <form id="form-tambah" class="flex min-h-0 flex-1 flex-col" novalidate>
            <div class="grid flex-1 gap-4 overflow-y-auto p-5 sm:grid-cols-2 sm:p-6">
                <div class="field sm:col-span-2"><label for="t-nama" class="{{ $labelKecil }}">Nama pelamar</label>
                    <input id="t-nama" name="nama" type="text" required placeholder="Nama sesuai KTP" class="{{ $input }}"></div>
                <div class="field sm:col-span-2"><label for="t-lowongan" class="{{ $labelKecil }}">Lowongan yang dilamar</label>
                    <select id="t-lowongan" name="lowongan" required class="{{ $input }}"><option value="">Pilih lowongan</option>@foreach ($opsiLowongan as $l)<option value="{{ $l['id'] }}">{{ $l['posisi'] }} · {{ $l['perusahaan'] }}</option>@endforeach</select></div>
                <div class="field"><label for="t-komunikasi" class="{{ $labelKecil }}">Komunikasi utama</label>
                    <select id="t-komunikasi" name="komunikasi" required class="{{ $input }}"><option value="">Pilih komunikasi</option>@foreach ($komunikasi as $k)<option>{{ $k }}</option>@endforeach</select></div>
                <label class="chip flex cursor-pointer items-center gap-3 self-end rounded-xl border border-slate-200 p-3 text-sm">
                    <input type="checkbox" name="prioritas" value="1" class="h-4 w-4 rounded border-slate-300 accent-teal-600"> Siap kerja cepat
                </label>
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
        'lowongan' => $opsiLowongan->mapWithKeys(fn ($l) => [$l['id'] => ['posisi' => $l['posisi'], 'perusahaan' => $l['perusahaan']]])->all(),
    ];
@endphp
<script type="application/json" id="data-halaman">@json($dataJson)</script>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { buatDaftar, simpanan, badge, esc, angka, tanggalJam, inisial, bukaDetail, formModal, unduhCsv, hariIni, beritahu } = window.TunakerAdmin;
        const { toast } = window.TunakerUI;
        const $ = (id) => document.getElementById(id);
        const awal = JSON.parse($('data-halaman').textContent);
        const simpan = simpanan('tunaker_admin_lamaran');
        const TAHAP = { 1: 'Review Berkas', 2: 'Tes / Portofolio', 3: 'Wawancara', 4: 'Offering' };
        const URUTAN = ['review', 'tes', 'wawancara', 'offering', 'diterima'];
        const TAHAP_STATUS = { review: 1, tes: 2, wawancara: 3, offering: 4, diterima: 4 };
        const LABEL = { review: 'Review Berkas', tes: 'Tes / Portofolio', wawancara: 'Wawancara', offering: 'Offering', diterima: 'Diterima', ditolak: 'Tidak Lolos' };
        let rows = simpan.gabung(awal.rows);

        const status = (l) => {
            if (l.status === 'wawancara') return l.jbi ? badge('Menunggu Jadwal JBI', 'biru') : badge('Wawancara Teks / Chat', 'biru');
            return badge(l.status === 'offering' ? 'Offering Dikirim' : LABEL[l.status], { review: 'amber', tes: 'ungu', offering: 'hijau', diterima: 'hijau', ditolak: 'merah' }[l.status]);
        };

        const pipeline = (l) => {
            const gagal = l.status === 'ditolak';
            const selesai = l.status === 'diterima';
            const seg = [1, 2, 3, 4].map((n) => {
                const warna = gagal && n === l.tahap ? 'bg-red-500' : (n < l.tahap || selesai ? 'bg-teal-500' : (n === l.tahap ? 'bg-navy-900' : 'bg-slate-200'));
                return `<span class="h-1.5 flex-1 rounded-full ${warna}"></span>`;
            }).join('');
            return `<div class="flex w-36 gap-1" role="img" aria-label="Tahap ${l.tahap} dari 4: ${TAHAP[l.tahap]}">${seg}</div><p class="mt-1.5 text-[11px] font-semibold text-slate-500">${selesai ? 'Selesai' : `Tahap ${l.tahap}/4`} · ${TAHAP[l.tahap]}</p>`;
        };

        const baris = (l) => {
            const berikut = URUTAN[URUTAN.indexOf(l.status) + 1];
            return `<tr data-id="${l.id}" class="transition hover:bg-surface/60">
                <td class="min-w-[13rem] px-5 py-3.5"><div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-teal-500 to-navy-800 text-xs font-bold text-white" aria-hidden="true">${esc(inisial(l.nama))}</span>
                    <div class="min-w-0"><p class="font-bold text-navy-900">${esc(l.nama)}</p><p class="text-xs text-slate-500">${esc(l.rfid)}</p></div></div></td>
                <td class="min-w-[12rem] px-3 py-3.5"><p class="font-semibold text-navy-900">${esc(l.posisi)}</p><p class="text-xs text-slate-500">${esc(l.perusahaan)}</p></td>
                <td class="whitespace-nowrap px-3 py-3.5 text-slate-500">${tanggalJam(l.tanggal)}${l.prioritas ? `<p class="mt-1">${badge('Siap kerja cepat', 'teal')}</p>` : ''}</td>
                <td class="px-3 py-3.5">${pipeline(l)}</td>
                <td class="px-3 py-3.5"><span class="whitespace-nowrap rounded-md bg-teal-50 px-2 py-1 text-[11px] font-semibold text-teal-600">${esc(l.komunikasi)}</span>${l.jbi ? '<span class="ml-1 whitespace-nowrap rounded-md bg-blue-50 px-2 py-1 text-[11px] font-semibold text-blue-700">+ JBI</span>' : ''}</td>
                <td class="px-3 py-3.5">${status(l)}</td>
                <td class="px-5 py-3.5"><div class="flex justify-end gap-2">
                    <button type="button" data-detail class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-navy-900 transition hover:border-navy-900">Detail</button>
                    ${berikut ? `<button type="button" data-maju class="whitespace-nowrap rounded-lg bg-navy-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-teal-600">Majukan</button>` : ''}
                </div></td></tr>`;
        };

        const daftar = buatDaftar({
            form: $('filter'), rows: () => rows, wadah: $('tabel'), tabel: $('tabel-wadah'), info: $('info'), nav: $('halaman'), kosong: $('kosong'),
            chipEl: $('chip-aktif'), reset: $('atur-ulang'), perHalaman: () => Number($('per-halaman').value), satuan: 'lamaran', baris,
            urut: { kolom: 'tanggal', arah: -1 }, arahAwal: { nama: 1, tanggal: -1 },
            pembanding: { nama: (a, b) => a.nama.localeCompare(b.nama, 'id'), tanggal: (a, b) => a.tanggal.localeCompare(b.tanggal) || a.id.localeCompare(b.id) },
            saring: (l, v) => (!v.q || `${l.nama} ${l.rfid} ${l.posisi} ${l.perusahaan}`.toLowerCase().includes(v.q.trim().toLowerCase()))
                && (!v.status || l.status === v.status) && (!v.komunikasi || l.komunikasi === v.komunikasi) && (!v.prioritas || l.prioritas),
            chip: { status: (v) => `Tahap: ${LABEL[v]}`, komunikasi: (v) => v, prioritas: () => 'Prioritas: Siap Kerja Cepat' },
            setelah: () => {
                const total = rows.length;
                const proses = rows.filter((l) => ['review', 'tes'].includes(l.status)).length;
                const wawancara = rows.filter((l) => l.status === 'wawancara');
                const hasil = rows.filter((l) => ['offering', 'diterima'].includes(l.status)).length;
                const persen = (n) => (total ? Math.round(n / total * 100) : 0);
                $('s-total').textContent = angka(total);
                $('s-proses').textContent = angka(proses);
                $('s-proses').nextElementSibling.textContent = `${persen(proses)}% dari total`;
                $('s-wawancara').textContent = angka(wawancara.length);
                $('s-wawancara').nextElementSibling.textContent = `${wawancara.filter((l) => l.jbi).length} butuh juru bahasa isyarat`;
                $('s-hasil').textContent = angka(hasil);
                $('s-hasil').nextElementSibling.textContent = `${persen(hasil)}% dari total`;
                const lencana = document.getElementById('judul-lencana');
                if (lencana) lencana.textContent = `${angka(total)} Berkas Aktif`;
            },
        });
        $('per-halaman').addEventListener('change', () => daftar.render(true));

        const ubah = (l, sebagian, pesan) => {
            simpan.ubah(l.id, sebagian);
            rows = simpan.gabung(awal.rows);
            beritahu();
            daftar.render();
            toast(pesan, '✅');
        };
        const majukan = (l) => {
            const berikut = URUTAN[URUTAN.indexOf(l.status) + 1];
            ubah(l, { status: berikut, tahap: TAHAP_STATUS[berikut] }, `${l.nama}: ${LABEL[berikut]}.`);
        };

        const detail = (l) => {
            const berikut = URUTAN[URUTAN.indexOf(l.status) + 1];
            bukaDetail({
                inisial: inisial(l.nama), judul: l.nama, sub: `${l.posisi} · ${l.perusahaan}`, lencana: [status(l), ...(l.prioritas ? [badge('Siap kerja cepat', 'teal')] : [])],
                pasangan: [['ID lamaran', l.id], ['ID kartu', l.rfid], ['Tanggal melamar', tanggalJam(l.tanggal)], ['Tahap', `${l.tahap}/4 · ${TAHAP[l.tahap]}`],
                    ['Komunikasi utama', l.komunikasi], ['Juru bahasa isyarat', l.jbi ? 'Perlu disiapkan' : 'Tidak diperlukan'],
                    ['Jalur wawancara', l.jbi ? 'Tatap muka atau video dengan JBI' : 'Teks / chat atau tatap muka'], ['Status', LABEL[l.status]]],
                aksi: [
                    ...(berikut ? [{ teks: `Majukan ke ${LABEL[berikut]}`, klik: () => majukan(l) }] : []),
                    ...(!['ditolak', 'diterima'].includes(l.status) ? [{ teks: 'Tolak Lamaran', gaya: 'bahaya', klik: () => ubah(l, { status: 'ditolak' }, `Lamaran ${l.nama} ditolak.`) }] : []),
                    ...(l.status === 'ditolak' ? [{ teks: 'Buka Kembali', klik: () => ubah(l, { status: 'review', tahap: 1 }, `Lamaran ${l.nama} dibuka kembali.`) }] : []),
                ],
            });
        };

        $('tabel').addEventListener('click', (e) => {
            const l = rows.find((x) => x.id === e.target.closest('tr[data-id]')?.dataset.id);
            if (!l) return;
            if (e.target.closest('[data-detail]')) detail(l);
            if (e.target.closest('[data-maju]')) majukan(l);
        });

        $('buka-sop').addEventListener('click', () => bukaDetail({
            inisial: 'SOP', judul: 'Panduan SOP Wawancara', sub: 'Standar layanan aksesibilitas rekrutmen tunarungu',
            pasangan: [
                ['1. Sebelum wawancara', 'Tanyakan preferensi: juru bahasa isyarat, teks/chat, atau tatap muka. Konfirmasi paling lambat 3 hari sebelumnya.'],
                ['2. Jadwal', 'Beri jeda tambahan 15 menit untuk wawancara dengan JBI. Kirim jadwal dalam bentuk teks.'],
                ['3. Saat wawancara', 'Pewawancara menghadap pelamar, bicara jelas, dan tidak memotong isyarat atau ketikan.'],
                ['4. Wawancara online', 'Aktifkan subtitle langsung dan pastikan JBI terlihat jelas di layar.'],
                ['5. Setelah wawancara', 'Kirim hasil dan langkah berikutnya secara tertulis. Hindari kabar lewat telepon.'],
                ['6. Pencatatan', 'Catat akomodasi yang dipakai agar bisa dipakai lagi di tahap berikutnya.'],
            ],
            aksi: [],
        }));

        $('ekspor').addEventListener('click', () => {
            const data = daftar.hasil();
            if (!data.length) { toast('Tidak ada data untuk diexport.', 'ℹ️'); return; }
            unduhCsv(`rekap-seleksi-${hariIni()}.csv`, [['ID lamaran', 'Pelamar', 'ID kartu', 'Posisi', 'Perusahaan', 'Tanggal melamar', 'Tahap', 'Status', 'Komunikasi', 'Butuh JBI', 'Siap kerja cepat'],
                ...data.map((l) => [l.id, l.nama, l.rfid, l.posisi, l.perusahaan, l.tanggal, TAHAP[l.tahap], LABEL[l.status], l.komunikasi, l.jbi ? 'Ya' : 'Tidak', l.prioritas ? 'Ya' : 'Tidak'])]);
            toast(`${angka(data.length)} lamaran diexport sebagai CSV.`, '⬇️');
        });

        formModal({
            modal: 'modal-tambah', form: 'form-tambah', buka: 'buka-tambah',
            kirim: (d, tutupModal) => {
                const terbesar = Math.max(0, ...rows.map((l) => Number(l.id.split('-').pop())));
                const lw = awal.lowongan[d.lowongan];
                const sekarang = new Date();
                // TODO: kirim ke backend (POST /admin/lamaran) setelah database tersedia
                simpan.tambah({
                    id: `LMR-${String(terbesar + 1).padStart(4, '0')}`, pencariId: null, nama: d.nama.trim(), rfid: 'Belum ada kartu', lowonganId: d.lowongan, posisi: lw.posisi, perusahaan: lw.perusahaan,
                    tanggal: `${hariIni()} ${String(sekarang.getHours()).padStart(2, '0')}:${String(sekarang.getMinutes()).padStart(2, '0')}`,
                    tahap: 1, status: 'review', komunikasi: d.komunikasi, jbi: d.komunikasi === 'BISINDO', prioritas: !!d.prioritas,
                });
                rows = simpan.gabung(awal.rows);
                tutupModal();
                beritahu();
                daftar.render(true);
                toast(`Lamaran ${d.nama.trim()} dicatat dan masuk tahap review.`, '✅');
            },
        });

        const param = new URLSearchParams(location.search);
        if (param.get('q')) $('filter').elements.q.value = param.get('q');
        daftar.render(true);
    })();
</script>
@endpush
