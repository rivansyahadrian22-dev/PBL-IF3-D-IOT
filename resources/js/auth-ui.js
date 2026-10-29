// Perilaku UI bersama halaman daftar & masuk: pengaturan tampilan, video BISINDO,
// tombol isyarat per kolom, dan tampilkan kata sandi. Aman dimuat di halaman lain.

export const storage = {
    get(key) { try { return JSON.parse(localStorage.getItem(key)); } catch { return null; } },
    set(key, val) { try { localStorage.setItem(key, JSON.stringify(val)); } catch {} },
    remove(key) { try { localStorage.removeItem(key); } catch {} },
};

/* ---------- Pengaturan tampilan ---------- */
const PREF_KEY = 'tunaker_tampilan';
const fontSizes = { sm: '15px', md: '16px', lg: '18px', xl: '20px' };
const prefs = { size: 'md', hc: false, 'no-motion': false, ...storage.get(PREF_KEY) };

const applyPrefs = () => {
    const root = document.documentElement;
    root.style.fontSize = fontSizes[prefs.size];
    root.classList.toggle('hc', prefs.hc);
    root.classList.toggle('no-motion', prefs['no-motion']);
    document.querySelectorAll('.font-size-btn').forEach((b) => {
        const active = b.dataset.size === prefs.size;
        b.classList.toggle('bg-navy-900', active);
        b.classList.toggle('text-white', active);
        b.classList.toggle('border-navy-900', active);
    });
    document.querySelectorAll('.a11y-toggle').forEach((t) => { t.checked = prefs[t.dataset.opt]; });
    storage.set(PREF_KEY, prefs);
};

const initA11y = () => {
    const panel = document.getElementById('a11y-panel');
    const btn = document.getElementById('a11y-btn');
    if (!panel || !btn) return;

    btn.addEventListener('click', () => {
        const open = panel.classList.toggle('hidden') === false;
        btn.setAttribute('aria-expanded', open);
        if (open) panel.classList.add('pop-in');
    });
    document.querySelectorAll('.font-size-btn').forEach((b) => b.addEventListener('click', () => { prefs.size = b.dataset.size; applyPrefs(); }));
    document.querySelectorAll('.a11y-toggle').forEach((t) => t.addEventListener('change', () => { prefs[t.dataset.opt] = t.checked; applyPrefs(); }));
    document.addEventListener('click', (e) => {
        if (!panel.contains(e.target) && !btn.contains(e.target)) panel.classList.add('hidden');
    });
    applyPrefs();
};

/* ---------- Modal ---------- */
export const openModal = (id) => document.getElementById(id)?.classList.replace('hidden', 'grid');

const closeModal = (modal) => {
    modal.classList.replace('grid', 'hidden');
    modal.querySelector('video')?.pause();
};

const initModals = () => {
    document.querySelectorAll('[data-modal]').forEach((modal) => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal || e.target.closest('.modal-close')) closeModal(modal);
        });
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') document.querySelectorAll('[data-modal].grid').forEach(closeModal);
    });

    const player = document.getElementById('video-player');
    document.querySelectorAll('.video-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            const src = btn.dataset.video;
            document.getElementById('video-judul').textContent = btn.dataset.judul;
            player.classList.toggle('hidden', !src);
            document.getElementById('video-empty').classList.toggle('hidden', !!src);
            if (src) { player.src = src; player.play(); }
            openModal('video-modal');
        });
    });
};

/* ---------- Tombol isyarat per kolom & kata sandi ---------- */
const initFields = () => {
    document.querySelectorAll('.hint-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            const box = btn.parentElement.nextElementSibling;
            const open = box.classList.toggle('hidden') === false;
            btn.setAttribute('aria-expanded', open);
            btn.classList.toggle('bg-teal-500', open);
            btn.classList.toggle('text-white', open);
            if (open) box.classList.add('pop-in');
        });
    });

    document.querySelectorAll('.toggle-password').forEach((btn) => {
        btn.addEventListener('click', () => {
            const input = btn.previousElementSibling;
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    });
};

/* ---------- Validasi kolom dengan pesan jelas ---------- */
const messageFor = (el) => {
    const v = el.validity;
    if (v.valueMissing) {
        if (el.dataset.requiredMsg) return el.dataset.requiredMsg;
        return el.type === 'radio' || el.type === 'checkbox' ? 'Silakan pilih salah satu.' : 'Kolom ini wajib diisi.';
    }
    if (v.typeMismatch && el.type === 'email') return 'Format email belum benar. Contoh: nama@email.com';
    if (v.patternMismatch) return el.dataset.patternMsg || 'Format belum sesuai.';
    if (v.tooShort) return `Minimal ${el.minLength} karakter (sekarang ${el.value.length}).`;
    if (v.customError) return el.validationMessage;
    return '';
};

export const setFieldError = (el, message) => {
    const field = el.closest('.field');
    if (!field) return;
    let box = field.querySelector('.field-error');
    if (!box) {
        box = document.createElement('p');
        box.className = 'field-error mt-1.5 flex items-center gap-1.5 text-xs font-semibold text-red-600';
        field.appendChild(box);
    }
    field.classList.toggle('is-invalid', !!message);
    box.classList.toggle('hidden', !message);
    box.innerHTML = message ? `<span aria-hidden="true">⚠️</span> ${message}` : '';
    if (message) {
        field.classList.remove('shake');
        void field.offsetWidth;
        field.classList.add('shake');
    }
};

export const checkField = (el) => {
    const message = el.checkValidity() ? '' : messageFor(el);
    setFieldError(el, message);
    return !message;
};

/* ---------- Notifikasi visual singkat ---------- */
export const toast = (text, icon = 'ℹ️') => {
    let el = document.getElementById('tunaker-toast');
    if (!el) {
        el = document.createElement('div');
        el.id = 'tunaker-toast';
        el.className = 'pointer-events-none fixed inset-x-0 top-5 z-[60] hidden justify-center px-4';
        el.setAttribute('role', 'status');
        el.innerHTML = '<div class="pop-in flex max-w-md items-center gap-3 rounded-xl bg-navy-900 px-5 py-4 text-sm font-medium text-white shadow-2xl"><span class="text-xl" aria-hidden="true"></span><span></span></div>';
        document.body.appendChild(el);
    }
    const [iconEl, textEl] = el.firstElementChild.children;
    iconEl.textContent = icon;
    textEl.textContent = text;
    el.classList.replace('hidden', 'flex');
    clearTimeout(toast.timer);
    toast.timer = setTimeout(() => el.classList.replace('flex', 'hidden'), 4000);
};

// Dipakai skrip inline halaman (<script type="module">), yang dijalankan setelah modul ini
window.TunakerUI = { storage, openModal, checkField, setFieldError, toast };

initA11y();
initModals();
initFields();
