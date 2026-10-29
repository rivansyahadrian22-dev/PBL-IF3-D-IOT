@extends('layouts.app')

@section('title', 'Lowongan Kerja')

@php
    $akses = config('tunaker.akses');

    // Data contoh ada di config/lowongan.php — ganti dengan data lowongan dari database
    $lowongan = config('lowongan.data');

    $tipeKerja = ['Full Time', 'Part Time', 'Remote', 'Hybrid', 'Magang'];
    $lokasi = collect($lowongan)->pluck('lokasi')->unique()->sort()->values();
    $select = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="grid items-end gap-4 lg:grid-cols-[1fr_auto]">
        <x-halaman.judul judul="Lowongan Kerja" badge="✓ Aksesibilitas 100% Visual"
                         deskripsi="Temukan lowongan dari perusahaan yang memahami dan mendukung kebutuhan teman Tuli, lengkap dengan informasi akomodasi kerjanya." />

        {{-- Kartu Smart ID --}}
        <div class="relative flex items-center gap-4 overflow-hidden rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 p-4 pr-5 text-white">
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-teal-500/30 blur-2xl" aria-hidden="true"></div>
            <span class="relative grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-white/10 text-2xl ring-1 ring-white/20" aria-hidden="true">💳</span>
            <div class="relative">
                <p class="text-[11px] font-bold uppercase tracking-widest text-teal-500">Smart ID Terhubung</p>
                <p class="text-sm font-extrabold">Lamaran Cepat Sekali Klik Aktif</p>
            </div>
            <a href="{{ route('profil') }}" class="relative ml-2 shrink-0 rounded-lg bg-teal-500 px-3 py-2 text-xs font-bold transition hover:bg-teal-600">Cek Detail</a>
        </div>
    </div>

    {{-- ============ FILTER ============ --}}
    <form id="form-filter" class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:p-5" onsubmit="return false">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-[repeat(4,1fr)_auto]">
            <label class="block">
                <span class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Tipe pekerjaan</span>
                <select name="tipe" class="{{ $select }}">
                    <option value="">Semua tipe</option>
                    @foreach ($tipeKerja as $t)<option>{{ $t }}</option>@endforeach
                </select>
            </label>
            <label class="block">
                <span class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Lokasi kerja</span>
                <select name="lokasi" class="{{ $select }}">
                    <option value="">Semua lokasi</option>
                    @foreach ($lokasi as $l)<option>{{ $l }}</option>@endforeach
                </select>
            </label>
            <label class="block">
                <span class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Fasilitas ramah Tuli</span>
                <select name="akses" class="{{ $select }}">
                    <option value="">Semua fasilitas</option>
                    @foreach ($akses as $kunci => $teks)<option value="{{ $kunci }}">{{ $teks }}</option>@endforeach
                </select>
            </label>
            <label class="block">
                <span class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Rentang gaji</span>
                <select name="gaji" class="{{ $select }}">
                    <option value="">Semua rentang</option>
                    <option value="0-4">Di bawah Rp 4 jt</option>
                    <option value="4-6">Rp 4 – 6 jt</option>
                    <option value="6-99">Di atas Rp 6 jt</option>
                </select>
            </label>
            <button type="submit" class="inline-flex items-center justify-center gap-2 self-end rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-navy-800">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.76 0 5.45.23 8.08.68.53.09.92.56.92 1.1v1.04a2.25 2.25 0 0 1-.66 1.6l-5.68 5.68a2.25 2.25 0 0 0-.66 1.59v2.93a2.25 2.25 0 0 1-1.24 2.01L9.75 21v-6.57a2.25 2.25 0 0 0-.66-1.6L3.41 7.16a2.25 2.25 0 0 1-.66-1.6V4.79c0-.55.39-1.02.92-1.11A48.3 48.3 0 0 1 12 3Z"/></svg>
                Terapkan
            </button>
        </div>
        <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
            <span class="text-xs font-semibold text-slate-500">Filter aktif:</span>
            <div id="chip-aktif" class="flex flex-wrap gap-2"></div>
            <button type="button" id="reset" class="ml-auto text-xs font-semibold text-teal-600 hover:underline">Reset filter</button>
        </div>
    </form>

    {{-- ============ DAFTAR ============ --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm">Menampilkan <b id="jumlah" class="text-navy-900">{{ count($lowongan) }}</b> lowongan ramah Tuli</p>
        <label class="flex items-center gap-2 text-sm">
            Urutkan:
            <select id="urutkan" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-navy-900 focus:border-teal-500 focus:outline-none">
                <option value="baru">Paling baru</option>
                <option value="gaji">Gaji tertinggi</option>
            </select>
        </label>
    </div>

    <div id="daftar" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($lowongan as $slug => $job)
            @php $warnaTipe = ['Remote' => 'bg-violet-500', 'Hybrid' => 'bg-blue-500', 'Part Time' => 'bg-amber-500', 'Magang' => 'bg-pink-500'][$job['tipe']] ?? 'bg-emerald-500'; @endphp
            <article class="job group flex flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                     data-slug="{{ $slug }}" data-tipe="{{ $job['tipe'] }}" data-lokasi="{{ $job['lokasi'] }}" data-akses="{{ implode(' ', $job['akses']) }}"
                     data-gaji-min="{{ $job['gaji'][0] }}" data-gaji="{{ $job['gaji'][1] }}" data-hari="{{ $job['hari'] }}">
                <div class="relative aspect-[16/8] overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-{{ $job['foto'] }}?auto=format&fit=crop&w=600&q=70" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-950/70 to-transparent"></div>
                    <span class="absolute right-3 top-3 rounded-full {{ $warnaTipe }} px-2.5 py-1 text-[11px] font-bold text-white shadow">{{ $job['tipe'] }}</span>
                    <span class="absolute bottom-3 left-3 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-bold text-navy-900">{{ $job['bidang'] }}</span>
                </div>
                <div class="flex flex-1 flex-col p-5">
                    <div class="flex items-center justify-between gap-2 text-xs">
                        <span class="flex items-center gap-1 truncate font-bold uppercase tracking-wide text-teal-600">
                            {{ $job['perusahaan'] }}
                            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-label="Terverifikasi"><path fill-rule="evenodd" d="M8.6 3.6a3.75 3.75 0 0 1 6.8 0 3.75 3.75 0 0 1 4.8 4.8 3.75 3.75 0 0 1 0 6.8 3.75 3.75 0 0 1-4.8 4.8 3.75 3.75 0 0 1-6.8 0 3.75 3.75 0 0 1-4.8-4.8 3.75 3.75 0 0 1 0-6.8 3.75 3.75 0 0 1 4.8-4.8Zm7.01 6.33a.75.75 0 1 0-1.22-.87l-3.24 4.53-1.62-1.62a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.09l3.75-5.25Z" clip-rule="evenodd"/></svg>
                        </span>
                        <span class="shrink-0 text-slate-400">{{ $job['hari'] === 0 ? 'Hari ini' : $job['hari'] . ' hari lalu' }}</span>
                    </div>
                    <h2 class="mt-1.5 font-extrabold leading-snug text-navy-900">{{ $job['posisi'] }}</h2>
                    <p class="mt-1 text-xs text-slate-500">📍 {{ $job['lokasi'] }} · 🎯 {{ $job['pengalaman'] }}</p>
                    <div class="mt-3 flex flex-wrap gap-1.5">
                        @foreach ($job['akses'] as $a)
                            <span class="rounded-md bg-teal-50 px-2 py-1 text-[11px] font-semibold text-teal-600">{{ $akses[$a] }}</span>
                        @endforeach
                    </div>
                    <div class="mt-auto pt-4">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Estimasi gaji</p>
                        <p class="text-sm font-extrabold text-navy-900">Rp {{ str_replace('.', ',', $job['gaji'][0]) }} – {{ str_replace('.', ',', $job['gaji'][1]) }} jt <span class="text-xs font-medium text-slate-400">/ bulan</span></p>
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <a href="{{ route('lowongan.detail', $slug) }}" class="grid place-items-center rounded-lg border border-slate-200 py-2.5 text-xs font-semibold text-navy-900 transition hover:border-navy-900">Lihat Detail</a>
                            <x-lowongan.lamar :job="$job" class="rounded-lg bg-navy-900 py-2.5 text-xs font-semibold text-white transition hover:bg-teal-600">Lamar Cepat</x-lowongan.lamar>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div id="kosong" class="hidden rounded-2xl border border-dashed border-slate-200 bg-white p-10 text-center">
        <p class="text-4xl" aria-hidden="true">🔍</p>
        <p class="mt-3 font-bold text-navy-900">Belum ada lowongan yang sesuai</p>
        <p class="mt-1 text-sm">Coba ubah atau reset filter.</p>
    </div>

    <nav id="halaman" class="flex items-center justify-center gap-2" aria-label="Halaman"></nav>
</div>

@endsection

@push('scripts')
<script type="module">
    (() => {
        const akses = @json($akses);
        const PER_HALAMAN = 6;
        const form = document.getElementById('form-filter');
        const daftar = document.getElementById('daftar');
        const cards = [...daftar.querySelectorAll('.job')];
        let halaman = 1;

        const labelFilter = {
            tipe: (v) => `🕒 ${v}`,
            lokasi: (v) => `📍 ${v}`,
            akses: (v) => akses[v],
            gaji: (v) => form.gaji.selectedOptions[0].textContent,
        };

        const renderChip = () => {
            const wadah = document.getElementById('chip-aktif');
            wadah.innerHTML = '';
            ['tipe', 'lokasi', 'akses', 'gaji'].forEach((nama) => {
                const v = form[nama].value;
                if (!v) return;
                const chip = document.createElement('button');
                chip.type = 'button';
                chip.className = 'inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold text-white';
                chip.textContent = labelFilter[nama](v);
                chip.insertAdjacentHTML('beforeend', '<span aria-hidden="true">✕</span>');
                chip.setAttribute('aria-label', `Hapus filter ${chip.textContent}`);
                chip.addEventListener('click', () => { form[nama].value = ''; terapkan(); });
                wadah.appendChild(chip);
            });
            if (!wadah.children.length) wadah.innerHTML = '<span class="text-xs text-slate-400">Tidak ada</span>';
        };

        const terapkan = (resetHalaman = true) => {
            if (resetHalaman) halaman = 1;
            const { tipe, lokasi, akses: fasilitas, gaji } = Object.fromEntries(new FormData(form));
            const [gMin, gMax] = gaji ? gaji.split('-').map(Number) : [0, 99];

            const cocok = cards.filter((c) => {
                const d = c.dataset;
                if (tipe && d.tipe !== tipe) return false;
                if (lokasi && d.lokasi !== lokasi) return false;
                if (fasilitas && !d.akses.split(' ').includes(fasilitas)) return false;
                if (gaji && (Number(d.gaji) < gMin || Number(d.gajiMin) > gMax)) return false;
                return true;
            });
            const urut = document.getElementById('urutkan').value;
            cocok.sort((a, b) => urut === 'gaji' ? b.dataset.gaji - a.dataset.gaji : a.dataset.hari - b.dataset.hari);

            const total = Math.max(1, Math.ceil(cocok.length / PER_HALAMAN));
            halaman = Math.min(halaman, total);
            cards.forEach((c) => c.classList.add('hidden'));
            cocok.slice((halaman - 1) * PER_HALAMAN, halaman * PER_HALAMAN).forEach((c) => {
                daftar.appendChild(c);
                c.classList.remove('hidden', 'pop-in');
                void c.offsetWidth;
                c.classList.add('pop-in');
            });

            document.getElementById('jumlah').textContent = cocok.length;
            document.getElementById('kosong').classList.toggle('hidden', cocok.length > 0);
            renderChip();
            renderHalaman(total, cocok.length);
        };

        const renderHalaman = (total, jumlah) => {
            const nav = document.getElementById('halaman');
            nav.innerHTML = '';
            if (jumlah <= PER_HALAMAN) return;
            const tombol = (label, ke, aktif = false, mati = false) => {
                const b = document.createElement('button');
                b.type = 'button';
                b.textContent = label;
                b.disabled = mati;
                b.className = 'grid h-10 min-w-10 place-items-center rounded-lg px-3 text-sm font-semibold transition disabled:opacity-40 ' +
                    (aktif ? 'bg-navy-900 text-white' : 'border border-slate-200 bg-white text-navy-900 hover:border-teal-500');
                if (aktif) b.setAttribute('aria-current', 'page');
                b.addEventListener('click', () => { halaman = ke; terapkan(false); window.scrollTo({ top: 0, behavior: 'smooth' }); });
                nav.appendChild(b);
            };
            tombol('←', halaman - 1, false, halaman === 1);
            for (let i = 1; i <= total; i++) tombol(i, i, i === halaman);
            tombol('→', halaman + 1, false, halaman === total);
        };

        form.addEventListener('submit', () => terapkan());
        form.addEventListener('change', () => terapkan());
        document.getElementById('urutkan').addEventListener('change', () => terapkan());
        document.getElementById('reset').addEventListener('click', () => { form.reset(); terapkan(); });

        terapkan();
    })();
</script>
@endpush
