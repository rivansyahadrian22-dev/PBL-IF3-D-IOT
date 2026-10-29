@props(['judul', 'deskripsi' => null, 'crumb' => null, 'lencana' => null])

{{-- Judul halaman admin: penunjuk lokasi, judul, deskripsi, dan tombol aksi di sebelah kanan (slot) --}}
<div class="flex flex-wrap items-end justify-between gap-4">
    <div class="max-w-2xl">
        <nav class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600">Dashboard Admin</a>
            <span aria-hidden="true">/</span>
            <span class="text-navy-900">{{ $crumb ?? $judul }}</span>
        </nav>
        <div class="mt-2 flex flex-wrap items-center gap-3">
            <h1 class="text-2xl font-extrabold text-navy-900 sm:text-3xl">{{ $judul }}</h1>
            @if ($lencana)
                <span id="judul-lencana" class="rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-600 ring-1 ring-teal-100">{{ $lencana }}</span>
            @endif
        </div>
        @if ($deskripsi)
            <p class="mt-1 text-sm leading-relaxed">{{ $deskripsi }}</p>
        @endif
    </div>
    @if ($slot->isNotEmpty())
        <div class="flex flex-wrap gap-3">{{ $slot }}</div>
    @endif
</div>
