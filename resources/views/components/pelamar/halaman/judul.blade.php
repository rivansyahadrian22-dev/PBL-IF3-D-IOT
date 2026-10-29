@props(['judul', 'deskripsi' => null, 'badge' => null])

{{-- Judul halaman dashboard: breadcrumb, judul, deskripsi, dan slot kanan (tombol/statistik) --}}
<div {{ $attributes->class('flex flex-wrap items-end justify-between gap-4') }}>
    <div class="min-w-0 max-w-2xl">
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500" aria-label="Breadcrumb">
            <a href="{{ route('beranda') }}" class="hover:text-teal-600">Beranda</a>
            <span aria-hidden="true">/</span>
            <span class="text-navy-900">{{ $judul }}</span>
        </nav>
        @if ($badge)
            <span class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-600 ring-1 ring-teal-100">{{ $badge }}</span>
        @endif
        <h1 class="mt-2 text-2xl font-extrabold text-navy-900 sm:text-3xl">{{ $judul }}</h1>
        @if ($deskripsi)
            <p class="mt-1 text-sm leading-relaxed">{{ $deskripsi }}</p>
        @endif
    </div>
    @if ($slot->isNotEmpty())
        <div class="flex flex-wrap items-center gap-3">{{ $slot }}</div>
    @endif
</div>
