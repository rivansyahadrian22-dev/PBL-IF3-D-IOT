// Bantuan bersama halaman admin: lencana, perubahan sementara di browser, daftar berfilter,
// pop up detail, formulir pop up, dan unduh CSV. Dipakai lewat window.TunakerAdmin oleh skrip inline di resources/views/admin/*.
// TODO: ganti penyimpanan di browser dengan panggilan ke backend setelah database tersedia.
import { storage, toast, openModal, checkField } from '../shared/ui';

/* ------------------------------------------------------------------ Teks & tampilan */

export const STATUS = {
    menunggu: ['Menunggu Verifikasi', 'bg-amber-50 text-amber-700 ring-amber-200'],
    terverifikasi: ['Terverifikasi', 'bg-blue-50 text-blue-700 ring-blue-200'],
    bekerja: ['Sudah Bekerja', 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
    ditolak: ['Ditolak', 'bg-red-50 text-red-600 ring-red-200'],
};

const NADA = {
    amber: 'bg-amber-50 text-amber-700 ring-amber-200',
    biru: 'bg-blue-50 text-blue-700 ring-blue-200',
    hijau: 'bg-emerald-50 text-emerald-700 ring-emerald-200',
    merah: 'bg-red-50 text-red-600 ring-red-200',
    abu: 'bg-slate-100 text-slate-600 ring-slate-200',
    ungu: 'bg-violet-50 text-violet-700 ring-violet-200',
    teal: 'bg-teal-50 text-teal-700 ring-teal-200',
};

export const esc = (nilai) => String(nilai ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]);

export const badge = (teks, nada = 'abu') =>
    `<span class="inline-block whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold ring-1 ${NADA[nada] ?? NADA.abu}">${esc(teks)}</span>`;

export const lencana = (status) => {
    const [teks, kelas] = STATUS[status] ?? STATUS.menunggu;
    return `<span class="inline-block whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold ring-1 ${kelas}">${teks}</span>`;
};

export const inisial = (nama) => String(nama).trim().split(/\s+/).slice(0, 2).map((k) => k[0]?.toUpperCase() ?? '').join('');

export const angka = (n) => Number(n).toLocaleString('id-ID');

export const tanggal = (iso) => {
    if (!iso) return '-';
    const [y, m, d] = iso.slice(0, 10).split('-').map(Number);
    return new Date(y, m - 1, d).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
};

export const tanggalJam = (iso) => (iso ? `${tanggal(iso)}, ${iso.slice(11, 16)} WIB` : '-');

export const tutup = (el) => el.classList.replace('grid', 'hidden');

export const beritahu = () => window.dispatchEvent(new Event('tunaker-admin-berubah'));

/* ------------------------------------------------------------------ Penyimpanan sementara di browser */

const KUNCI_STATUS = 'tunaker_admin_status';
const KUNCI_BARU = 'tunaker_admin_baru';
const KUNCI_BEKERJA = 'tunaker_admin_bekerja';
const KUNCI_TERISI = 'tunaker_admin_terisi';
const KUNCI_ALASAN = 'tunaker_admin_alasan';

export const dataAdmin = {
    status: () => storage.get(KUNCI_STATUS) || {},
    ubahStatus(ids, status) {
        const semua = this.status();
        [].concat(ids).forEach((id) => { semua[id] = status; });
        storage.set(KUNCI_STATUS, semua);
    },
    // Tanggal mulai bekerja yang dicatat admin di browser ini: { idPencari: 'YYYY-MM-DD' }
    bekerja: () => storage.get(KUNCI_BEKERJA) || {},
    catatBekerja(id, tgl) {
        storage.set(KUNCI_BEKERJA, { ...this.bekerja(), [id]: tgl });
    },
    // Alasan penolakan yang ditulis admin di browser ini: { idPencari: 'teks' }
    alasan: () => storage.get(KUNCI_ALASAN) || {},
    catatAlasan(id, teks) {
        storage.set(KUNCI_ALASAN, { ...this.alasan(), [id]: teks });
    },
    // Tambahan kursi terisi per lowongan dari lamaran yang diterima di browser ini: { idLowongan: jumlah }
    terisi: () => storage.get(KUNCI_TERISI) || {},
    tambahTerisi(idLowongan) {
        const t = this.terisi();
        t[idLowongan] = (t[idLowongan] ?? 0) + 1;
        storage.set(KUNCI_TERISI, t);
    },
    baru: () => storage.get(KUNCI_BARU) || [],
    tambahBaru(baris) {
        storage.set(KUNCI_BARU, [baris, ...this.baru()]);
    },
    // Jumlah pencari yang masih menunggu verifikasi, termasuk perubahan yang dibuat admin di browser ini
    hitungMenunggu(idMenunggu) {
        const ubah = this.status();
        const dariDaftar = idMenunggu.filter((id) => (ubah[id] ?? 'menunggu') === 'menunggu').length;
        const dariBaru = this.baru().filter((r) => (ubah[r.id] ?? r.status) === 'menunggu').length;
        return dariDaftar + dariBaru;
    },
};

