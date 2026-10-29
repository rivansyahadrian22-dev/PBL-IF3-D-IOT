@props(['label', 'nilai', 'ket' => null, 'ikon' => 'info', 'warna' => 'bg-navy-900/5 text-navy-900', 'id' => null, 'ton' => null, 'tag' => 'div'])

@php
    $tepi = match ($ton) {
        'peringatan' => 'border-amber-200 bg-amber-50/60',
        'bahaya' => 'border-red-200 bg-red-50/60',
        default => 'border-slate-100 bg-white',
    };
@endphp

{{-- Kartu angka ringkasan. Pakai tag="button" supaya bisa diklik sebagai penyaring. --}}
<{{ $tag }} {{ $attributes->class(['block rounded-2xl border p-5 text-left shadow-sm transition hover:-translate-y-0.5 hover:shadow-md', $tepi]) }} @if ($tag === 'button') type="button" @endif>
    <span class="flex items-start justify-between gap-3">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $label }}</span>
        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl {{ $warna }}"><x-admin.ikon :nama="$ikon" /></span>
    </span>
    <span @if ($id) id="{{ $id }}" @endif class="mt-2 block text-3xl font-extrabold text-navy-900">{{ $nilai }}</span>
    @if ($ket)
        <span class="mt-1 block text-xs font-semibold text-slate-500">{{ $ket }}</span>
    @endif
    {{ $slot }}
</{{ $tag }}>
