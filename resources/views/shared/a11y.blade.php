{{-- Tombol "Aa" pengaturan tampilan (perilaku di resources/js/shared/ui.js) --}}
<div id="a11y-wrap" class="fixed bottom-5 right-5 z-40 print:hidden">
    <div id="a11y-panel" class="absolute bottom-16 right-0 hidden w-72 rounded-2xl border border-slate-100 bg-white p-5 shadow-2xl">
        <p class="text-sm font-extrabold text-navy-900">Pengaturan Tampilan</p>
        <p class="mt-0.5 text-xs text-slate-500">Atur agar halaman nyaman dibaca.</p>

        <p class="mt-4 text-xs font-bold uppercase tracking-wider text-slate-500">Ukuran teks</p>
        <div class="mt-2 grid grid-cols-4 gap-1.5">
            @foreach (['sm' => 'A-', 'md' => 'A', 'lg' => 'A+', 'xl' => 'A++'] as $ukuran => $teks)
                <button type="button" class="font-size-btn rounded-lg border border-slate-200 py-2 text-sm font-bold text-navy-900 transition" data-size="{{ $ukuran }}">{{ $teks }}</button>
            @endforeach
        </div>

        @foreach (['hc' => ['Kontras tinggi', 'Teks & garis lebih tegas'], 'no-motion' => ['Kurangi animasi', 'Matikan efek gerak']] as $opsi => [$judul, $ket])
            <label class="mt-4 flex cursor-pointer items-center justify-between gap-3">
                <span>
                    <span class="block text-sm font-semibold text-navy-900">{{ $judul }}</span>
                    <span class="block text-xs text-slate-500">{{ $ket }}</span>
                </span>
                <input type="checkbox" class="a11y-toggle peer sr-only" data-opt="{{ $opsi }}">
                <span class="relative h-6 w-11 shrink-0 rounded-full bg-slate-200 transition after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:bg-teal-500 peer-checked:after:translate-x-5"></span>
            </label>
        @endforeach
    </div>
    <button type="button" id="a11y-btn" class="grid h-14 w-14 place-items-center rounded-full bg-navy-900 text-white shadow-xl shadow-navy-900/30 ring-4 ring-white transition hover:scale-105" aria-label="Pengaturan tampilan" aria-expanded="false">
        <span class="text-lg font-extrabold">Aa</span>
    </button>
</div>
