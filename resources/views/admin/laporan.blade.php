@extends('admin.layouts.app')

@section('title', 'Statistik & Laporan')

@php
    $input = 'rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-navy-900 focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-admin.judul judul="Statistik & Laporan Ketenagakerjaan Inklusif" crumb="Statistik & Laporan"
                   deskripsi="Ringkasan penyerapan kerja, ragam komunikasi, dan kepatuhan fasilitas kerja untuk penyandang tunarungu. Pilih periode untuk menghitung ulang semua angka.">
        <label class="flex items-center gap-2 text-sm print:hidden">
            <span class="font-semibold text-slate-500">Periode</span>
            <select id="periode" class="{{ $input }}">
                <option value="semua">Semua waktu</option>
                <option value="tahun">Tahun ini</option>
                <option value="90">90 hari terakhir</option>
                <option value="30">30 hari terakhir</option>
            </select>
        </label>
        <button type="button" id="cetak" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900 print:hidden">
            <x-admin.ikon nama="cetak" class="h-4 w-4" tebal="2" /> Cetak PDF Report
        </button>
        <button type="button" id="ekspor" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800 print:hidden">
            <x-admin.ikon nama="unduh" class="h-4 w-4" tebal="2" /> Export Lengkap (CSV)
        </button>
    </x-admin.judul>

    <p id="keterangan-periode" class="-mt-2 text-sm font-semibold text-slate-500"></p>

    {{-- ============ KPI ============ --}}
    <section id="kpi" class="grid grid-cols-2 gap-4 xl:grid-cols-4" aria-label="Indikator utama"></section>

    {{-- ============ PENEMPATAN & KOMUNIKASI ============ --}}
    <section class="grid gap-6 xl:grid-cols-[1fr_22rem]">
        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-lg font-extrabold text-navy-900">Performa Penempatan Talenta per Bidang Pekerjaan</h2>
            <p class="text-sm">Jumlah yang sudah bekerja dibandingkan dengan pencari kerja yang terverifikasi di tiap bidang.</p>
            <ul id="bidang" class="mt-5 space-y-4"></ul>
            <div class="mt-5 flex flex-wrap gap-5 text-xs font-semibold text-navy-900">
                <span class="inline-flex items-center gap-2"><span class="h-3 w-6 rounded bg-teal-500"></span> Sudah bekerja</span>
                <span class="inline-flex items-center gap-2"><span class="h-3 w-6 rounded bg-slate-200"></span> Terverifikasi (belum bekerja)</span>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-lg font-extrabold text-navy-900">Ragam Komunikasi Kerja</h2>
            <p class="text-sm">Cara berkomunikasi utama pencari kerja pada periode ini.</p>
            <div class="relative mx-auto mt-4 h-44 w-44">
                <svg id="donut" viewBox="0 0 36 36" class="h-full w-full -rotate-90" role="img" aria-label="Diagram donut ragam komunikasi"></svg>
                <div class="pointer-events-none absolute inset-0 grid place-items-center text-center">
                    <div><p id="donut-total" class="text-3xl font-extrabold text-navy-900"></p><p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Pencari kerja</p></div>
                </div>
            </div>
            <ul id="donut-legenda" class="mt-5 space-y-2.5 text-sm"></ul>
        </div>
    </section>

    {{-- ============ AUDIT ============ --}}
    <section class="rounded-3xl border border-slate-100 bg-white shadow-sm">
        <div class="p-5 sm:p-6">
            <h2 class="text-lg font-extrabold text-navy-900">Audit Kepatuhan Kuota & Fasilitas Kerja per Sektor</h2>
            <p class="text-sm">Membandingkan kuota lowongan yang dibuka dengan jumlah pelamar yang diterima, serta perusahaan yang sudah ramah tunarungu.</p>
        </div>
        <div class="overflow-x-auto border-t border-slate-100">
            <table class="w-full min-w-[52rem] text-left text-sm">
                <caption class="sr-only">Audit kepatuhan per sektor</caption>
                <thead class="bg-surface text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3">Sektor industri</th>
                        <th scope="col" class="px-3 py-3">Mitra aktif</th>
                        <th scope="col" class="px-3 py-3">Ramah tunarungu</th>
                        <th scope="col" class="px-3 py-3">Kuota lowongan</th>
                        <th scope="col" class="px-3 py-3">Diterima</th>
                        <th scope="col" class="px-3 py-3">Pemenuhan</th>
                        <th scope="col" class="px-5 py-3">Status</th>
                    </tr>
                </thead>
                <tbody id="audit" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>
        <p id="audit-info" class="border-t border-slate-100 px-5 py-4 text-xs text-slate-500 sm:px-6"></p>
    </section>
