@props(['name', 'judul', 'ket' => null, 'aktif' => false])

{{-- Saklar on/off untuk halaman pengaturan admin (checkbox tersembunyi + tampilan geser) --}}
<label class="flex cursor-pointer items-start justify-between gap-4 rounded-xl border border-slate-100 p-4 transition hover:border-teal-300">
    <span class="min-w-0">
        <span class="block text-sm font-bold text-navy-900">{{ $judul }}</span>
        @if ($ket)
            <span class="mt-0.5 block text-xs leading-relaxed text-slate-500">{{ $ket }}</span>
        @endif
    </span>
    <input type="checkbox" name="{{ $name }}" @checked($aktif) class="peer sr-only">
    <span class="relative mt-0.5 h-6 w-11 shrink-0 rounded-full bg-slate-300 transition after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:bg-teal-500 peer-checked:after:translate-x-5 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/20"></span>
</label>
