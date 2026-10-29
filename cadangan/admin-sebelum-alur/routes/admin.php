<?php

use App\Support\Admin\ContohAdmin;
use App\Support\Admin\ContohOperasional;
use Illuminate\Support\Facades\Route;

// Area admin (belum dilindungi login; tambahkan middleware auth + peran admin setelah backend siap)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => view('admin.dashboard', ContohAdmin::dashboard()))->name('dashboard');

    // Menu "Pencari Kerja": daftar pencari + kartu Smart ID
    Route::get('/pencari-kerja', fn () => view('admin.pencari', ContohAdmin::pencari()))->name('pencari');
    Route::get('/pencari-kerja/kartu', fn () => view('admin.rfid', ['rows' => ContohOperasional::rfid()]))->name('rfid');

    // Menu "Mitra": perusahaan + lowongan
    Route::get('/mitra/perusahaan', fn () => view('admin.perusahaan', ['rows' => ContohOperasional::perusahaan()]))->name('perusahaan');
    Route::get('/mitra/lowongan', fn () => view('admin.lowongan', [
        'rows' => ContohOperasional::lowongan(),
        'perusahaan' => ContohOperasional::perusahaan(),
    ]))->name('lowongan');

    Route::get('/lamaran', fn () => view('admin.lamaran', [
        'rows' => ContohOperasional::lamaran(),
        'lowongan' => ContohOperasional::lowongan(),
    ]))->name('lamaran');

    Route::get('/pelatihan', fn () => view('admin.pelatihan', ['rows' => ContohOperasional::pelatihan()]))->name('pelatihan');
    Route::view('/laporan', 'admin.laporan')->name('laporan');
    Route::view('/pengaturan', 'admin.pengaturan')->name('pengaturan');

    // Alamat lama tetap berfungsi
    Route::redirect('/mitra', '/admin/mitra/perusahaan');
    Route::redirect('/perusahaan', '/admin/mitra/perusahaan');
    Route::redirect('/lowongan-kerja', '/admin/mitra/lowongan');
    Route::redirect('/rfid', '/admin/pencari-kerja/kartu');
});
