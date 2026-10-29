@extends('admin.layouts.app')

@section('title', 'Pengaturan Sistem')

@php
    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $labelKecil = 'mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500';
    $kartu = 'rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6';

    $tab = [
        'aksesibilitas' => 'Aksesibilitas & Tuli',
        'perangkat' => 'Perangkat Smart ID & Gate',
        'jbi' => 'Integrasi JBI & Subtitle',
        'keamanan' => 'Keamanan & Hak Akses',
        'notifikasi' => 'Notifikasi Visual',
    ];

    // CONTOH peran admin — ganti dengan data dari database
    $peran = [
        ['super', 'Super Administrator', 'Akses penuh ke seluruh panel dan pengaturan', ['kartu' => true, 'lowongan' => true, 'verifikasi' => true, 'laporan' => true]],
        ['verifikator', 'Verifikator Pencari Kerja', 'Memeriksa identitas dan dokumen pencari kerja', ['kartu' => false, 'lowongan' => false, 'verifikasi' => true, 'laporan' => false]],
        ['kemitraan', 'Petugas Kemitraan Perusahaan', 'Mengelola perusahaan mitra dan lowongan', ['kartu' => false, 'lowongan' => true, 'verifikasi' => false, 'laporan' => true]],
    ];
    $izin = ['kartu' => 'Kelola kartu RFID', 'lowongan' => 'Kelola lowongan', 'verifikasi' => 'Verifikasi pencari kerja', 'laporan' => 'Lihat laporan'];
@endphp

