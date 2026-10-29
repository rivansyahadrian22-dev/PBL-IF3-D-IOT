// Chat Konsultasi AI bersama (Beranda & halaman Konsultasi AI).
// Markup: [data-chat] > [data-chat-log] + form[data-chat-form]; tombol [data-chat-ask="..."] di mana saja.
// TODO: ganti jawaban contoh dengan panggilan ke ai-service (FastAPI) setelah endpoint chat tersedia.

const jawaban = [
    [/(cocok|lowongan|pekerjaan|kerja apa)/, 'Berdasarkan profilmu, posisi <b>Staff Administrasi</b> (95% cocok) dan <b>Desainer Grafis</b> (92%) paling sesuai. Keduanya menyediakan interview BISINDO.'],
    [/(cv|resume)/, 'Tips CV untuk teman Tuli:<br>1) Tulis keahlian utama di bagian atas<br>2) Cantumkan pelatihan & sertifikat<br>3) Sebutkan cara komunikasi yang kamu sukai, misalnya BISINDO atau chat.'],
    [/(wawancara|interview)/, 'Saat melamar, pilih opsi <b>butuh juru bahasa isyarat</b>. Siapkan juga portofolio supaya kemampuanmu langsung terlihat. Mau latihan tanya-jawab wawancara lewat teks?'],
    [/(gaji|upah|salary)/, 'Kisaran gaji Desainer Grafis junior di Bandung sekitar <b>Rp 5 – 7,5 jt</b> per bulan. Untuk posisi remote biasanya sedikit lebih tinggi.'],
    [/(hak|akomodasi|aksesib)/, 'Kamu berhak meminta <b>akomodasi yang layak</b> (UU No. 8 Tahun 2016), misalnya juru bahasa isyarat saat wawancara, instruksi tertulis, dan alarm visual.'],
    [/(pelatihan|kursus|belajar)/, 'Kelas yang cocok untukmu: <b>UI/UX Design Dasar</b> dan <b>Microsoft Excel Lanjutan</b>. Keduanya punya video BISINDO dan sertifikat.'],
];
const jawabanLain = 'Fitur tanya jawab ini masih dalam pengembangan. Coba pilih salah satu topik cepat.';

const escapeHtml = (s) => s.replace(/[<>&"]/g, (c) => ({ '<': '&lt;', '>': '&gt;', '&': '&amp;', '"': '&quot;' })[c]);
const jam = () => new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

const initChat = (root) => {
    const log = root.querySelector('[data-chat-log]');
    const form = root.querySelector('[data-chat-form]');
    const input = form.querySelector('input, textarea');

    const bubble = (html, dariUser) => {
        const el = document.createElement('div');
        el.className = `pop-in flex flex-col gap-1 ${dariUser ? 'items-end self-end' : 'items-start'} max-w-[85%]`;
        el.innerHTML = `<div class="rounded-2xl p-3 text-sm leading-relaxed shadow-sm ${dariUser ? 'rounded-tr-sm bg-navy-900 text-white' : 'rounded-tl-sm bg-white text-navy-900'}">${html}</div>`
            + `<span class="px-1 text-[10px] text-slate-400">${dariUser ? 'Kamu' : 'Asisten AI'} · ${jam()}</span>`;
        log.appendChild(el);
        log.scrollTop = log.scrollHeight;
        return el.firstElementChild;
    };

    const kirim = (teks) => {
        if (!teks.trim()) return;
        bubble(escapeHtml(teks), true);
        const balasan = bubble('<span class="inline-flex gap-1 py-1"><span class="h-2 w-2 animate-bounce rounded-full bg-slate-400"></span><span class="h-2 w-2 animate-bounce rounded-full bg-slate-400 [animation-delay:.15s]"></span><span class="h-2 w-2 animate-bounce rounded-full bg-slate-400 [animation-delay:.3s]"></span></span>', false);
        const t = teks.toLowerCase();
        setTimeout(() => {
            balasan.innerHTML = (jawaban.find(([pola]) => pola.test(t)) || [, jawabanLain])[1];
            log.scrollTop = log.scrollHeight;
        }, 900);
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        kirim(input.value);
        input.value = '';
    });
    input.addEventListener('keydown', (e) => {
        if (input.tagName === 'TEXTAREA' && e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.requestSubmit();
        }
    });

    root.kirimPesan = kirim;
};

document.querySelectorAll('[data-chat]').forEach(initChat);

document.querySelectorAll('[data-chat-ask]').forEach((btn) => {
    btn.addEventListener('click', () => document.querySelector('[data-chat]')?.kirimPesan(btn.dataset.chatAsk || btn.textContent.trim()));
});
