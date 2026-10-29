<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Admin') | Admin TUNAKER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-slate-600 antialiased">

@php
    // CONTOH data admin — ganti dengan auth()->user() setelah login admin tersambung
    $admin = ['nama' => 'Admin TUNAKER', 'peran' => 'Super Admin', 'inisial' => 'AT'];
    $lencanaMenu = \App\Support\Admin\ContohAdmin::lencanaMenu();

    // [label, nama route, ikon, lencana, route lain yang membuat menu ini tampak aktif]
    $grupMenu = [
        'Menu Utama' => [
            ['Dashboard Admin', 'admin.dashboard', 'dashboard', null, []],
            ['Pencari Kerja', 'admin.pencari', 'pengguna', 'menunggu', ['admin.pencari', 'admin.rfid']],
            ['Mitra', 'admin.perusahaan', 'perusahaan', 'mitra', ['admin.perusahaan', 'admin.lowongan']],
            ['Data Lamaran', 'admin.lamaran', 'lamaran', 'lamaran', []],
            ['Pelatihan & Sertifikasi', 'admin.pelatihan', 'pelatihan', 'pelatihan', []],
        ],
        'Laporan & Pengaturan' => [
            ['Statistik & Laporan', 'admin.laporan', 'laporan', null, []],
            ['Pengaturan Sistem', 'admin.pengaturan', 'pengaturan', null, []],
        ],
    ];
    $antreanMitra = count($lencanaMenu['perusahaanIds']) + count($lencanaMenu['lowonganIds']);
    $menungguAwal = count($lencanaMenu['menungguIds']);
@endphp

