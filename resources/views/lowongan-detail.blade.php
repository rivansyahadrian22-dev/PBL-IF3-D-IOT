@extends('layouts.app')

@section('title', $job['posisi'])

@php
    $akses = config('tunaker.akses');
    $aksesDetail = config('tunaker.akses_detail');

    $fmt = fn ($n) => str_replace('.', ',', $n);
    $gajiTeks = 'Rp ' . $fmt($job['gaji'][0]) . ' – ' . $fmt($job['gaji'][1]) . ' jt';

    $batas = \Carbon\Carbon::parse($job['batas'])->locale('id');
    $sisaHari = (int) now()->startOfDay()->diffInDays($batas->copy()->startOfDay(), false);
    $ditutup = $sisaHari < 0;

    $serupa = collect(config('lowongan.data'))->except($job['slug'])->sortByDesc('cocok')->take(3);
    $warnaCocok = $job['cocok'] >= 90 ? 'bg-emerald-500' : ($job['cocok'] >= 80 ? 'bg-teal-500' : 'bg-amber-500');

    $ringkasan = [
        ['🕒', 'Tipe kerja', $job['tipe']],
        ['📍', 'Lokasi', $job['lokasi']],
        ['🎯', 'Pengalaman', $job['pengalaman']],
        ['⏰', 'Jam kerja', $job['jam']],
        ['👥', 'Pelamar', $job['pelamar'] . ' orang'],
    ];
    $centang = '<svg class="h-5 w-5 shrink-0 text-teal-500" viewBox="0 0 24 24" fill="currentColor" aria-label="Terverifikasi"><path fill-rule="evenodd" d="M8.6 3.6a3.75 3.75 0 0 1 6.8 0 3.75 3.75 0 0 1 4.8 4.8 3.75 3.75 0 0 1 0 6.8 3.75 3.75 0 0 1-4.8 4.8 3.75 3.75 0 0 1-6.8 0 3.75 3.75 0 0 1-4.8-4.8 3.75 3.75 0 0 1 0-6.8 3.75 3.75 0 0 1 4.8-4.8Zm7.01 6.33a.75.75 0 1 0-1.22-.87l-3.24 4.53-1.62-1.62a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.09l3.75-5.25Z" clip-rule="evenodd"/></svg>';
@endphp

