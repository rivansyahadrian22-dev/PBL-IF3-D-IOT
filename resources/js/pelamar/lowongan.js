// Pop up Lamar bertahap, dipakai Beranda, Rekomendasi, Lowongan Kerja, dan Detail Lowongan.
// Pemicu : <x-pelamar.lowongan.lamar :job="$job"> (atribut data-lamar, data-slug, data-posisi, ...)
// Markup : resources/views/pelamar/partials/lamar-modal.blade.php
import { openModal, toast, storage, checkField } from '../shared/ui';

const SENT_KEY = 'tunaker_lamaran_terkirim';
const JUMLAH_LANGKAH = 3;
const $ = (id) => document.getElementById(id);

const modal = $('lamar-modal');
const form = $('form-lamar');

if (modal && form) {
    const terkirim = new Set(storage.get(SENT_KEY) || []);
    const labelAkses = JSON.parse($('lm-akses-label')?.textContent || '{}');
    let job = null;
    let langkah = 0;

    /* ---------- Tombol yang sudah dilamar ---------- */
    const tandaiTerkirim = () => {
        document.querySelectorAll('[data-lamar]').forEach((btn) => {
            if (!terkirim.has(btn.dataset.slug)) return;
            btn.classList.add('is-terkirim');
            btn.setAttribute('aria-disabled', 'true');
            btn.textContent = '✓ Sudah Dilamar';
        });
    };

    /* ---------- Tampilan langkah ---------- */
    const render = (arah = 'next') => {
        modal.querySelectorAll('.lm-step').forEach((el) => {
            const tampil = Number(el.dataset.step) === langkah;
            el.classList.toggle('hidden', !tampil);
            if (tampil) {
                el.classList.remove('anim-next', 'anim-prev');
                void el.offsetWidth;
                el.classList.add(arah === 'next' ? 'anim-next' : 'anim-prev');
            }
        });

        modal.querySelectorAll('.lm-stepper-item').forEach((item, i) => {
            const selesai = i < langkah;
            const aktif = i === langkah;
            const lingkaran = item.querySelector('.lm-circle');
            lingkaran.className = 'lm-circle grid h-8 w-8 place-items-center rounded-full border-2 text-xs font-bold transition ' +
                (selesai ? 'border-teal-500 bg-teal-500 text-white'
                    : aktif ? 'border-navy-900 bg-navy-900 text-white ring-4 ring-navy-900/10'
                    : 'border-slate-200 bg-white text-slate-400');
            lingkaran.textContent = selesai ? '✓' : i + 1;
            item.querySelector('.lm-label').className = 'lm-label hidden text-xs font-semibold sm:inline ' +
                (selesai ? 'text-teal-600' : aktif ? 'text-navy-900' : 'text-slate-400');
        });
        modal.querySelectorAll('.lm-line').forEach((garis, i) => { garis.style.width = i < langkah ? '100%' : '0'; });

        $('lm-kembali').classList.toggle('invisible', langkah === 0);
        $('lm-lanjut-teks').textContent = langkah === JUMLAH_LANGKAH - 1 ? 'Kirim Lamaran' : 'Lanjut';
        if (langkah === JUMLAH_LANGKAH - 1) isiRingkasan();
        modal.querySelector('.overflow-y-auto')?.scrollTo({ top: 0 });
    };

    /* ---------- Ringkasan ---------- */
    const dataForm = () => {
        const fd = new FormData(form);
        return {
            cv: fd.get('cv'), portofolio: fd.get('portofolio'), pesan: (fd.get('pesan') || '').trim(),
            jbi: fd.get('jbi'), kontak: fd.get('kontak'),
        };
    };

    const isiRingkasan = () => {
        const d = dataForm();
        const baris = [
            ['Posisi', `${job.posisi} · ${job.perusahaan}`, 0],
            ['CV', d.cv, 0],
            ['Portofolio', d.portofolio || 'Tidak disertakan', 0],
            ['Pesan', d.pesan || 'Tidak ada pesan', 0],
            ['Juru bahasa wawancara', d.jbi || '—', 1],
            ['Dihubungi lewat', d.kontak, 1],
        ];
        $('lm-ringkasan').replaceChildren(...baris.map(([label, nilai, ke]) => {
            const row = document.createElement('div');
            row.className = 'flex items-start justify-between gap-4 p-3.5';
            row.innerHTML = '<div class="min-w-0"><dt class="text-[11px] font-bold uppercase tracking-wider text-slate-400"></dt><dd class="mt-0.5 break-words text-sm font-semibold text-navy-900"></dd></div>'
                + '<button type="button" class="shrink-0 text-xs font-bold text-teal-600 hover:underline">Ubah</button>';
            row.querySelector('dt').textContent = label;
            row.querySelector('dd').textContent = nilai;
            row.querySelector('button').addEventListener('click', () => { langkah = ke; render('prev'); });
            return row;
        }));
        $('lm-setuju-perusahaan').textContent = job.perusahaan;
    };

    /* ---------- Validasi per langkah ---------- */
    const langkahValid = () => {
        const dilihat = new Set();
        let valid = true;
        modal.querySelectorAll(`.lm-step[data-step="${langkah}"] [required]`).forEach((el) => {
            if (el.type === 'radio') {
                if (dilihat.has(el.name)) return;
                dilihat.add(el.name);
            }
            if (!checkField(el)) valid = false;
        });
        if (!valid) modal.querySelector(`.lm-step[data-step="${langkah}"] .field.is-invalid`)?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return valid;
    };

    form.addEventListener('change', (e) => { if (e.target.closest('.field.is-invalid')) checkField(e.target); });

    $('lm-pesan').addEventListener('input', (e) => { $('lm-hitung').textContent = `${e.target.value.length}/300`; });

    /* ---------- Kirim ---------- */
    const kirim = () => {
        const d = dataForm();
        const tombol = $('lm-lanjut');
        tombol.disabled = true;
        $('lm-spin').classList.remove('hidden');
        $('lm-lanjut-teks').textContent = 'Mengirim…';

        // TODO: kirim lamaran ke backend (POST) — sementara hanya ditandai di browser
        setTimeout(() => {
            terkirim.add(job.slug);
            storage.set(SENT_KEY, [...terkirim]);
            tandaiTerkirim();

            $('lm-sukses-teks').textContent = `${job.posisi} · ${job.perusahaan}`;
            $('lm-sukses-kontak').textContent = d.kontak;
            $('lm-sukses-jbi').textContent = d.jbi === 'Tidak' ? 'kamu akan diundang wawancara.' : 'juru bahasa isyarat akan disiapkan untuk wawancaramu.';

            form.classList.add('hidden');
            $('lm-stepper').classList.add('hidden');
            $('lm-sukses').classList.remove('hidden');
            $('lm-sukses').classList.add('pop-in');

            tombol.disabled = false;
            $('lm-spin').classList.add('hidden');
        }, 900);
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!langkahValid()) return;
        if (langkah < JUMLAH_LANGKAH - 1) {
            langkah++;
            render('next');
            return;
        }
        kirim();
    });

    $('lm-kembali').addEventListener('click', () => { langkah = Math.max(0, langkah - 1); render('prev'); });

    /* ---------- Buka ---------- */
    const buka = (data) => {
        job = data;
        langkah = 0;
        form.reset();
        $('lm-hitung').textContent = '0/300';
        form.querySelectorAll('.field.is-invalid').forEach((f) => f.classList.remove('is-invalid'));
        form.querySelectorAll('.field-error').forEach((p) => p.classList.add('hidden'));

        form.classList.remove('hidden');
        $('lm-stepper').classList.remove('hidden');
        $('lm-sukses').classList.add('hidden');

        $('lm-emoji').textContent = data.emoji;
        $('lm-posisi').textContent = data.posisi;
        $('lm-perusahaan').textContent = data.perusahaan;

        const akses = (data.akses || '').split(' ').filter(Boolean);
        $('lm-akses-info').classList.toggle('hidden', akses.length === 0);
        $('lm-akses-chip').replaceChildren(...akses.map((a) => {
            const span = document.createElement('span');
            span.className = 'rounded-md bg-white px-2 py-1 text-[11px] font-semibold text-teal-600';
            span.textContent = labelAkses[a] ?? a;
            return span;
        }));

        render('next');
        openModal('lamar-modal');
        $('lm-posisi').focus();
    };

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-lamar]');
        if (!btn) return;
        if (btn.classList.contains('is-terkirim')) {
            toast('Kamu sudah melamar posisi ini. Pantau statusnya di Riwayat Lamaran.', '✅');
            return;
        }
        buka({ ...btn.dataset });
    });

    tandaiTerkirim();
}