/** Pencari kerja (data bawaan + pendaftar baru) dengan status terkini, disaring menurut status yang diizinkan. */
export const pencariBerstatus = (awal, boleh) => {
    const ubah = dataAdmin.status();
    const bekerja = dataAdmin.bekerja();
    return [...dataAdmin.baru(), ...awal]
        .map((r) => ({ ...r, status: ubah[r.id] ?? r.status, bekerja: bekerja[r.id] ?? r.bekerja }))
        .filter((r) => boleh.includes(r.status));
};

/** Isi datalist dengan pilihan pencari; mengembalikan fungsi yang mencari pencari dari teks pilihan. */
export const isiPilihanPencari = (datalist, daftar) => {
    const label = (p) => `${p.nama} · ${p.id}`;
    datalist.innerHTML = daftar.map((p) => `<option value="${esc(label(p))}"></option>`).join('');
    return (teks) => daftar.find((p) => label(p) === String(teks).trim());
};

/**
 * Jumlah item yang masih berstatus `status`, memperhitungkan perubahan dan data baru dari admin di browser ini.
 * @param {string[]} idAwal  ID item yang berstatus itu di data bawaan server
 * @param {string} kunci     kunci penyimpanan halaman terkait, mis. 'tunaker_admin_perusahaan'
 */
export const hitungAntrean = (idAwal, kunci, status) => {
    const s = { ubah: {}, baru: [], ...(storage.get(kunci) || {}) };
    const dariAwal = idAwal.filter((id) => (s.ubah[id]?.status ?? status) === status).length;
    const dariBaru = s.baru.filter((r) => (s.ubah[r.id]?.status ?? r.status) === status).length;
    return dariAwal + dariBaru;
};

/** Penyimpanan perubahan per halaman: { ubah: {id: {...}}, baru: [...] } */
export const simpanan = (kunci) => ({
    baca: () => ({ ubah: {}, baru: [], ...(storage.get(kunci) || {}) }),
    tulis: (nilai) => storage.set(kunci, nilai),
    ubah(id, sebagian) {
        const s = this.baca();
        s.ubah[id] = { ...(s.ubah[id] || {}), ...sebagian };
        this.tulis(s);
    },
    tambah(baris) {
        const s = this.baca();
        s.baru = [baris, ...s.baru];
        this.tulis(s);
    },
    // gabungkan data bawaan server dengan perubahan di browser
    gabung(awal) {
        const s = this.baca();
        return [...s.baru, ...awal].map((r) => (s.ubah[r.id] ? { ...r, ...s.ubah[r.id] } : r));
    },
});

/* ------------------------------------------------------------------ CSV */