@section('content')
<div class="mx-auto max-w-7xl pb-24 lg:pb-0">
    {{-- ============ BREADCRUMB ============ --}}
    <nav class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500" aria-label="Breadcrumb">
        <a href="{{ route('beranda') }}" class="hover:text-teal-600">Beranda</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('lowongan') }}" class="hover:text-teal-600">Lowongan Kerja</a>
        <span aria-hidden="true">/</span>
        <span class="text-navy-900">{{ $job['posisi'] }}</span>
    </nav>

    {{-- ============ KEPALA ============ --}}
    <header class="relative mt-4 overflow-hidden rounded-3xl bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 p-6 text-white sm:p-8">
        <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-teal-500/25 blur-3xl" aria-hidden="true"></div>
        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center">
            <span class="grid h-20 w-20 shrink-0 place-items-center rounded-3xl bg-gradient-to-br {{ $job['warna'] }} text-4xl shadow-xl ring-4 ring-white/15" aria-hidden="true">{{ $job['emoji'] }}</span>
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap gap-2 text-xs font-bold">
                    <span class="rounded-full bg-white/10 px-3 py-1 ring-1 ring-white/20">{{ $job['bidang'] }}</span>
                    <span class="rounded-full bg-teal-500/20 px-3 py-1 text-teal-100 ring-1 ring-teal-500/40">✓ Ramah Tuli</span>
                    <span class="rounded-full {{ $warnaCocok }} px-3 py-1">{{ $job['cocok'] }}% Cocok</span>
                </div>
                <h1 class="mt-3 text-2xl font-extrabold leading-tight sm:text-3xl">{{ $job['posisi'] }}</h1>
                <p class="mt-1 flex items-center gap-1.5 text-slate-300">{{ $job['perusahaan'] }} {!! $centang !!}</p>
                <div class="mt-4 flex flex-wrap gap-x-5 gap-y-1 text-sm text-slate-300">
                    <span>📍 {{ $job['lokasi'] }}</span>
                    <span>🕒 {{ $job['tipe'] }}</span>
                    <span>🎯 {{ $job['pengalaman'] }}</span>
                    <span>Dipasang {{ $job['hari'] === 0 ? 'hari ini' : $job['hari'] . ' hari lalu' }}</span>
                </div>
            </div>
            <div class="flex shrink-0 flex-wrap items-center gap-2 lg:flex-col lg:items-stretch">
                <x-lowongan.lamar :job="$job" class="hidden rounded-xl bg-teal-500 px-8 py-3.5 text-sm font-bold text-white shadow-lg transition hover:bg-teal-600 lg:block">Lamar Sekarang</x-lowongan.lamar>
                <div class="flex gap-2">
                    <button type="button" id="simpan" aria-pressed="false" class="flex flex-1 items-center justify-center gap-2 rounded-xl border border-white/25 px-4 py-2.5 text-sm font-semibold transition hover:bg-white/10">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.59 3.32c1.1.13 1.91 1.08 1.91 2.19V21L12 17.25 4.5 21V5.51c0-1.11.81-2.06 1.91-2.19a48.5 48.5 0 0 1 11.18 0Z"/></svg>
                        <span>Simpan</span>
                    </button>
                    <button type="button" id="bagikan" class="flex flex-1 items-center justify-center gap-2 rounded-xl border border-white/25 px-4 py-2.5 text-sm font-semibold transition hover:bg-white/10">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.22 10.91c.18.33.28.7.28 1.09s-.1.76-.28 1.09m0-2.18a2.25 2.25 0 1 0-3.97 2.1 2.25 2.25 0 0 0 3.97-2.1Zm0 2.18 9.57 5.32m-9.57-7.5 9.57-5.32m0 12.82a2.25 2.25 0 1 0 3.9 2.25 2.25 2.25 0 0 0-3.9-2.25Zm0-12.82a2.25 2.25 0 1 0 3.9-2.25 2.25 2.25 0 0 0-3.9 2.25Z"/></svg>
                        Bagikan
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_22rem]">
        {{-- ============ ISI ============ --}}
        <div class="min-w-0 space-y-6">
            <section class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-lg font-extrabold text-navy-900">Tentang Pekerjaan</h2>
                <p class="mt-3 leading-relaxed">{{ $job['deskripsi'] }}</p>
                <h3 class="mt-5 text-xs font-bold uppercase tracking-wider text-slate-500">Tanggung jawab</h3>
                <ul class="mt-2 space-y-2">
                    @foreach ($job['tugas'] as $tugas)
                        <li class="flex gap-3 text-sm"><span class="mt-0.5 text-teal-500" aria-hidden="true">✓</span> {{ $tugas }}</li>
                    @endforeach
                </ul>
            </section>

            <section class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-lg font-extrabold text-navy-900">Persyaratan</h2>
                <ul class="mt-3 grid gap-2 sm:grid-cols-2">
                    @foreach ($job['syarat'] as $syarat)
                        <li class="flex items-center gap-3 rounded-xl bg-surface p-3.5 text-sm font-medium text-navy-900"><span class="text-teal-500" aria-hidden="true">●</span> {{ $syarat }}</li>
                    @endforeach
                </ul>
            </section>

            <section class="rounded-3xl border border-teal-100 bg-gradient-to-br from-teal-50 to-white p-5 shadow-sm sm:p-6">
                <h2 class="text-lg font-extrabold text-navy-900">Dukungan untuk Teman Tuli</h2>
                <p class="mt-1 text-sm">Akomodasi yang disiapkan perusahaan ini.</p>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach ($job['akses'] as $kunci)
                        @php $emoji = config('tunaker.akses_ikon')[$kunci]; $nama = $akses[$kunci]; @endphp
                        <div class="flex gap-3 rounded-2xl border border-teal-100 bg-white p-4">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-teal-50 text-2xl" aria-hidden="true">{{ $emoji }}</span>
                            <div>
                                <p class="text-sm font-bold text-navy-900">{{ $nama }}</p>
                                <p class="mt-0.5 text-xs leading-relaxed text-slate-500">{{ $aksesDetail[$kunci] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="video-btn mt-4 inline-flex items-center gap-2 rounded-lg border border-teal-500 bg-white px-4 py-2.5 text-sm font-bold text-teal-600 transition hover:bg-teal-50"
                        data-video="" data-judul="Penjelasan lowongan {{ $job['posisi'] }} dalam BISINDO">Lihat Penjelasan dalam BISINDO</button>
            </section>

            <section class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-lg font-extrabold text-navy-900">Benefit</h2>
                <ul class="mt-3 flex flex-wrap gap-2">
                    @foreach ($job['benefit'] as $benefit)
                        <li class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-navy-900">{{ $benefit }}</li>
                    @endforeach
                </ul>
            </section>

            <section class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-lg font-extrabold text-navy-900">Tentang Perusahaan</h2>
                <div class="mt-4 flex items-start gap-4">
                    <span class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-gradient-to-br {{ $job['warna'] }} text-2xl shadow" aria-hidden="true">{{ $job['emoji'] }}</span>
                    <div>
                        <p class="flex items-center gap-1.5 font-extrabold text-navy-900">{{ $job['perusahaan'] }} {!! str_replace('h-5 w-5', 'h-4 w-4', $centang) !!}</p>
                        <p class="text-xs font-semibold text-teal-600">Mitra terverifikasi TUNAKER</p>
                        <p class="mt-2 text-sm leading-relaxed">{{ $job['tentang'] }}</p>
                    </div>
                </div>
            </section>
        </div>

        {{-- ============ PANEL KANAN ============ --}}
        <aside class="space-y-4 lg:sticky lg:top-24 lg:self-start">
            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Estimasi gaji</p>
                <p class="mt-1 text-2xl font-extrabold text-navy-900">{{ $gajiTeks }}</p>
                <p class="text-xs text-slate-500">per bulan</p>

                <dl class="mt-4 divide-y divide-slate-100 text-sm">
                    @foreach ($ringkasan as [$emoji, $label, $nilai])
                        <div class="flex items-start justify-between gap-3 py-2.5">
                            <dt class="text-slate-500"><span aria-hidden="true">{{ $emoji }}</span> {{ $label }}</dt>
                            <dd class="text-right font-semibold text-navy-900">{{ $nilai }}</dd>
                        </div>
                    @endforeach
                </dl>

                <div class="mt-4 rounded-xl p-3 text-center text-sm font-semibold {{ $ditutup ? 'bg-red-50 text-red-600' : ($sisaHari <= 7 ? 'bg-amber-50 text-amber-700' : 'bg-teal-50 text-teal-700') }}">
                    @if ($ditutup)
                        Pendaftaran sudah ditutup
                    @else
                        ⏳ Batas lamar {{ $batas->translatedFormat('d F Y') }}
                        <span class="block text-xs font-medium">{{ $sisaHari === 0 ? 'Hari ini batas terakhir' : 'Sisa ' . $sisaHari . ' hari' }}</span>
                    @endif
                </div>

                @unless ($ditutup)
                    <x-lowongan.lamar :job="$job" class="mt-4 w-full rounded-xl bg-navy-900 py-3.5 text-sm font-bold text-white shadow-lg shadow-navy-900/20 transition hover:bg-teal-600">Lamar Sekarang</x-lowongan.lamar>
                @endunless
                <p class="mt-3 text-center text-[11px] text-slate-400">Proses lamar hanya 3 langkah singkat.</p>
            </div>

            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="font-extrabold text-navy-900">Kenapa cocok untukmu?</p>
                <p class="mt-2 text-sm leading-relaxed">{{ $job['alasan'] }}</p>
                <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full rounded-full bg-gradient-to-r from-teal-500 to-navy-800" style="width: {{ $job['cocok'] }}%"></div>
                </div>
                <p class="mt-1 text-right text-xs font-bold text-teal-600">{{ $job['cocok'] }}% cocok dengan profilmu</p>
            </div>

            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="font-extrabold text-navy-900">Lowongan Serupa</p>
                <ul class="mt-3 divide-y divide-slate-100">
                    @foreach ($serupa as $s)
                        <li>
                            <a href="{{ route('lowongan.detail', $s['slug']) }}" class="-mx-2 flex items-center gap-3 rounded-xl px-2 py-3 transition hover:bg-surface">
                                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br {{ $s['warna'] }} text-xl shadow" aria-hidden="true">{{ $s['emoji'] }}</span>
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-sm font-bold text-navy-900">{{ $s['posisi'] }}</span>
                                    <span class="block truncate text-xs text-slate-500">{{ $s['perusahaan'] }} · {{ $s['lokasi'] }}</span>
                                </span>
                                <span class="shrink-0 text-xs font-bold text-teal-600">{{ $s['cocok'] }}%</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</div>

{{-- Bilah lamar tetap di layar HP --}}
<div class="fixed inset-x-0 bottom-0 z-30 flex items-center gap-3 border-t border-slate-200 bg-white/95 px-4 py-3 shadow-[0_-8px_24px_rgb(11_37_69/0.08)] backdrop-blur lg:hidden">
    <div class="min-w-0 flex-1">
        <p class="truncate text-sm font-extrabold text-navy-900">{{ $gajiTeks }}</p>
        <p class="truncate text-[11px] text-slate-500">{{ $ditutup ? 'Pendaftaran ditutup' : 'Sisa ' . $sisaHari . ' hari · ' . $job['posisi'] }}</p>
    </div>
    @unless ($ditutup)
        <x-lowongan.lamar :job="$job" class="shrink-0 rounded-xl bg-navy-900 px-6 py-3 text-sm font-bold text-white transition hover:bg-teal-600">Lamar</x-lowongan.lamar>
    @endunless
</div>

<style>
    /* Tombol "Aa" naik supaya tidak menutupi bilah lamar di HP */
    @media (max-width: 1023px) { #a11y-wrap { bottom: 5.25rem; } }
</style>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { storage, toast } = window.TunakerUI;
        const SIMPAN_KEY = 'tunaker_lowongan_disimpan';
        const posisi = @json($job['posisi']);
        const disimpan = new Set(storage.get(SIMPAN_KEY) || []);

        const simpan = document.getElementById('simpan');
        const tandai = (aktif) => {
            simpan.setAttribute('aria-pressed', aktif);
            simpan.classList.toggle('bg-white', aktif);
            simpan.classList.toggle('text-navy-900', aktif);
            simpan.querySelector('svg').setAttribute('fill', aktif ? 'currentColor' : 'none');
            simpan.querySelector('span').textContent = aktif ? 'Tersimpan' : 'Simpan';
        };
        tandai(disimpan.has(posisi));
        simpan.addEventListener('click', () => {
            const aktif = !disimpan.has(posisi);
            aktif ? disimpan.add(posisi) : disimpan.delete(posisi);
            storage.set(SIMPAN_KEY, [...disimpan]);
            tandai(aktif);
            toast(aktif ? `"${posisi}" disimpan` : `"${posisi}" dihapus dari simpanan`, aktif ? '🔖' : '🗑️');
        });

        document.getElementById('bagikan').addEventListener('click', async () => {
            const data = { title: `${posisi} | TUNAKER`, url: location.href };
            try {
                if (navigator.share) { await navigator.share(data); return; }
                await navigator.clipboard.writeText(location.href);
                toast('Link lowongan disalin. Tempel di WhatsApp atau pesan.', '🔗');
            } catch (e) {
                if (e.name !== 'AbortError') toast('Salin link dari kolom alamat browser.', '🔗');
            }
        });
    })();
</script>
@endpush
