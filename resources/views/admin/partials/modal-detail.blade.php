{{-- Pop up detail umum untuk halaman admin. Diisi lewat window.TunakerAdmin.bukaDetail() di resources/js/admin/admin.js --}}
<div id="md" data-modal class="fixed inset-0 z-50 hidden place-items-center bg-navy-950/70 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="md-judul">
    <div class="pop-in flex max-h-[92vh] w-full max-w-lg flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-start gap-4 bg-gradient-to-br from-navy-900 to-navy-700 p-5 text-white sm:p-6">
            <span id="md-inisial" class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-white/10 text-lg font-extrabold ring-1 ring-white/20" aria-hidden="true"></span>
            <div class="min-w-0 flex-1">
                <h2 id="md-judul" tabindex="-1" class="text-lg font-extrabold leading-snug focus:outline-none"></h2>
                <p id="md-sub" class="text-sm text-slate-300"></p>
                <div id="md-lencana" class="mt-2 flex flex-wrap gap-2"></div>
            </div>
            <button type="button" class="modal-close grid h-9 w-9 shrink-0 place-items-center rounded-full text-slate-300 hover:bg-white/10 hover:text-white" aria-label="Tutup">
                <x-admin.ikon nama="tambah" class="h-5 w-5 rotate-45" tebal="2" />
            </button>
        </div>
        <dl id="md-isi" class="grid flex-1 gap-x-6 gap-y-4 overflow-y-auto p-5 sm:grid-cols-2 sm:p-6"></dl>
        <div id="md-aksi" class="flex flex-wrap justify-end gap-2 border-t border-slate-100 p-4"></div>
    </div>
</div>
