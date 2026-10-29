{{-- Pop up lamar bertahap (3 langkah + layar sukses). Perilakunya di resources/js/lowongan.js --}}
@php
    $radioKartu = 'chip flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3.5 transition hover:border-teal-500 peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15';
    $inputLm = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-navy-900 placeholder:text-slate-400 transition focus:border-teal-500 focus:outline-none focus:ring-4 focus:ring-teal-500/15';
    $langkahLamar = ['Dokumen', 'Komunikasi', 'Tinjau'];
@endphp

<div id="lamar-modal" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="lm-posisi">
    <div class="pop-in flex max-h-[92vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        {{-- Kepala --}}
        <div class="flex items-start gap-4 bg-gradient-to-br from-navy-900 to-navy-700 p-5 text-white sm:p-6">
            <span id="lm-emoji" class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-white/10 text-2xl ring-1 ring-white/20" aria-hidden="true"></span>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold uppercase tracking-widest text-teal-500">Lamar Pekerjaan</p>
                <h2 id="lm-posisi" tabindex="-1" class="text-lg font-extrabold leading-snug focus:outline-none"></h2>
                <p id="lm-perusahaan" class="text-sm text-slate-300"></p>
            </div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-300 hover:bg-white/10 hover:text-white" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Penunjuk langkah --}}
        <ol id="lm-stepper" class="flex items-center border-b border-slate-100 px-5 py-4 sm:px-6">
            @foreach ($langkahLamar as $i => $nama)
                <li class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
                    <div class="lm-stepper-item flex items-center gap-2">
                        <span class="lm-circle grid h-8 w-8 place-items-center rounded-full border-2 text-xs font-bold transition">{{ $i + 1 }}</span>
                        <span class="lm-label text-xs font-semibold">{{ $nama }}</span>
                    </div>
                    @unless ($loop->last)
                        <span class="mx-2 h-1 flex-1 overflow-hidden rounded-full bg-slate-200">
                            <span class="lm-line block h-full w-0 rounded-full bg-teal-500 transition-all duration-500"></span>
                        </span>
                    @endunless
                </li>
            @endforeach
        </ol>

        <form id="form-lamar" class="flex min-h-0 flex-1 flex-col" novalidate>
            <div class="flex-1 overflow-y-auto px-5 py-5 sm:px-6">
                {{-- ---------- Langkah 1: Dokumen ---------- --}}
                <div class="lm-step space-y-5" data-step="0">
                    <div class="field">
                        <span class="mb-1.5 block text-sm font-semibold text-navy-900">CV yang dikirim</span>
                        <div class="space-y-2">
                            <label class="block">
                                <input type="radio" name="cv" value="CV_Andi_Saputra.pdf" class="peer sr-only" checked>
                                <span class="{{ $radioKartu }}">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-white text-xl shadow-sm" aria-hidden="true">📄</span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-bold text-navy-900">CV_Andi_Saputra.pdf</span>
                                        <span class="block text-[11px] text-slate-500">Diperbarui 2 hari lalu · Disarankan</span>
                                    </span>
                                </span>
                            </label>
                            <label class="block">
                                <input type="radio" name="cv" value="CV Inklusif otomatis dari profil" class="peer sr-only">
                                <span class="{{ $radioKartu }}">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-white text-xl shadow-sm" aria-hidden="true">✨</span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-bold text-navy-900">CV Inklusif otomatis</span>
                                        <span class="block text-[11px] text-slate-500">Dibuat dari data profilmu, lengkap dengan preferensi komunikasi</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Ingin mengganti CV? <a href="{{ route('profil') }}" class="font-semibold text-teal-600 hover:underline">Perbarui di Profil Saya</a></p>
                    </div>

                    <label class="chip flex cursor-pointer items-start gap-3 rounded-xl bg-surface p-3.5">
                        <input type="checkbox" name="portofolio" value="Portofolio_Desain.pdf" checked class="mt-0.5 h-4 w-4 rounded border-slate-300 accent-teal-600">
                        <span class="text-sm"><b class="text-navy-900">Sertakan portofolio</b><br><span class="text-xs text-slate-500">Portofolio_Desain.pdf · 12 karya</span></span>
                    </label>

                    <div class="field">
                        <label for="lm-pesan" class="mb-1.5 flex items-center justify-between text-sm font-semibold text-navy-900">
                            <span>Pesan singkat <span class="font-normal text-slate-400">(opsional)</span></span>
                            <span id="lm-hitung" class="text-xs font-medium text-slate-400">0/300</span>
                        </label>
                        <textarea id="lm-pesan" name="pesan" rows="3" maxlength="300" placeholder="Contoh: Saya berpengalaman membuat desain untuk media sosial. Saya nyaman berkomunikasi lewat BISINDO dan chat." class="{{ $inputLm }}"></textarea>
                    </div>
                </div>

                {{-- ---------- Langkah 2: Komunikasi ---------- --}}
                <div class="lm-step hidden space-y-5" data-step="1">
                    <div id="lm-akses-info" class="hidden rounded-xl border border-teal-100 bg-teal-50 p-3.5">
                        <p class="text-xs font-bold uppercase tracking-wider text-teal-600">Perusahaan ini menyediakan</p>
                        <div id="lm-akses-chip" class="mt-2 flex flex-wrap gap-1.5"></div>
                    </div>

                    <div class="field">
                        <span class="mb-1.5 block text-sm font-semibold text-navy-900">Butuh juru bahasa isyarat saat wawancara?</span>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach (['Ya' => '🙋', 'Kadang' => '🤔', 'Tidak' => '👌'] as $opsi => $emoji)
                                <label>
                                    <input type="radio" name="jbi" value="{{ $opsi }}" required data-required-msg="Pilih salah satu agar perusahaan bisa menyiapkan wawancara." class="peer sr-only">
                                    <span class="chip flex cursor-pointer flex-col items-center gap-1 rounded-xl border border-slate-200 py-3 text-sm font-semibold text-navy-900 transition hover:border-teal-500 peer-checked:border-teal-500 peer-checked:bg-teal-500 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15">
                                        <span class="text-2xl" aria-hidden="true">{{ $emoji }}</span> {{ $opsi }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="field">
                        <span class="mb-1.5 block text-sm font-semibold text-navy-900">Perusahaan menghubungimu lewat</span>
                        <div class="grid gap-2 sm:grid-cols-3">
                            @foreach (['WhatsApp (teks)' => '📲', 'Email' => '📧', 'Chat TUNAKER' => '💬'] as $cara => $emoji)
                                <label>
                                    <input type="radio" name="kontak" value="{{ $cara }}" required @checked($loop->first) class="peer sr-only">
                                    <span class="chip flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-slate-200 px-3 py-3 text-sm font-semibold text-navy-900 transition hover:border-teal-500 peer-checked:border-navy-900 peer-checked:bg-navy-900 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-teal-500/15">
                                        <span aria-hidden="true">{{ $emoji }}</span> {{ $cara }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Tidak ada panggilan suara. Semua kabar dikirim dalam bentuk teks.</p>
                    </div>
                </div>

                {{-- ---------- Langkah 3: Tinjau ---------- --}}
                <div class="lm-step hidden space-y-4" data-step="2">
                    <p class="text-sm">Periksa lagi sebelum mengirim. Tekan <b class="text-navy-900">Ubah</b> untuk memperbaiki.</p>
                    <dl id="lm-ringkasan" class="divide-y divide-slate-100 rounded-2xl border border-slate-100"></dl>

                    <div class="field">
                        <label class="chip flex cursor-pointer items-start gap-3 rounded-xl border border-transparent bg-surface p-3.5">
                            <input type="checkbox" name="setuju" required data-required-msg="Centang persetujuan ini untuk mengirim lamaran." class="mt-0.5 h-4 w-4 rounded border-slate-300 accent-teal-600">
                            <span class="text-sm">Saya setuju profil, CV, dan preferensi komunikasi saya dibagikan kepada <b id="lm-setuju-perusahaan" class="text-navy-900"></b>.</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-between gap-3 border-t border-slate-100 bg-white px-5 py-4 sm:px-6">
                <button type="button" id="lm-kembali" class="invisible inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:bg-slate-100">← Kembali</button>
                <button type="submit" id="lm-lanjut" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800 disabled:pointer-events-none disabled:opacity-70">
                    <svg id="lm-spin" class="hidden h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25"/><path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v3a5 5 0 0 0-5 5H4Z" class="opacity-75"/></svg>
                    <span id="lm-lanjut-teks">Lanjut</span>
                </button>
            </div>
        </form>

        {{-- ---------- Layar sukses ---------- --}}
        <div id="lm-sukses" class="hidden overflow-y-auto p-6 text-center sm:p-8">
            <div class="mx-auto grid h-20 w-20 place-items-center rounded-full bg-teal-50 ring-8 ring-teal-50/50">
                <svg class="draw-check h-10 w-10 text-teal-500" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            </div>
            
            <h3 class="mt-5 text-2xl font-extrabold text-navy-900">Lamaran terkirim</h3>
            <p id="lm-sukses-teks" class="mt-1 text-sm"></p>

            <ol class="mx-auto mt-6 max-w-sm space-y-3 text-left text-sm">
                <li class="flex gap-3"><span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-teal-500 text-xs font-bold text-white">1</span><span>Perusahaan meninjau lamaranmu (biasanya 1–3 hari kerja).</span></li>
                <li class="flex gap-3"><span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-teal-500 text-xs font-bold text-white">2</span><span>Kabar dikirim lewat <b id="lm-sukses-kontak" class="text-navy-900"></b>.</span></li>
                <li class="flex gap-3"><span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-teal-500 text-xs font-bold text-white">3</span><span>Jika lolos, <b id="lm-sukses-jbi" class="text-navy-900"></b></span></li>
            </ol>

            <div class="mt-7 grid gap-2 sm:grid-cols-2">
                <a href="{{ route('riwayat') }}" class="rounded-lg bg-navy-900 py-3 text-sm font-semibold text-white transition hover:bg-teal-600">Lihat Riwayat Lamaran</a>
                <button type="button" class="modal-close rounded-lg border border-slate-200 py-3 text-sm font-semibold text-navy-900 transition hover:border-navy-900">Cari Lowongan Lain</button>
            </div>
        </div>
    </div>
</div>

<script type="application/json" id="lm-akses-label">@json(config('tunaker.akses'))</script>