<div class="flex min-h-screen">
    {{-- ============ SIDEBAR ============ --}}
    <div id="sidebar-backdrop" class="fixed inset-0 z-40 hidden print:hidden bg-navy-950/50 backdrop-blur-sm lg:hidden"></div>
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex print:hidden w-72 -translate-x-full flex-col border-r border-slate-100 bg-white transition-transform duration-300 lg:sticky lg:top-0 lg:h-screen lg:w-64 lg:translate-x-0">
        <div class="flex h-20 items-center justify-between px-5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo-tunaker.png') }}" alt="TUNAKER" class="h-11 w-auto">
                <span class="rounded-md bg-navy-900 px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Admin</span>
            </a>
            <button type="button" id="sidebar-close" class="grid h-9 w-9 place-items-center rounded-lg text-slate-400 hover:bg-slate-100 lg:hidden" aria-label="Tutup menu">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-2" aria-label="Menu admin">
            @foreach ($grupMenu as $judulGrup => $menu)
                <div>
                    <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-widest text-slate-400">{{ $judulGrup }}</p>
                    <ul class="space-y-1">
                        @foreach ($menu as [$label, $rute, $ikon, $lencana, $aktifDi])
                            @php $aktif = $rute && request()->routeIs(...($aktifDi ?: [$rute])); @endphp
                            <li>
                                <a href="{{ $rute ? route($rute) : '#' }}" @unless ($rute) data-segera="{{ $label }}" @endunless @if ($aktif) aria-current="page" @endif
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $aktif ? 'bg-navy-900 text-white shadow-lg shadow-navy-900/20' : 'text-slate-600 hover:bg-surface hover:text-navy-900' }}">
                                    <x-admin.ikon :nama="$ikon" class="h-5 w-5 shrink-0" />
                                    <span class="flex-1">{{ $label }}</span>
                                    @if ($lencana === 'menunggu')
                                        <span data-lencana-menunggu title="Menunggu verifikasi" class="grid h-5 min-w-5 place-items-center rounded-full px-1.5 text-[11px] font-bold {{ $aktif ? 'bg-white text-navy-900' : 'bg-amber-100 text-amber-700' }}">{{ $menungguAwal }}</span>
                                    @elseif ($lencana === 'mitra')
                                        <span data-lencana-mitra title="Perusahaan dan lowongan yang perlu ditindak" class="grid h-5 min-w-5 place-items-center rounded-full px-1.5 text-[11px] font-bold {{ $aktif ? 'bg-white text-navy-900' : 'bg-amber-100 text-amber-700' }}">{{ $antreanMitra }}</span>
                                    @elseif ($lencana)
                                        <span data-lencana-jumlah="{{ $lencana }}" data-dasar="{{ $lencanaMenu[$lencana] }}" class="grid h-5 min-w-5 place-items-center rounded-full bg-teal-50 px-1.5 text-[11px] font-bold text-teal-600">{{ number_format($lencanaMenu[$lencana], 0, ',', '.') }}</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </nav>

        <div class="space-y-3 p-4">
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-3.5">
                <p class="text-xs font-bold text-amber-800">Data contoh</p>
                <p class="mt-0.5 text-[11px] leading-relaxed text-amber-700">Angka di halaman admin belum berasal dari database. Perubahan hanya tersimpan di browser ini.</p>
            </div>
            <a href="{{ route('masuk') }}" class="flex items-center justify-center gap-2 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H21"/></svg>
                Keluar Sistem Admin
            </a>
        </div>
    </aside>

    {{-- ============ KONTEN ============ --}}
    <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-30 print:hidden border-b border-slate-100 bg-white/90 backdrop-blur">
            <div class="flex h-20 items-center gap-3 px-4 sm:px-6 lg:px-8">
                <button type="button" id="sidebar-open" class="grid h-10 w-10 shrink-0 place-items-center rounded-lg text-navy-900 hover:bg-slate-100 lg:hidden" aria-label="Buka menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <form action="{{ route('admin.pencari') }}" method="GET" class="relative min-w-0 flex-1 md:max-w-md" role="search">
                    <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                    <input type="search" name="q" placeholder="Cari nama atau ID pencari kerja…" aria-label="Cari pencari kerja" class="w-full rounded-xl border border-slate-200 bg-surface py-2.5 pl-11 pr-4 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-teal-500/15">
                </form>

                <div class="ml-auto flex items-center gap-2 sm:gap-3">
                    <span class="hidden items-center gap-2 rounded-xl border border-teal-100 bg-teal-50 px-3.5 py-2.5 text-sm font-semibold text-teal-600 md:inline-flex">
                        <span class="relative flex h-2 w-2"><span class="absolute h-full w-full animate-ping rounded-full bg-teal-500 opacity-75"></span><span class="relative h-2 w-2 rounded-full bg-teal-500"></span></span>
                        Mode pantau aktif
                    </span>

                    <div class="flex items-center gap-3 rounded-xl py-1 pl-1 pr-1 sm:pr-3">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-navy-700 to-navy-900 text-sm font-bold text-white">{{ $admin['inisial'] }}</span>
                        <span class="hidden text-left sm:block">
                            <span class="block text-sm font-bold text-navy-900">{{ $admin['nama'] }}</span>
                            <span class="block text-xs text-slate-500">{{ $admin['peran'] }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 px-4 py-6 pb-24 sm:px-6 lg:px-8 lg:pb-24 lg:pt-8">
            @yield('content')
        </main>

        <footer class="print:hidden border-t border-slate-100 bg-white px-4 py-4 text-xs text-slate-500 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <p>Panel admin TUNAKER. Data pribadi pencari kerja hanya untuk keperluan verifikasi dan penempatan.</p>
                <p>&copy; {{ date('Y') }} TUNAKER</p>
            </div>
        </footer>
    </div>
</div>

@include('shared.a11y')
@include('admin.partials.modal-detail')

<script type="application/json" id="data-menunggu-awal">@json($lencanaMenu['menungguIds'])</script>
@php $antreanAwal = ['perusahaanIds' => $lencanaMenu['perusahaanIds'], 'lowonganIds' => $lencanaMenu['lowonganIds']]; @endphp
<script type="application/json" id="data-antrean-awal">@json($antreanAwal)</script>
<script type="module">
    (() => {
        const { toast, storage } = window.TunakerUI;
        const { dataAdmin, hitungAntrean } = window.TunakerAdmin;

        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const geser = (buka) => {
            sidebar.classList.toggle('-translate-x-full', !buka);
            backdrop.classList.toggle('hidden', !buka);
        };
        document.getElementById('sidebar-open').addEventListener('click', () => geser(true));
        document.getElementById('sidebar-close').addEventListener('click', () => geser(false));
        backdrop.addEventListener('click', () => geser(false));

        // Menu yang halamannya belum dibuat
        document.querySelectorAll('[data-segera]').forEach((a) => a.addEventListener('click', (e) => {
            e.preventDefault();
            toast(`Halaman ${a.dataset.segera} belum dibuat.`, 'ℹ️');
        }));

        // Lencana "menunggu verifikasi" mengikuti perubahan yang dibuat admin di browser ini
        const idAwal = JSON.parse(document.getElementById('data-menunggu-awal').textContent);
        const antrean = JSON.parse(document.getElementById('data-antrean-awal').textContent);
        const segarkan = () => {
            document.querySelectorAll('[data-lencana-mitra]').forEach((el) => {
                el.textContent = hitungAntrean(antrean.perusahaanIds, 'tunaker_admin_perusahaan', 'verifikasi') + hitungAntrean(antrean.lowonganIds, 'tunaker_admin_lowongan', 'review');
            });
            document.querySelectorAll('[data-lencana-menunggu]').forEach((el) => { el.textContent = dataAdmin.hitungMenunggu(idAwal); });
            // Data yang ditambah admin di browser ini ikut dihitung
            const kunci = { lowongan: 'tunaker_admin_lowongan', pelatihan: 'tunaker_admin_pelatihan', perusahaan: 'tunaker_admin_perusahaan', lamaran: 'tunaker_admin_lamaran' };
            document.querySelectorAll('[data-lencana-jumlah]').forEach((el) => {
                const tambahan = (storage.get(kunci[el.dataset.lencanaJumlah])?.baru ?? []).length;
                el.textContent = (Number(el.dataset.dasar) + tambahan).toLocaleString('id-ID');
            });
        };
        segarkan();
        window.addEventListener('tunaker-admin-berubah', segarkan);
    })();
</script>
@stack('scripts')
</body>
</html>