// Pemisah titik koma dipakai karena Excel berbahasa Indonesia membaca CSV dengan pemisah itu.
export const unduhCsv = (namaFile, baris) => {
    const sel = (nilai) => {
        const teks = String(nilai ?? '');
        return /[";\n\r]/.test(teks) ? `"${teks.replace(/"/g, '""')}"` : teks;
    };
    const isi = '﻿' + baris.map((r) => r.map(sel).join(';')).join('\r\n');
    const url = URL.createObjectURL(new Blob([isi], { type: 'text/csv;charset=utf-8' }));
    const a = Object.assign(document.createElement('a'), { href: url, download: namaFile });
    document.body.appendChild(a);
    a.click();
    a.remove();
    setTimeout(() => URL.revokeObjectURL(url), 1000);
};

export const hariIni = () => new Date().toLocaleDateString('sv-SE');

/* ------------------------------------------------------------------ Pop up detail umum */

const GAYA_TOMBOL = {
    utama: 'bg-navy-900 text-white hover:bg-teal-600 px-5',
    bahaya: 'border border-red-200 text-red-600 hover:bg-red-50 px-4',
    netral: 'border border-slate-200 text-navy-900 hover:border-navy-900 px-4',
};

/**
 * Buka pop up detail (markup di admin/partials/modal-detail.blade.php).
 * @param {{inisial?: string, judul: string, sub?: string, lencana?: string[], pasangan: [string, string][], aksi?: {teks: string, gaya?: string, klik: Function}[]}} o
 */
export const bukaDetail = (o) => {
    const $ = (id) => document.getElementById(id);
    $('md-inisial').textContent = o.inisial ?? inisial(o.judul);
    $('md-judul').textContent = o.judul;
    $('md-sub').textContent = o.sub ?? '';
    $('md-lencana').innerHTML = (o.lencana ?? []).join('');
    $('md-isi').innerHTML = o.pasangan.map(([k, v]) =>
        `<div><dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400">${esc(k)}</dt><dd class="mt-0.5 break-words text-sm font-semibold text-navy-900">${esc(v)}</dd></div>`).join('');

    const wadah = $('md-aksi');
    wadah.innerHTML = '';
    (o.aksi ?? []).forEach((a) => {
        const b = document.createElement('button');
        b.type = 'button';
        b.textContent = a.teks;
        b.className = `rounded-lg py-2.5 text-sm font-semibold transition ${GAYA_TOMBOL[a.gaya ?? 'utama']}`;
        b.addEventListener('click', () => { tutup($('md')); a.klik(); });
        wadah.appendChild(b);
    });
    wadah.insertAdjacentHTML('beforeend', `<button type="button" class="modal-close rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">Tutup</button>`);

    openModal('md');
    $('md-judul').focus();
};

/* ------------------------------------------------------------------ Formulir pop up */

/**
 * Hubungkan tombol pembuka, formulir, dan validasi untuk pop up tambah data.
 * Kolom wajib memakai atribut required di dalam pembungkus .field.
 */
export const formModal = ({ modal, form, buka, kirim }) => {
    const m = document.getElementById(modal);
    const f = document.getElementById(form);
    const bersihkan = () => {
        f.reset();
        f.querySelectorAll('.field.is-invalid').forEach((x) => x.classList.remove('is-invalid'));
        f.querySelectorAll('.field-error').forEach((p) => p.classList.add('hidden'));
    };

    document.getElementById(buka).addEventListener('click', () => {
        bersihkan();
        openModal(modal);
        f.querySelector('input:not([type=hidden]), select, textarea')?.focus();
    });
    const periksaUlang = (e) => { if (e.target.closest('.field.is-invalid')) checkField(e.target); };
    f.addEventListener('input', periksaUlang);
    f.addEventListener('change', periksaUlang);
    f.addEventListener('submit', (e) => {
        e.preventDefault();
        const salah = [...f.querySelectorAll('[required]')].filter((el) => !checkField(el));
        if (salah.length) { salah[0].focus(); return; }
        kirim(Object.fromEntries(new FormData(f)), () => tutup(m));
    });
};

/* ------------------------------------------------------------------ Daftar berfilter */

/**
 * Daftar dengan filter, urutan, label filter aktif, dan nomor halaman.
 * Dipakai untuk tabel maupun kartu: `wadah` menerima HTML dari `baris(row)`.
 */
export const buatDaftar = (o) => {
    let urut = { ...(o.urut ?? { kolom: null, arah: 1 }) };
    let halaman = 1;

    const nilai = () => Object.fromEntries(new FormData(o.form));
    const ambilRows = () => (typeof o.rows === 'function' ? o.rows() : o.rows);
    const perHalaman = () => (typeof o.perHalaman === 'function' ? o.perHalaman() : o.perHalaman);

    const hasil = () => {
        const v = nilai();
        const daftar = ambilRows().filter((r) => o.saring(r, v));
        const banding = o.pembanding?.[urut.kolom];
        return banding ? daftar.sort((a, b) => urut.arah * banding(a, b)) : daftar;
    };

    const navHalaman = (nav, total) => {
        nav.innerHTML = '';
        const tombol = (label, ke, pilih = false, mati = false) => {
            const b = document.createElement('button');
            b.type = 'button';
            b.textContent = label;
            b.disabled = mati;
            b.className = 'grid h-9 min-w-9 place-items-center rounded-lg px-2.5 text-xs font-bold transition disabled:opacity-40 ' + (pilih ? 'bg-navy-900 text-white' : 'border border-slate-200 text-navy-900 hover:border-teal-500');
            if (pilih) b.setAttribute('aria-current', 'page');
            b.addEventListener('click', () => { halaman = ke; render(); o.wadah.scrollIntoView?.({ block: 'nearest' }); });
            nav.appendChild(b);
        };
        if (total <= 1) return;
        tombol('←', halaman - 1, false, halaman === 1);
        let terakhir = 0;
        [...new Set([1, total, halaman - 1, halaman, halaman + 1])].filter((n) => n >= 1 && n <= total).sort((a, b) => a - b).forEach((n) => {
            if (n - terakhir > 1) nav.insertAdjacentHTML('beforeend', '<span class="px-1 text-slate-400" aria-hidden="true">…</span>');
            tombol(n, n, n === halaman);
            terakhir = n;
        });
        tombol('→', halaman + 1, false, halaman === total);
    };

    const renderChip = () => {
        if (!o.chip || !o.chipEl) return;
        const v = nilai();
        o.chipEl.innerHTML = '';
        Object.entries(o.chip).forEach(([nama, label]) => {
            if (!v[nama]) return;
            const teks = label(v[nama]);
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.className = 'inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold text-white';
            chip.textContent = `${teks} `;
            chip.insertAdjacentHTML('beforeend', '<span aria-hidden="true">✕</span>');
            chip.setAttribute('aria-label', `Hapus filter ${teks}`);
            chip.addEventListener('click', () => { o.form.elements[nama].value = ''; render(true); });
            o.chipEl.appendChild(chip);
        });
        if (!o.chipEl.children.length) o.chipEl.innerHTML = '<span class="text-xs text-slate-400">Tidak ada</span>';
    };

    const render = (reset = false) => {
        if (reset) halaman = 1;
        const semua = hasil();
        const per = perHalaman();
        const total = Math.max(1, Math.ceil(semua.length / per));
        halaman = Math.min(halaman, total);
        const tampil = semua.slice((halaman - 1) * per, halaman * per);

        o.wadah.innerHTML = tampil.map(o.baris).join('');
        o.kosong?.classList.toggle('hidden', semua.length > 0);
        if (o.info) {
            o.info.textContent = semua.length
                ? `Menampilkan ${(halaman - 1) * per + 1}–${(halaman - 1) * per + tampil.length} dari ${angka(semua.length)} ${o.satuan ?? 'data'}`
                : 'Tidak ada data';
        }
        if (o.nav) navHalaman(o.nav, total);

        (o.tabel ?? document).querySelectorAll('[data-urut]').forEach((b) => {
            const th = b.closest('th');
            const aktif = b.dataset.urut === urut.kolom;
            th?.setAttribute('aria-sort', aktif ? (urut.arah === 1 ? 'ascending' : 'descending') : 'none');
            const panah = b.querySelector('[data-panah]');
            if (panah) panah.textContent = aktif ? (urut.arah === 1 ? '↑' : '↓') : '';
        });

        renderChip();
        o.setelah?.(tampil, semua);
    };

    (o.tabel ?? document).querySelectorAll('[data-urut]').forEach((b) => b.addEventListener('click', () => {
        urut = { kolom: b.dataset.urut, arah: urut.kolom === b.dataset.urut ? -urut.arah : (o.arahAwal?.[b.dataset.urut] ?? 1) };
        render(true);
    }));

    let tunda;
    o.form.addEventListener('input', (e) => {
        if (e.target.matches('input[type=search], input[type=text]')) { clearTimeout(tunda); tunda = setTimeout(() => render(true), 200); }
    });
    o.form.addEventListener('change', (e) => { if (!e.target.matches('input[type=search], input[type=text]')) render(true); });
    o.reset?.addEventListener('click', () => {
        HTMLFormElement.prototype.reset.call(o.form);
        o.form.querySelectorAll('input[data-bersih]').forEach((i) => { i.value = ''; }); // kolom tersembunyi tidak ikut tereset oleh form.reset()
        render(true);
    });

    return { render, hasil, ke: (n) => { halaman = n; render(); } };
};

/* ------------------------------------------------------------------ Ekspor ke window */

window.TunakerAdmin = {
    STATUS, esc, badge, lencana, inisial, angka, tanggal, tanggalJam, tutup, beritahu, hariIni,
    dataAdmin, pencariBerstatus, isiPilihanPencari, simpanan, hitungAntrean, unduhCsv, bukaDetail, formModal, buatDaftar, toast,
};