@section('content')
<div class="mx-auto max-w-5xl space-y-6 pb-4">
    <x-admin.judul judul="Pengaturan & Konfigurasi Sistem TUNAKER" crumb="Pengaturan Sistem"
                   deskripsi="Atur preferensi aksesibilitas bagi pengguna tunarungu, integrasi perangkat Smart ID, layanan juru bahasa isyarat, serta keamanan dan hak akses admin.">
        <button type="button" id="default" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">Kembalikan Default</button>
        <button type="submit" form="form-pengaturan" class="simpan inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">Simpan Perubahan</button>
    </x-admin.judul>

    <div class="flex gap-2 overflow-x-auto border-b border-slate-200 pb-px" role="tablist" aria-label="Kelompok pengaturan">
        @foreach ($tab as $kunci => $teks)
            <button type="button" role="tab" id="tab-{{ $kunci }}" data-tab="{{ $kunci }}" aria-controls="panel-{{ $kunci }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    class="tab-btn -mb-px shrink-0 border-b-2 px-4 py-3 text-sm font-bold transition {{ $loop->first ? 'border-navy-900 text-navy-900' : 'border-transparent text-slate-500 hover:text-navy-900' }}">{{ $teks }}</button>
        @endforeach
    </div>

    <form id="form-pengaturan" class="space-y-6" novalidate>

        {{-- ---------- 1. AKSESIBILITAS ---------- --}}
        <section id="panel-aksesibilitas" role="tabpanel" aria-labelledby="tab-aksesibilitas" class="panel space-y-6">
            <div class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">1</span> Standar Aksesibilitas & Tampilan Visual</h2>
                <p class="mt-1 text-sm">Berlaku untuk seluruh halaman pencari kerja dan perusahaan.</p>
                <div class="mt-5 space-y-3">
                    <x-admin.saklar name="kontras_otomatis" judul="Mode kontras tinggi otomatis" ket="Terapkan kontras tinggi dan garis tepi tegas untuk semua pengguna yang memilih tampilan ini di perangkatnya." :aktif="true" />
                    <x-admin.saklar name="indikator_visual" judul="Indikator visual menggantikan nada notifikasi" ket="Notifikasi memakai kedipan layar atau getar, bukan hanya suara." :aktif="true" />
                    <x-admin.saklar name="subtitle_wajib" judul="Wajib subtitle pada semua video" ket="Video yang diunggah tanpa subtitle akan ditandai perlu diperbaiki." :aktif="true" />
                </div>
                <fieldset class="mt-6">
                    <legend class="{{ $labelKecil }}">Standar bahasa isyarat utama</legend>
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach (['bisindo' => ['BISINDO (Bahasa Isyarat Indonesia)', 'Bahasa isyarat yang dipakai komunitas Tuli sehari-hari.'], 'sibi' => ['SIBI (Sistem Isyarat Bahasa Indonesia)', 'Sistem isyarat baku yang dipakai di sekolah.']] as $nilai => [$judul, $ket])
                            <label class="block cursor-pointer">
                                <input type="radio" name="standar_isyarat" value="{{ $nilai }}" @checked($nilai === 'bisindo') class="peer sr-only">
                                <span class="block rounded-xl border border-slate-200 p-4 transition hover:border-teal-500 peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15">
                                    <span class="block text-sm font-bold text-navy-900">{{ $judul }}</span>
                                    <span class="mt-0.5 block text-xs text-slate-500">{{ $ket }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
                <div class="mt-6 max-w-xs">
                    <label for="ukuran_teks" class="{{ $labelKecil }}">Ukuran teks bawaan</label>
                    <select id="ukuran_teks" name="ukuran_teks" class="{{ $input }}"><option value="sedang" selected>Sedang (16 px)</option><option value="besar">Besar (18 px)</option><option value="sangat-besar">Sangat besar (20 px)</option></select>
                </div>
            </div>
        </section>

        {{-- ---------- 2. PERANGKAT ---------- --}}
        <section id="panel-perangkat" role="tabpanel" aria-labelledby="tab-perangkat" class="panel hidden space-y-6">
            <div class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">2</span> Integrasi Hardware Smart ID & RFID Reader</h2>
                <p class="mt-1 text-sm">Sinkronisasi pembaca kartu di gate dengan sistem TUNAKER.</p>
                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="field sm:col-span-2">
                        <label for="endpoint_reader" class="{{ $labelKecil }}">Alamat endpoint gateway RFID</label>
                        <input id="endpoint_reader" name="endpoint_reader" type="url" required pattern="https://.+" data-pattern-msg="Alamat harus diawali https:// supaya data kartu terenkripsi." value="https://gate.tunaker.id/api/v1/tap-id" class="{{ $input }} font-mono">
                        <p class="mt-1.5 text-xs text-slate-500">Reader mengirim UID kartu ke alamat ini setiap kali ditempelkan.</p>
                    </div>
                    <div class="field"><label for="polling" class="{{ $labelKecil }}">Frekuensi pembacaan sensor</label>
                        <select id="polling" name="polling" class="{{ $input }}"><option value="1">Setiap 1 detik (disarankan)</option><option value="2">Setiap 2 detik</option><option value="5">Setiap 5 detik</option></select></div>
                    <div class="field"><label for="timeout_tap" class="{{ $labelKecil }}">Batas waktu respons tap</label>
                        <select id="timeout_tap" name="timeout_tap" class="{{ $input }}"><option value="3">3 detik</option><option value="5" selected>5 detik</option><option value="10">10 detik</option></select></div>
                </div>
                <div class="mt-5 space-y-3">
                    <x-admin.saklar name="validasi_lowongan" judul="Validasi otomatis lamaran satu tap" ket="Tap kartu di gate langsung mengirim lamaran dengan CV dan preferensi komunikasi dari profil." :aktif="true" />
                    <x-admin.saklar name="umpan_balik_visual" judul="Umpan balik visual di reader" ket="Lampu hijau menyala saat kartu terbaca, lampu merah saat ditolak. Tanpa bunyi." :aktif="true" />
                </div>
            </div>
        </section>

        {{-- ---------- 3. JBI ---------- --}}
        <section id="panel-jbi" role="tabpanel" aria-labelledby="tab-jbi" class="panel hidden space-y-6">
            <div class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">3</span> Layanan Juru Bahasa Isyarat & Subtitle Otomatis</h2>
                <p class="mt-1 text-sm">Pengaturan kapasitas juru bahasa dan platform wawancara online.</p>
                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="field"><label for="kapasitas_jbi" class="{{ $labelKecil }}">Kapasitas JBI per sesi wawancara</label>
                        <input id="kapasitas_jbi" name="kapasitas_jbi" type="number" min="1" max="50" required value="5" class="{{ $input }}"></div>
                    <div class="field"><label for="platform_video" class="{{ $labelKecil }}">Platform video wawancara</label>
                        <select id="platform_video" name="platform_video" class="{{ $input }}"><option>Google Meet</option><option>Zoom</option><option>Microsoft Teams</option><option>Ruang video TUNAKER</option></select></div>
                    <div class="field"><label for="pengingat_jbi" class="{{ $labelKecil }}">Konfirmasi JBI sebelum wawancara</label>
                        <select id="pengingat_jbi" name="pengingat_jbi" class="{{ $input }}"><option value="1">1 hari sebelumnya</option><option value="3" selected>3 hari sebelumnya</option><option value="7">7 hari sebelumnya</option></select></div>
                </div>
                <div class="mt-5 space-y-3">
                    <x-admin.saklar name="subtitle_otomatis" judul="Buat subtitle otomatis saat wawancara online" ket="Teks percakapan muncul langsung di layar untuk pelamar yang memilih jalur teks." :aktif="true" />
                    <x-admin.saklar name="rekomendasi_otomatis" judul="Gunakan pencocokan otomatis untuk rekomendasi lowongan" ket="Sistem mencocokkan keahlian dan cara komunikasi pencari kerja dengan lowongan yang tersedia." :aktif="true" />
                </div>
            </div>
        </section>

        {{-- ---------- 4. KEAMANAN ---------- --}}
        <section id="panel-keamanan" role="tabpanel" aria-labelledby="tab-keamanan" class="panel hidden space-y-6">
            <div class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">4</span> Manajemen Pengguna & Hak Akses Admin</h2>
                <p class="mt-1 text-sm">Atur siapa yang boleh mengakses bagian tertentu di panel admin.</p>
                <div class="mt-5 overflow-x-auto rounded-2xl border border-slate-100">
                    <table class="w-full min-w-[40rem] text-left text-sm">
                        <caption class="sr-only">Hak akses per peran admin</caption>
                        <thead class="bg-surface text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th scope="col" class="px-4 py-3">Peran</th>
                                @foreach ($izin as $label)<th scope="col" class="px-3 py-3 text-center">{{ $label }}</th>@endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($peran as [$kode, $nama, $ket, $akses])
                                <tr>
                                    <th scope="row" class="px-4 py-3.5 font-normal"><p class="font-bold text-navy-900">{{ $nama }}</p><p class="text-xs text-slate-500">{{ $ket }}</p></th>
                                    @foreach ($izin as $kunci => $label)
                                        <td class="px-3 py-3.5 text-center">
                                            <label class="inline-flex cursor-pointer">
                                                <input type="checkbox" name="izin_{{ $kode }}_{{ $kunci }}" @checked($akses[$kunci]) @disabled($kode === 'super') aria-label="{{ $nama }}: {{ $label }}" class="h-5 w-5 rounded border-slate-300 accent-teal-600 disabled:opacity-50">
                                            </label>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-2 text-xs text-slate-500">Hak akses Super Administrator tidak bisa diubah.</p>
                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div class="field"><label for="sesi" class="{{ $labelKecil }}">Sesi admin berakhir otomatis</label>
                        <select id="sesi" name="sesi" class="{{ $input }}"><option value="30">Setelah 30 menit tidak aktif</option><option value="60" selected>Setelah 60 menit tidak aktif</option><option value="120">Setelah 2 jam tidak aktif</option></select></div>
                </div>
                <div class="mt-5 space-y-3">
                    <x-admin.saklar name="verifikasi_dua_langkah" judul="Wajib verifikasi dua langkah untuk admin" ket="Admin memasukkan kode tambahan yang dikirim lewat email atau aplikasi autentikator saat masuk." :aktif="false" />
                    <x-admin.saklar name="samarkan_nik" judul="Samarkan NIK di seluruh tampilan admin" ket="Hanya 4 digit terakhir yang terlihat, kecuali Super Administrator." :aktif="true" />
                </div>
            </div>
        </section>

        {{-- ---------- 5. NOTIFIKASI ---------- --}}
        <section id="panel-notifikasi" role="tabpanel" aria-labelledby="tab-notifikasi" class="panel hidden space-y-6">
            <div class="{{ $kartu }}">
                <h2 class="flex items-center gap-3 text-lg font-extrabold text-navy-900"><span class="grid h-8 w-8 place-items-center rounded-full bg-navy-900 text-sm text-white">5</span> Notifikasi Visual</h2>
                <p class="mt-1 text-sm">Cara sistem memberi kabar kepada pencari kerja. Semua berupa teks atau tanda visual.</p>
                <div class="mt-5 space-y-3">
                    <x-admin.saklar name="notif_kedip" judul="Kedip layar dan getar untuk kabar penting" ket="Misalnya undangan wawancara atau penawaran kerja." :aktif="true" />
                    <x-admin.saklar name="notif_whatsapp" judul="Kirim kabar lewat WhatsApp (teks)" ket="Tidak ada panggilan suara." :aktif="true" />
                    <x-admin.saklar name="notif_email" judul="Kirim kabar lewat email" :aktif="true" />
                    <x-admin.saklar name="ringkasan_harian" judul="Ringkasan harian untuk admin" ket="Rekap pencari kerja menunggu verifikasi dan lamaran baru, dikirim tiap pagi." :aktif="false" />
                </div>
                <div class="field mt-5">
                    <label for="templat_undangan" class="{{ $labelKecil }}">Templat teks undangan wawancara</label>
                    <textarea id="templat_undangan" name="templat_undangan" rows="3" maxlength="300" class="{{ $input }}">Halo {nama}, kamu diundang wawancara untuk posisi {posisi} pada {tanggal}. Juru bahasa isyarat sudah disiapkan. Balas pesan ini untuk konfirmasi.</textarea>
                    <p class="mt-1.5 text-xs text-slate-500">Kata dalam kurung kurawal akan diganti otomatis: {nama}, {posisi}, {tanggal}.</p>
                </div>
            </div>
        </section>
    </form>

    <div class="sticky bottom-4 z-20 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white/95 p-4 shadow-xl backdrop-blur print:hidden">
        <p id="terakhir" class="text-sm text-slate-500">Belum ada pengaturan yang disimpan.</p>
        <div class="flex gap-3">
            <button type="button" id="batal" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">Batal Perubahan</button>
            <button type="submit" form="form-pengaturan" class="simpan rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-teal-600">Simpan Konfigurasi Sistem</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { storage, toast, checkField } = window.TunakerUI;
        const { bukaDetail, tanggalJam } = window.TunakerAdmin;
        const $ = (id) => document.getElementById(id);
        const form = $('form-pengaturan');
        const KUNCI = 'tunaker_admin_pengaturan';
        let kotor = false;

        const ambil = () => {
            const hasil = {};
            [...form.elements].forEach((el) => {
                if (!el.name) return;
                if (el.type === 'checkbox') hasil[el.name] = el.checked;
                else if (el.type === 'radio') { if (el.checked) hasil[el.name] = el.value; }
                else hasil[el.name] = el.value;
            });
            return hasil;
        };
        const terapkan = (nilai) => {
            [...form.elements].forEach((el) => {
                if (!el.name || !(el.name in nilai)) return;
                if (el.type === 'checkbox') el.checked = !!nilai[el.name];
                else if (el.type === 'radio') el.checked = el.value === nilai[el.name];
                else el.value = nilai[el.name];
            });
        };

        const bawaan = ambil();
        const tersimpan = storage.get(KUNCI);
        if (tersimpan?.nilai) terapkan(tersimpan.nilai);

        const tampilkanTerakhir = (iso) => {
            const waktu = iso ? new Date(iso) : null;
            $('terakhir').textContent = waktu
                ? `Terakhir disimpan: ${waktu.toLocaleString('id-ID', { weekday: 'long', hour: '2-digit', minute: '2-digit' })} WIB oleh Admin TUNAKER`
                : 'Belum ada pengaturan yang disimpan.';
        };
        tampilkanTerakhir(tersimpan?.disimpan);

        /* ---------- Tab ---------- */
        const bukaTab = (kunci) => {
            document.querySelectorAll('.tab-btn').forEach((b) => {
                const pilih = b.dataset.tab === kunci;
                b.setAttribute('aria-selected', pilih);
                b.classList.toggle('border-navy-900', pilih); b.classList.toggle('text-navy-900', pilih);
                b.classList.toggle('border-transparent', !pilih); b.classList.toggle('text-slate-500', !pilih);
            });
            document.querySelectorAll('.panel').forEach((p) => p.classList.toggle('hidden', p.id !== `panel-${kunci}`));
        };
        document.querySelectorAll('.tab-btn').forEach((b) => b.addEventListener('click', () => bukaTab(b.dataset.tab)));

        /* ---------- Perubahan, simpan, batal, default ---------- */
        form.addEventListener('input', (e) => { kotor = true; if (e.target.closest('.field.is-invalid')) checkField(e.target); });
        form.addEventListener('change', (e) => { kotor = true; if (e.target.closest('.field.is-invalid')) checkField(e.target); });
        window.addEventListener('beforeunload', (e) => { if (kotor) { e.preventDefault(); e.returnValue = ''; } });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const salah = [...form.querySelectorAll('[required]')].filter((el) => !checkField(el));
            if (salah.length) {
                bukaTab(salah[0].closest('.panel').id.replace('panel-', ''));
                salah[0].focus();
                toast(`Ada ${salah.length} kolom yang perlu diperbaiki.`, '⚠️');
                return;
            }
            // TODO: kirim ke backend (PUT /admin/pengaturan) setelah tersedia; sementara disimpan di browser ini
            const sekarang = new Date().toISOString();
            storage.set(KUNCI, { nilai: ambil(), disimpan: sekarang });
            tampilkanTerakhir(sekarang);
            kotor = false;
            toast('Konfigurasi disimpan di browser ini. Backend belum tersambung.', '✅');
        });

        $('batal').addEventListener('click', () => {
            terapkan(storage.get(KUNCI)?.nilai ?? bawaan);
            form.querySelectorAll('.field.is-invalid').forEach((f) => f.classList.remove('is-invalid'));
            form.querySelectorAll('.field-error').forEach((p) => p.classList.add('hidden'));
            kotor = false;
            toast('Perubahan yang belum disimpan dibatalkan.', 'ℹ️');
        });

        $('default').addEventListener('click', () => bukaDetail({
            inisial: '↺', judul: 'Kembalikan ke Pengaturan Default', sub: 'Semua kelompok pengaturan akan diatur ulang',
            pasangan: [['Yang terjadi', 'Semua nilai kembali ke pengaturan bawaan sistem.'], ['Disimpan?', 'Belum. Kamu masih perlu menekan Simpan untuk menerapkannya.']],
            aksi: [{ teks: 'Kembalikan Default', gaya: 'bahaya', klik: () => { terapkan(bawaan); kotor = true; toast('Nilai default dipulihkan. Tekan Simpan untuk menerapkan.', 'ℹ️'); } }],
        }));
    })();
</script>
@endpush
