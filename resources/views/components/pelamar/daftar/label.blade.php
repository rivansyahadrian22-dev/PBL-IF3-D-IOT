@props(['for' => null, 'hint' => null, 'gif' => null, 'optional' => false])

<div class="mb-1.5 flex items-center justify-between gap-2">
    @if ($for)
        <label for="{{ $for }}" class="text-sm font-semibold text-navy-900">
            {{ $slot }} @if ($optional)<span class="font-normal text-slate-400">(opsional)</span>@endif
        </label>
    @else
        <span class="text-sm font-semibold text-navy-900">
            {{ $slot }} @if ($optional)<span class="font-normal text-slate-400">(opsional)</span>@endif
        </span>
    @endif

    @if ($hint)
        <button type="button" class="hint-btn inline-flex shrink-0 items-center gap-1 rounded-full bg-teal-50 px-2.5 py-1 text-[11px] font-bold text-teal-600 ring-1 ring-teal-100 transition hover:bg-teal-100" aria-expanded="false">
            <span aria-hidden="true">🤟</span> Isyarat
        </button>
    @endif
</div>

@if ($hint)
    <div class="hint-box mb-3 hidden overflow-hidden rounded-xl border border-teal-100 bg-teal-50/70">
        <div class="flex gap-3 p-3">
            {{-- Ganti dengan GIF/video isyarat kata ini lewat prop "gif" --}}
            @if ($gif)
                <img src="{{ $gif }}" alt="Isyarat BISINDO" class="h-20 w-20 shrink-0 rounded-lg object-cover">
            @else
                <div class="grid h-20 w-20 shrink-0 place-items-center rounded-lg bg-gradient-to-br from-navy-900 to-navy-700 text-3xl" aria-hidden="true">🤟</div>
            @endif
            <div class="min-w-0">
                <p class="text-xs font-bold uppercase tracking-wider text-teal-600">Penjelasan singkat</p>
                <p class="mt-1 text-sm leading-relaxed text-navy-900">{{ $hint }}</p>
            </div>
        </div>
    </div>
@endif
