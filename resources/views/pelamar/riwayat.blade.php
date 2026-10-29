@extends('pelamar.layouts.app')

@section('title', 'Riwayat Lamaran')

@php
    $tahapan = ['Terkirim', 'Review', 'Tes', 'Wawancara', 'Keputusan'];

    $statusInfo = [
        'proses' => ['Sedang Diproses', 'bg-amber-50 text-amber-700 ring-amber-200'],
        'wawancara' => ['Wawancara', 'bg-blue-50 text-blue-700 ring-blue-200'],
        'tawaran' => ['Penawaran Kerja', 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
        'ditolak' => ['Tidak Lolos', 'bg-red-50 text-red-600 ring-red-200'],
    ];

    // CONTOH data — ganti dengan data lamaran pengguna dari database
    $lamaran = [
        ['posisi' => 'UI/UX Designer (Aksesibilitas)', 'perusahaan' => 'PT Kreasi Visual Digital', 'emoji' => '🎨', 'warna' => 'from-pink-500 to-rose-600',
         'tanggal' => '2026-10-20', 'tahap' => 3, 'status' => 'wawancara', 'akomodasi' => 'Juru bahasa BISINDO', 'catatan' => 'Wawancara 24 Okt, 10.00 WIB',
         'riwayat' => [['20 Okt', 'Lamaran terkirim'], ['21 Okt', 'CV lolos review'], ['22 Okt', 'Tes desain selesai, nilai 88'], ['23 Okt', 'Diundang wawancara + juru bahasa disiapkan']]],
        ['posisi' => 'Frontend Web Developer', 'perusahaan' => 'Inovasi Solusi AI', 'emoji' => '💻', 'warna' => 'from-blue-500 to-indigo-600',
         'tanggal' => '2026-10-15', 'tahap' => 4, 'status' => 'tawaran', 'akomodasi' => 'Wawancara via chat', 'catatan' => 'Balas penawaran sebelum 30 Okt',
         'riwayat' => [['15 Okt', 'Lamaran terkirim'], ['16 Okt', 'CV lolos review'], ['18 Okt', 'Tes coding selesai'], ['20 Okt', 'Wawancara via chat'], ['22 Okt', 'Menerima penawaran kerja']]],
        ['posisi' => 'Staff Administrasi & Pengarsipan', 'perusahaan' => 'PT Sinar Jaya Abadi', 'emoji' => '🗂️', 'warna' => 'from-amber-400 to-orange-500',
         'tanggal' => '2026-10-18', 'tahap' => 1, 'status' => 'proses', 'akomodasi' => 'Tes tertulis', 'catatan' => 'CV sedang dibaca HRD',
         'riwayat' => [['18 Okt', 'Lamaran terkirim'], ['19 Okt', 'Lamaran dilihat HRD']]],
        ['posisi' => 'Video Editor & Captioner', 'perusahaan' => 'Pustaka Media Edukasi', 'emoji' => '🎬', 'warna' => 'from-violet-500 to-purple-600',
         'tanggal' => '2026-10-12', 'tahap' => 2, 'status' => 'proses', 'akomodasi' => 'Instruksi + subtitle', 'catatan' => 'Kerjakan tes sebelum 25 Okt',
         'riwayat' => [['12 Okt', 'Lamaran terkirim'], ['14 Okt', 'CV lolos review'], ['21 Okt', 'Tugas tes editing dikirim']]],
        ['posisi' => 'Data Entry Specialist', 'perusahaan' => 'PT Global Logistik Prima', 'emoji' => '⌨️', 'warna' => 'from-teal-500 to-emerald-600',
         'tanggal' => '2026-10-08', 'tahap' => 3, 'status' => 'wawancara', 'akomodasi' => 'Juru bahasa BISINDO', 'catatan' => 'Wawancara 27 Okt, 13.00 WIB',
         'riwayat' => [['8 Okt', 'Lamaran terkirim'], ['10 Okt', 'CV lolos review'], ['15 Okt', 'Tes ketelitian lulus'], ['22 Okt', 'Diundang wawancara']]],
        ['posisi' => 'Customer Service (Chat)', 'perusahaan' => 'PT Layanan Prima', 'emoji' => '💬', 'warna' => 'from-sky-500 to-cyan-600',
         'tanggal' => '2026-10-02', 'tahap' => 3, 'status' => 'ditolak', 'akomodasi' => 'Wawancara via chat', 'catatan' => 'Lihat masukan dari perusahaan',
         'riwayat' => [['2 Okt', 'Lamaran terkirim'], ['4 Okt', 'CV lolos review'], ['7 Okt', 'Tes simulasi chat'], ['12 Okt', 'Wawancara via chat'], ['16 Okt', 'Belum lolos. Masukan: perdalam pengetahuan produk']]],
        ['posisi' => 'Content Creator Inklusi', 'perusahaan' => 'Studio Visual Nusa', 'emoji' => '📱', 'warna' => 'from-fuchsia-500 to-pink-600',
         'tanggal' => '2026-10-21', 'tahap' => 0, 'status' => 'proses', 'akomodasi' => 'Subtitle saat wawancara', 'catatan' => 'Menunggu dibaca perusahaan',
         'riwayat' => [['21 Okt', 'Lamaran terkirim']]],
    ];

    $statistik = [
        ['Total Lamaran', count($lamaran), 'Sejak Oktober 2026', 'bg-navy-900/5 text-navy-900', '📨'],
        ['Dalam Review', collect($lamaran)->where('status', 'proses')->count(), 'Menunggu perusahaan', 'bg-amber-50 text-amber-600', '⏳'],
        ['Wawancara Terjadwal', collect($lamaran)->where('status', 'wawancara')->count(), 'Juru bahasa disiapkan', 'bg-blue-50 text-blue-600', '🤟'],
        ['Penawaran Kerja', collect($lamaran)->where('status', 'tawaran')->count(), 'Segera tanggapi', 'bg-emerald-50 text-emerald-600', '🎉'],
    ];
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-pelamar.halaman.judul judul="Riwayat Lamaran" badge="● Live Tracker"
                     deskripsi="Pantau perkembangan setiap lamaran secara visual, mulai dari terkirim sampai keputusan, lengkap dengan akomodasi yang disiapkan perusahaan.">
        <div class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3">
            <span class="text-2xl" aria-hidden="true">📅</span>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Wawancara terdekat</p>
                <p class="text-sm font-bold text-navy-900">Besok, 10.00 WIB</p>
            </div>
        </div>
        <a href="{{ route('lowongan') }}" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
            Cari Lowongan Baru
        </a>
    </x-pelamar.halaman.judul>

    {{-- ============ STATISTIK ============ --}}
    <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ($statistik as [$label, $angka, $ket, $warna, $emoji])
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $label }}</p>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl {{ $warna }} text-lg" aria-hidden="true">{{ $emoji }}</span>
                </div>
                <p class="mt-2 text-3xl font-extrabold text-navy-900">{{ $angka }}</p>
                <p class="mt-1 text-xs font-semibold text-slate-500">{{ $ket }}</p>
            </div>
        @endforeach
    </section>

    {{-- ============ TABEL ============ --}}
    <section class="rounded-3xl border border-slate-100 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 p-4 sm:p-5 lg:flex-row lg:items-center">
            <div class="flex gap-2 overflow-x-auto pb-1" role="tablist">
                @foreach (['semua' => 'Semua'] + collect($statusInfo)->map(fn ($s) => $s[0])->all() as $kunci => $teks)
                    @php $n = $kunci === 'semua' ? count($lamaran) : collect($lamaran)->where('status', $kunci)->count(); @endphp
                    <button type="button" data-status="{{ $kunci }}"
                            class="status-tab shrink-0 rounded-full border px-3.5 py-1.5 text-xs font-semibold transition {{ $loop->first ? 'border-navy-900 bg-navy-900 text-white' : 'border-slate-200 text-slate-600 hover:border-teal-500' }}">
                        {{ $teks }} ({{ $n }})
                    </button>
                @endforeach
            </div>
            <div class="flex gap-2 lg:ml-auto">
                <input id="cari" type="search" placeholder="Cari posisi atau perusahaan…" class="min-w-0 flex-1 rounded-lg border border-slate-200 px-3.5 py-2 text-sm text-navy-900 placeholder:text-slate-400 focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15 lg:w-60">
                <select id="urutkan" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-navy-900 focus:border-teal-500 focus:outline-none" aria-label="Urutkan">
                    <option value="baru">Terbaru</option>
                    <option value="lama">Terlama</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[56rem] text-left text-sm">
                <thead class="bg-surface text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Perusahaan & Posisi</th>
                        <th class="px-5 py-3">Tgl Melamar</th>
                        <th class="px-5 py-3">Tahapan Seleksi</th>
                        <th class="px-5 py-3">Akomodasi</th>
                        <th class="px-5 py-3">Status Terkini</th>
                        <th class="px-5 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody id="tabel" class="divide-y divide-slate-100">
                    @foreach ($lamaran as $i => $l)
                        @php [$statusTeks, $statusWarna] = $statusInfo[$l['status']]; @endphp
                        <tr class="baris transition hover:bg-surface/60" data-index="{{ $i }}" data-status="{{ $l['status'] }}" data-tanggal="{{ $l['tanggal'] }}"
                            data-cari="{{ strtolower($l['posisi'] . ' ' . $l['perusahaan']) }}">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br {{ $l['warna'] }} text-xl shadow" aria-hidden="true">{{ $l['emoji'] }}</span>
                                    <div class="min-w-0">
                                        <p class="font-bold text-navy-900">{{ $l['posisi'] }}</p>
                                        <p class="text-xs text-slate-500">{{ $l['perusahaan'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">{{ \Carbon\Carbon::parse($l['tanggal'])->locale('id')->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-4">
                                <ol class="flex items-center" aria-label="Tahap {{ $l['tahap'] + 1 }} dari {{ count($tahapan) }}: {{ $tahapan[$l['tahap']] }}">
                                    @foreach ($tahapan as $t => $namaTahap)
                                        @php
                                            $gagal = $l['status'] === 'ditolak' && $t === $l['tahap'] + 1;
                                            $warnaTitik = $t < $l['tahap'] || ($t === $l['tahap'] && $l['status'] === 'tawaran') ? 'bg-teal-500 text-white'
                                                : ($t === $l['tahap'] ? 'bg-navy-900 text-white ring-4 ring-navy-900/15'
                                                : ($gagal ? 'bg-red-500 text-white' : 'bg-slate-200 text-slate-400'));
                                        @endphp
                                        <li class="flex items-center">
                                            <span class="grid h-6 w-6 place-items-center rounded-full text-[10px] font-bold {{ $warnaTitik }}" title="{{ $namaTahap }}">
                                                {{ $gagal ? '✕' : ($t < $l['tahap'] || ($t === $l['tahap'] && $l['status'] === 'tawaran') ? '✓' : $t + 1) }}
                                            </span>
                                            @unless ($loop->last)
                                                <span class="h-0.5 w-4 {{ $t < $l['tahap'] ? 'bg-teal-500' : 'bg-slate-200' }}"></span>
                                            @endunless
                                        </li>
                                    @endforeach
                                </ol>
                                <p class="mt-1.5 text-[11px] font-semibold text-slate-500">{{ $tahapan[$l['tahap']] }}</p>
                            </td>
                            <td class="px-5 py-4"><span class="whitespace-nowrap rounded-md bg-teal-50 px-2 py-1 text-[11px] font-semibold text-teal-600">{{ $l['akomodasi'] }}</span></td>
                            <td class="px-5 py-4">
                                <span class="inline-block whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold ring-1 {{ $statusWarna }}">{{ $statusTeks }}</span>
                                <p class="mt-1 text-[11px] text-slate-500">{{ $l['catatan'] }}</p>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button type="button" class="detail-lamaran rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-navy-900 transition hover:border-navy-900">Detail</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p id="kosong" class="hidden p-10 text-center text-sm">Tidak ada lamaran dengan status ini.</p>
        <div class="flex items-center justify-between border-t border-slate-100 px-5 py-4 text-xs text-slate-500">
            <p>Menampilkan <b id="jumlah" class="text-navy-900">{{ count($lamaran) }}</b> dari {{ count($lamaran) }} lamaran</p>
            <p class="hidden sm:block">Status diperbarui otomatis oleh perusahaan</p>
        </div>
    </section>

    {{-- ============ HAK AKSESIBILITAS ============ --}}
    <section class="flex flex-col gap-4 rounded-3xl border border-teal-100 bg-teal-50 p-5 sm:flex-row sm:items-center sm:p-6">
        <span class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-white text-3xl shadow-sm" aria-hidden="true">🛡️</span>
        <div class="flex-1">
            <h2 class="font-extrabold text-navy-900">Hak Aksesibilitas Wawancara Teman Tuli</h2>
            <p class="mt-1 text-sm">Kamu berhak meminta Juru Bahasa Isyarat (JBI), wawancara lewat chat, atau subtitle saat wawancara online. TUNAKER akan membantu menghubungi perusahaan.</p>
        </div>
        <button type="button" id="minta-jbi" class="shrink-0 rounded-lg bg-navy-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-navy-800">Minta Fasilitas JBI</button>
    </section>
</div>

{{-- ============ MODAL DETAIL LAMARAN ============ --}}
<div id="lamaran-modal" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm">
    <div class="pop-in w-full max-w-lg overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-start gap-4 bg-gradient-to-br from-navy-900 to-navy-700 p-6 text-white">
            <span id="m-emoji" class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-white/10 text-2xl ring-1 ring-white/20" aria-hidden="true"></span>
            <div class="min-w-0 flex-1">
                <h2 id="m-posisi" class="text-lg font-extrabold"></h2>
                <p id="m-perusahaan" class="text-sm text-slate-300"></p>
            </div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-300 hover:bg-white/10 hover:text-white" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="max-h-[60vh] overflow-y-auto p-6">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Perjalanan lamaran</h3>
            <ol id="m-riwayat" class="relative mt-4 space-y-5 border-l-2 border-teal-100 pl-6"></ol>
            <p id="m-akomodasi" class="mt-6 rounded-xl bg-teal-50 p-3 text-sm font-semibold text-teal-700"></p>
        </div>
        <div class="flex gap-3 border-t border-slate-100 p-4">
            <button type="button" class="modal-close flex-1 rounded-lg border border-slate-200 py-3 text-sm font-semibold text-navy-900">Tutup</button>
            <a href="{{ route('konsultasi') }}" class="flex-1 rounded-lg bg-navy-900 py-3 text-center text-sm font-semibold text-white transition hover:bg-teal-600">Tanya AI soal lamaran ini</a>
        </div>
    </div>
</div>

<script type="application/json" id="data-lamaran">@json($lamaran)</script>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { openModal, toast } = window.TunakerUI;
        const lamaran = JSON.parse(document.getElementById('data-lamaran').textContent);
        const tabel = document.getElementById('tabel');
        const baris = [...tabel.querySelectorAll('.baris')];
        let status = 'semua';

        const terapkan = () => {
            const kata = document.getElementById('cari').value.trim().toLowerCase();
            const urut = document.getElementById('urutkan').value;
            const tampil = baris.filter((b) => (status === 'semua' || b.dataset.status === status) && (!kata || b.dataset.cari.includes(kata)));
            tampil.sort((a, b) => urut === 'baru' ? b.dataset.tanggal.localeCompare(a.dataset.tanggal) : a.dataset.tanggal.localeCompare(b.dataset.tanggal));
            baris.forEach((b) => b.classList.add('hidden'));
            tampil.forEach((b) => { tabel.appendChild(b); b.classList.remove('hidden'); });
            document.getElementById('jumlah').textContent = tampil.length;
            document.getElementById('kosong').classList.toggle('hidden', tampil.length > 0);
        };

        document.querySelectorAll('.status-tab').forEach((btn) => {
            btn.addEventListener('click', () => {
                status = btn.dataset.status;
                document.querySelectorAll('.status-tab').forEach((b) => {
                    const aktif = b === btn;
                    b.classList.toggle('border-navy-900', aktif);
                    b.classList.toggle('bg-navy-900', aktif);
                    b.classList.toggle('text-white', aktif);
                    b.classList.toggle('border-slate-200', !aktif);
                    b.classList.toggle('text-slate-600', !aktif);
                });
                terapkan();
            });
        });
        document.getElementById('cari').addEventListener('input', terapkan);
        document.getElementById('urutkan').addEventListener('change', terapkan);

        baris.forEach((b) => {
            b.querySelector('.detail-lamaran').addEventListener('click', () => {
                const l = lamaran[b.dataset.index];
                document.getElementById('m-emoji').textContent = l.emoji;
                document.getElementById('m-posisi').textContent = l.posisi;
                document.getElementById('m-perusahaan').textContent = l.perusahaan;
                document.getElementById('m-akomodasi').textContent = `Akomodasi: ${l.akomodasi}`;
                document.getElementById('m-riwayat').replaceChildren(...l.riwayat.map(([tgl, teks], i) => {
                    const li = document.createElement('li');
                    li.className = 'relative';
                    const terakhir = i === l.riwayat.length - 1;
                    li.innerHTML = `<span class="absolute -left-[33px] top-0.5 grid h-4 w-4 place-items-center rounded-full ${terakhir ? 'bg-navy-900 ring-4 ring-navy-900/15' : 'bg-teal-500'}"></span>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400"></p><p class="text-sm font-semibold text-navy-900"></p>`;
                    li.children[1].textContent = tgl;
                    li.children[2].textContent = teks;
                    return li;
                }));
                openModal('lamaran-modal');
            });
        });

        document.getElementById('minta-jbi').addEventListener('click', () => {
            // TODO: kirim permintaan JBI ke backend
            toast('Permintaan JBI belum terkirim. Backend belum disambungkan.', '🤟');
        });

        terapkan();
    })();
</script>
@endpush
