@extends('pelamar.layouts.app')

@section('title', 'Konsultasi AI')

@php
    $topik = [
        ['📄', 'Cek Kecocokan CV', 'Apakah CV saya sudah cocok untuk posisi Desainer Grafis?'],
        ['💬', 'Latihan Wawancara Teks', 'Ayo latihan wawancara kerja lewat teks.'],
        ['💰', 'Rekomendasi Gaji Desainer', 'Berapa kisaran gaji desainer grafis junior?'],
        ['🛡️', 'Hak Aksesibilitas di Tempat Kerja', 'Apa saja hak akomodasi saya di tempat kerja?'],
        ['🎓', 'Pelatihan yang Cocok', 'Pelatihan apa yang cocok untuk saya?'],
    ];

    $konfigurasi = [
        ['Mode respons', 'Teks ringkas & visual'],
        ['Bahasa utama', 'Bahasa Indonesia & BISINDO'],
        ['Sinkronisasi lowongan', '● Terhubung'],
        ['Simpan riwayat', 'Aktif'],
    ];
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <x-pelamar.halaman.judul judul="Konsultasi Karier AI Teman Tuli" badge="Asisten Karier"
                     deskripsi="Dapatkan saran karier, review CV, latihan wawancara berbasis teks, dan rekomendasi keterampilan yang disesuaikan dengan profil komunikasimu.">
        <button type="button" id="simpan-chat" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-900 transition hover:border-navy-900">
            Simpan Percakapan
        </button>
        <button type="button" id="sesi-baru" class="inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-navy-900/20 transition hover:bg-navy-800">
            ＋ Sesi Baru
        </button>
    </x-pelamar.halaman.judul>

    <div class="grid gap-6 xl:grid-cols-[1fr_20rem]">
        {{-- ============ RUANG CHAT ============ --}}
        <section data-chat class="flex min-h-[36rem] flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
            <div class="flex flex-wrap items-center gap-3 border-b border-slate-100 p-4 sm:px-6">
                <span class="relative grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 text-2xl" aria-hidden="true">
                    🤖
                    <span class="absolute -bottom-0.5 -right-0.5 h-3.5 w-3.5 rounded-full bg-emerald-400 ring-2 ring-white"></span>
                </span>
                <div class="min-w-0 flex-1">
                    <h2 class="font-extrabold text-navy-900">Asisten Karier AI TUNAKER</h2>
                    <p class="text-xs text-slate-500">Jawaban ditampilkan dalam teks singkat</p>
                </div>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">● Online</span>
            </div>

            <div data-chat-log class="flex max-h-[32rem] flex-1 flex-col gap-4 overflow-y-auto bg-surface p-4 sm:p-6">
                <p class="self-center rounded-full bg-white px-3 py-1 text-[11px] font-semibold text-slate-500 shadow-sm">Hari ini · Sesi konsultasi karier</p>
                <div class="flex max-w-[85%] flex-col items-start gap-1">
                    <div class="rounded-2xl rounded-tl-sm bg-white p-4 text-sm leading-relaxed text-navy-900 shadow-sm">
                        Halo Andi. Saya asisten karier TUNAKER. Profilmu sudah <b class="text-teal-600">78% lengkap</b>.
                        <br><br>Silakan tanya soal CV, latihan wawancara lewat teks, atau cara meminta fasilitas kerja yang kamu butuhkan.
                    </div>
                    <span class="px-1 text-[10px] text-slate-400">Asisten AI · 09.00</span>
                </div>
                <div class="flex max-w-[85%] flex-col items-end gap-1 self-end">
                    <div class="rounded-2xl rounded-tr-sm bg-navy-900 p-4 text-sm leading-relaxed text-white shadow-sm">
                        Tolong berikan contoh jawaban wawancara kalau ditanya "bagaimana cara kamu berkomunikasi dengan tim?"
                    </div>
                    <span class="px-1 text-[10px] text-slate-400">Kamu · 09.02</span>
                </div>
                <div class="flex max-w-[85%] flex-col items-start gap-1">
                    <div class="rounded-2xl rounded-tl-sm bg-white p-4 text-sm leading-relaxed text-navy-900 shadow-sm">
                        Contoh jawaban:
                        <blockquote class="mt-2 rounded-xl border-l-4 border-teal-500 bg-teal-50 p-3 text-navy-900">
                            "Saya paling nyaman berkomunikasi lewat tulisan dan BISINDO. Di tempat kerja sebelumnya, tugas dan hasil rapat saya catat di chat kantor supaya tidak ada yang terlewat."
                        </blockquote>
                        <p class="mt-2">Kalau mau, saya bantu sesuaikan dengan pengalamanmu.</p>
                    </div>
                    <span class="px-1 text-[10px] text-slate-400">Asisten AI · 09.02</span>
                </div>
            </div>

            <div class="border-t border-slate-100 p-4 sm:px-6">
                <form data-chat-form class="flex items-end gap-2 rounded-2xl border border-slate-200 bg-white p-2 transition focus-within:border-teal-500 focus-within:ring-4 focus-within:ring-teal-500/15">
                    <button type="button" class="lampiran grid h-10 w-10 shrink-0 place-items-center rounded-xl text-slate-400 transition hover:bg-surface hover:text-navy-900" aria-label="Lampirkan CV">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m18.38 12.74-7.28 7.28a4.5 4.5 0 0 1-6.36-6.36l10.94-10.94A3 3 0 1 1 19.92 6.97L8.69 18.2a1.5 1.5 0 0 1-2.13-2.12l7.88-7.88"/></svg>
                    </button>
                    <textarea rows="1" placeholder="Tulis pertanyaanmu tentang karier, CV, atau wawancara…" aria-label="Pertanyaan untuk AI"
                              class="max-h-32 min-h-10 flex-1 resize-none bg-transparent py-2 text-sm text-navy-900 placeholder:text-slate-400 focus:outline-none"></textarea>
                    <button type="submit" class="inline-flex h-10 shrink-0 items-center gap-2 rounded-xl bg-navy-900 px-4 text-sm font-semibold text-white transition hover:bg-teal-600">
                        <span class="hidden sm:inline">Kirim</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.27 3.13A59.8 59.8 0 0 1 21.49 12 59.8 59.8 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/></svg>
                    </button>
                </form>
                <p class="mt-2 text-[11px] text-slate-400">Percakapan bersifat pribadi. Tekan <b>Enter</b> untuk mengirim, <b>Shift + Enter</b> untuk baris baru.</p>
            </div>
        </section>

        {{-- ============ PANEL KANAN ============ --}}
        <aside class="space-y-4">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="font-extrabold text-navy-900">Topik Populer Cepat</p>
                <p class="mt-1 text-xs text-slate-500">Pilih topik untuk langsung bertanya.</p>
                <div class="mt-4 space-y-2">
                    @foreach ($topik as [$emoji, $judul, $tanya])
                        <button type="button" data-chat-ask="{{ $tanya }}" class="flex w-full items-center gap-3 rounded-xl border border-slate-100 p-3 text-left text-sm font-semibold text-navy-900 transition hover:border-teal-500 hover:bg-teal-50">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-surface text-lg" aria-hidden="true">{{ $emoji }}</span>
                            <span class="flex-1">{{ $judul }}</span>
                            <span class="text-slate-400" aria-hidden="true">→</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="font-extrabold text-navy-900">Status Konfigurasi AI</p>
                <dl class="mt-3 divide-y divide-slate-100 text-sm">
                    @foreach ($konfigurasi as [$label, $nilai])
                        <div class="flex items-center justify-between gap-3 py-2.5">
                            <dt class="text-slate-500">{{ $label }}</dt>
                            <dd class="text-right font-semibold {{ str_starts_with($nilai, '●') ? 'text-emerald-600' : 'text-navy-900' }}">{{ $nilai }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 p-5 text-white">
                <div class="absolute -bottom-10 -right-10 h-32 w-32 rounded-full bg-teal-500/30 blur-2xl" aria-hidden="true"></div>
                <p class="relative text-2xl" aria-hidden="true">🧑‍🤝‍🧑</p>
                <p class="relative mt-2 font-extrabold">Butuh Pendamping Manusia?</p>
                <p class="relative mt-1 text-sm text-slate-300">Jika jawaban AI belum cukup, konselor karier Tuli siap membantu lewat chat atau video call BISINDO.</p>
                <a href="#" class="relative mt-4 block rounded-lg bg-teal-500 py-2.5 text-center text-sm font-bold transition hover:bg-teal-600">Hubungi Konselor Karier</a>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    (() => {
        const { toast } = window.TunakerUI;
        const log = document.querySelector('[data-chat-log]');
        const awal = log.innerHTML;

        // Textarea ikut membesar sesuai isi
        const area = document.querySelector('[data-chat-form] textarea');
        area.addEventListener('input', () => { area.style.height = 'auto'; area.style.height = `${area.scrollHeight}px`; });
        area.form.addEventListener('submit', () => { area.style.height = 'auto'; });

        document.getElementById('sesi-baru').addEventListener('click', () => {
            log.innerHTML = awal;
            log.scrollTop = 0;
            toast('Sesi baru dimulai.', '✨');
        });
        document.getElementById('simpan-chat').addEventListener('click', () => {
            // TODO: simpan percakapan ke backend
            toast('Penyimpanan percakapan belum tersedia. Backend belum disambungkan.', '💾');
        });
        document.querySelector('.lampiran').addEventListener('click', () => toast('Unggah CV ke chat akan tersedia setelah ai-service siap.', '📎'));
    })();
</script>
@endpush
