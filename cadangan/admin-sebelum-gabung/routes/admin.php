<?php

use App\Support\Admin\ContohAdmin;
use App\Support\Admin\ContohOperasional;
use Illuminate\Support\Facades\Route;

// Area admin (belum dilindungi login; tambahkan middleware auth + peran admin setelah backend siap)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => view('admin.dashboard', ContohAdmin::dashboard()))->name('dashboard');
    Route::get('/pencari-kerja', fn () => view('admin.pencari', ContohAdmin::pencari()))->name('pencari');

    Route::get('/lowongan-kerja', fn () => view('admin.lowongan', [
        'rows' => ContohOperasional::lowongan(),
        'perusahaan' => ContohOperasional::perusahaan(),
    ]))->name('lowongan');

    Route::get('/pelatihan', fn () => view('admin.pelatihan', ['rows' => ContohOperasional::pelatihan()]))->name('pelatihan');
    Route::get('/perusahaan', fn () => view('admin.perusahaan', ['rows' => ContohOperasional::perusahaan()]))->name('perusahaan');

    Route::get('/lamaran', fn () => view('admin.lamaran', [
        'rows' => ContohOperasional::lamaran(),
        'lowongan' => ContohOperasional::lowongan(),
    ]))->name('lamaran');

    Route::get('/rfid', fn () => view('admin.rfid', ['rows' => ContohOperasional::rfid()]))->name('rfid');
    Route::view('/laporan', 'admin.laporan')->name('laporan');
    Route::view('/pengaturan', 'admin.pengaturan')->name('pengaturan');
});
