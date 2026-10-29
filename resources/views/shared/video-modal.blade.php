{{-- Modal video panduan BISINDO. Dibuka oleh tombol .video-btn (data-video, data-judul) --}}
<div id="video-modal" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/80 p-4 backdrop-blur-sm">
    <div class="pop-in w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-teal-600">Panduan BISINDO</p>
                <p id="video-judul" class="font-bold text-navy-900"></p>
            </div>
            <button type="button" class="modal-close grid h-9 w-9 place-items-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-navy-900" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <video id="video-player" class="hidden aspect-video w-full bg-black" controls playsinline></video>
        <div id="video-empty" class="grid aspect-video place-items-center bg-gradient-to-br from-navy-900 to-navy-700 p-8 text-center text-white">
            <div>
                <p class="text-6xl" aria-hidden="true">🤟</p>
                <p class="mt-4 text-lg font-bold">Video panduan sedang disiapkan</p>
                <p class="mt-1 text-sm text-slate-300">Sementara itu, tombol <b>“Isyarat”</b> di samping tiap kolom menampilkan penjelasan singkat.</p>
            </div>
        </div>
    </div>
</div>