</div>

@php $dataJson = App\Support\Admin\ContohOperasional::laporan(); @endphp
<script type="application/json" id="data-halaman">@json($dataJson)</script>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { esc, badge, angka, tanggal, unduhCsv, hariIni, dataAdmin, simpanan } = window.TunakerAdmin;
        const { toast } = window.TunakerUI;
        const $ = (id) => document.getElementById(id);
        const D = JSON.parse($('data-halaman').textContent);
        // Samakan dengan perubahan admin di browser ini: status pencari, tanggal mulai bekerja, dan tahap lamaran
        const statusLokal = dataAdmin.status();
        const bekerjaLokal = dataAdmin.bekerja();
        D.pencari = [...dataAdmin.baru(), ...D.pencari].map((p) => ({ ...p, status: statusLokal[p.id] ?? p.status, bekerja: bekerjaLokal[p.id] ?? p.bekerja }));
        D.lamaran = simpanan('tunaker_admin_lamaran').gabung(D.lamaran).map((l) => ({ ...l, tanggal: l.tanggal.slice(0, 10) }));
        const TARGET_PENYERAPAN = 40;
        const WARNA_DONUT = ['#0b2545', '#14a3a6', '#3b82f6', '#f59e0b'];
        const persen = (a, b) => (b ? a / b * 100 : 0);
        const fmt = (n, d = 1) => Number(n).toFixed(d).replace('.', ',');
        let hasil = null;

        const mulaiPeriode = (pilihan) => {
            const sekarang = new Date();
            if (pilihan === 'tahun') return `${sekarang.getFullYear()}-01-01`;
            if (pilihan === '90' || pilihan === '30') {
                const d = new Date(sekarang); d.setDate(d.getDate() - Number(pilihan));
                return d.toLocaleDateString('sv-SE');
            }
            return '';
        };

        const hitung = (pilihan) => {
            const mulai = mulaiPeriode(pilihan);
            const dalam = (tgl) => !mulai || tgl >= mulai;

            const pencari = D.pencari.filter((p) => dalam(p.daftar));
            const terverifikasi = pencari.filter((p) => ['terverifikasi', 'bekerja'].includes(p.status));
            const bekerja = pencari.filter((p) => p.status === 'bekerja');
            const hariRekrut = bekerja.map((p) => (new Date(p.bekerja) - new Date(p.daftar)) / 86400000);

            const mitra = D.perusahaan.filter((p) => p.status === 'aktif');
            const lamaran = D.lamaran.filter((l) => dalam(l.tanggal));
            const diterima = lamaran.filter((l) => l.status === 'diterima');

            const bidang = [...new Set(D.pencari.map((p) => p.bidang))].sort().map((nama) => {
                const t = terverifikasi.filter((p) => p.bidang === nama).length;
                const k = bekerja.filter((p) => p.bidang === nama).length;
                return { nama, terverifikasi: t, bekerja: k };
            }).sort((a, b) => persen(b.bekerja, b.terverifikasi) - persen(a.bekerja, a.terverifikasi));

            const komunikasi = D.komunikasi.map((nama) => ({ nama, jumlah: pencari.filter((p) => p.komunikasi === nama).length }));

            const sektorLowongan = Object.fromEntries(D.lowongan.map((l) => [l.id, l.sektor]));
            const audit = [...new Set([...D.perusahaan.map((p) => p.sektor), ...D.lowongan.map((l) => l.sektor)])].sort().map((sektor) => {
                const mitraSektor = mitra.filter((p) => p.sektor === sektor);
                const kuota = D.lowongan.filter((l) => l.sektor === sektor && ['aktif', 'review'].includes(l.status)).reduce((a, l) => a + l.kuota, 0);
                const terima = diterima.filter((l) => sektorLowongan[l.lowonganId] === sektor).length;
                return { sektor, mitra: mitraSektor.length, ramah: mitraSektor.filter((p) => p.ramah).length, kuota, diterima: terima, pemenuhan: kuota ? Math.min(100, terima / kuota * 100) : null };
            }).filter((r) => r.mitra || r.kuota).sort((a, b) => (b.pemenuhan ?? -1) - (a.pemenuhan ?? -1));

            return {
                mulai, pencari: pencari.length, terverifikasi: terverifikasi.length, bekerja: bekerja.length,
                penyerapan: persen(bekerja.length, terverifikasi.length),
                rataHari: hariRekrut.length ? hariRekrut.reduce((a, b) => a + b, 0) / hariRekrut.length : null,
                mitraAktif: mitra.length, mitraRamah: mitra.filter((p) => p.ramah).length,
                lamaran: lamaran.length, diterima: diterima.length, bidang, komunikasi, audit,
            };
        };

        const statusAudit = (p) => (p === null ? badge('Belum ada kuota', 'abu') : p >= 60 ? badge('Sesuai target', 'hijau') : p >= 30 ? badge('Perlu perhatian', 'amber') : badge('Di bawah target', 'merah'));

        const render = () => {
            const h = hasil;
            $('keterangan-periode').textContent = `Periode: ${h.mulai ? `${tanggal(h.mulai)} sampai ${tanggal(new Date().toLocaleDateString('sv-SE'))}` : 'seluruh data'} · ${angka(h.pencari)} pencari kerja terdaftar pada periode ini`;

            const kartu = [
                { judul: 'Penyerapan Kerja', nilai: `${fmt(h.penyerapan)}%`, ket: `${angka(h.bekerja)} dari ${angka(h.terverifikasi)} yang terverifikasi sudah bekerja`, bar: h.penyerapan, target: `Target ${TARGET_PENYERAPAN}%`, ikon: 'bg-teal-50 text-teal-600' },
                { judul: 'Rata-rata Waktu Rekrutmen', nilai: h.rataHari === null ? '-' : `${Math.round(h.rataHari)} Hari`, ket: 'Dari mendaftar sampai mulai bekerja', bar: null, ikon: 'bg-blue-50 text-blue-600' },
                { judul: 'Perusahaan Ramah Tunarungu', nilai: `${fmt(persen(h.mitraRamah, h.mitraAktif))}%`, ket: `${h.mitraRamah} dari ${h.mitraAktif} mitra aktif (kondisi saat ini)`, bar: persen(h.mitraRamah, h.mitraAktif), ikon: 'bg-violet-50 text-violet-600' },
                { judul: 'Lamaran Diterima', nilai: `${fmt(persen(h.diterima, h.lamaran))}%`, ket: `${angka(h.diterima)} dari ${angka(h.lamaran)} lamaran pada periode ini`, bar: persen(h.diterima, h.lamaran), ikon: 'bg-emerald-50 text-emerald-600' },
            ];
            $('kpi').innerHTML = kartu.map((k) => `
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">${k.judul}</p>
                    <p class="mt-2 text-3xl font-extrabold text-navy-900">${k.nilai}</p>
                    ${k.bar === null ? '' : `<div class="relative mt-3 h-2 overflow-hidden rounded-full bg-slate-100" role="progressbar" aria-valuenow="${Math.round(k.bar)}" aria-valuemin="0" aria-valuemax="100">
                        <div class="h-full rounded-full bg-gradient-to-r from-teal-500 to-navy-800" style="width:${Math.min(k.bar, 100)}%"></div>
                        ${k.target ? `<span class="absolute inset-y-0 w-0.5 bg-red-500" style="left:${TARGET_PENYERAPAN}%" title="${k.target}"></span>` : ''}</div>`}
                    <p class="mt-2 text-xs font-semibold text-slate-500">${k.ket}${k.target ? ` · <span class="text-red-600">${k.target}</span>` : ''}</p>
                </div>`).join('');

            const maks = Math.max(...h.bidang.map((b) => b.terverifikasi), 1);
            $('bidang').innerHTML = h.bidang.map((b) => {
                const belum = b.terverifikasi - b.bekerja;
                return `<li>
                    <div class="flex items-baseline justify-between gap-3 text-sm"><span class="font-bold text-navy-900">${esc(b.nama)}</span>
                        <span class="text-xs font-semibold text-slate-500">${b.bekerja} bekerja dari ${b.terverifikasi} terverifikasi · <b class="text-teal-600">${fmt(persen(b.bekerja, b.terverifikasi), 0)}%</b></span></div>
                    <div class="mt-1.5 flex h-3 overflow-hidden rounded-full bg-slate-100" style="width:${Math.max(persen(b.terverifikasi, maks), 4)}%" role="img" aria-label="${b.bekerja} bekerja, ${belum} belum bekerja">
                        <span class="bg-teal-500" style="width:${persen(b.bekerja, b.terverifikasi)}%"></span><span class="bg-slate-200" style="width:${persen(belum, b.terverifikasi)}%"></span></div></li>`;
            }).join('') || '<li class="text-sm text-slate-500">Belum ada data pada periode ini.</li>';

            const total = h.komunikasi.reduce((a, k) => a + k.jumlah, 0);
            let geser = 0;
            $('donut-total').textContent = angka(total);
            $('donut').innerHTML = '<circle cx="18" cy="18" r="15.9155" fill="none" stroke="#f1f5f9" stroke-width="4.5"/>' + h.komunikasi.map((k, i) => {
                const bagian = persen(k.jumlah, total);
                const panjang = Math.max(bagian - 0.8, 0);
                const el = `<circle cx="18" cy="18" r="15.9155" fill="none" stroke="${WARNA_DONUT[i]}" stroke-width="4.5" stroke-dasharray="${panjang} ${100 - panjang}" stroke-dashoffset="${-geser}"/>`;
                geser += bagian;
                return el;
            }).join('');
            $('donut-legenda').innerHTML = h.komunikasi.map((k, i) => `<li class="flex items-center gap-3"><span class="h-3 w-3 shrink-0 rounded-sm" style="background:${WARNA_DONUT[i]}" aria-hidden="true"></span>
                <span class="flex-1 font-medium text-navy-900">${esc(k.nama)}</span><span class="text-slate-500">${angka(k.jumlah)}</span><span class="w-12 text-right font-bold text-navy-900">${Math.round(persen(k.jumlah, total))}%</span></li>`).join('');

            $('audit').innerHTML = h.audit.map((r) => `<tr class="transition hover:bg-surface/60">
                <td class="px-5 py-3.5 font-bold text-navy-900">${esc(r.sektor)}</td>
                <td class="px-3 py-3.5">${r.mitra}</td>
                <td class="px-3 py-3.5">${r.ramah} <span class="text-xs text-slate-400">(${fmt(persen(r.ramah, r.mitra), 0)}%)</span></td>
                <td class="px-3 py-3.5">${r.kuota}</td>
                <td class="px-3 py-3.5">${r.diterima}</td>
                <td class="px-3 py-3.5">${r.pemenuhan === null ? '<span class="text-slate-400">-</span>' : `<div class="flex items-center gap-2"><div class="h-2 w-24 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-teal-500" style="width:${r.pemenuhan}%"></div></div><span class="text-xs font-bold text-navy-900">${fmt(r.pemenuhan, 0)}%</span></div>`}</td>
                <td class="px-5 py-3.5">${statusAudit(r.pemenuhan)}</td></tr>`).join('');
            $('audit-info').textContent = `Pemenuhan = jumlah pelamar diterima dibagi total kuota lowongan aktif di sektor itu. Batas penilaian: 60% atau lebih sesuai target, 30–59% perlu perhatian, di bawah 30% di bawah target.`;
        };

        const ganti = () => { hasil = hitung($('periode').value); render(); };
        $('periode').addEventListener('change', ganti);
        $('cetak').addEventListener('click', () => window.print());

        $('ekspor').addEventListener('click', () => {
            const h = hasil;
            unduhCsv(`laporan-ketenagakerjaan-${hariIni()}.csv`, [
                ['Statistik & Laporan Ketenagakerjaan Inklusif', hariIni()], ['Periode', $('periode').selectedOptions[0].textContent], [],
                ['Indikator', 'Nilai'],
                ['Pencari kerja terdaftar', h.pencari], ['Terverifikasi', h.terverifikasi], ['Sudah bekerja', h.bekerja], ['Penyerapan kerja (%)', fmt(h.penyerapan)],
                ['Rata-rata waktu rekrutmen (hari)', h.rataHari === null ? '' : Math.round(h.rataHari)], ['Mitra aktif', h.mitraAktif], ['Mitra ramah tunarungu', h.mitraRamah],
                ['Lamaran', h.lamaran], ['Lamaran diterima', h.diterima], [],
                ['Bidang pekerjaan', 'Terverifikasi', 'Sudah bekerja'], ...h.bidang.map((b) => [b.nama, b.terverifikasi, b.bekerja]), [],
                ['Komunikasi utama', 'Jumlah'], ...h.komunikasi.map((k) => [k.nama, k.jumlah]), [],
                ['Sektor', 'Mitra aktif', 'Ramah tunarungu', 'Kuota', 'Diterima', 'Pemenuhan (%)'], ...h.audit.map((r) => [r.sektor, r.mitra, r.ramah, r.kuota, r.diterima, r.pemenuhan === null ? '' : fmt(r.pemenuhan, 0)]),
            ]);
            toast('Laporan lengkap diunduh sebagai CSV.', '⬇️');
        });

        ganti();
    })();
</script>
@endpush
