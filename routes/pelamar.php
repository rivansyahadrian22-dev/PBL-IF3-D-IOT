<?php

use Illuminate\Support\Facades\Route;

// Halaman publik
Route::view('/', 'pelamar.landing')->name('home');
Route::view('/daftar', 'pelamar.auth.daftar')->name('daftar');
Route::view('/masuk', 'pelamar.auth.masuk')->name('masuk');

// Area pelamar (belum dilindungi login; tambahkan middleware auth setelah backend siap)
Route::view('/beranda', 'pelamar.beranda')->name('beranda');
Route::view('/rekomendasi', 'pelamar.rekomendasi')->name('rekomendasi');
Route::view('/pelatihan', 'pelamar.pelatihan')->name('pelatihan');
Route::view('/konsultasi', 'pelamar.konsultasi')->name('konsultasi');
Route::view('/lowongan', 'pelamar.lowongan')->name('lowongan');
Route::get('/lowongan/{slug}', function (string $slug) {
    $job = config("lowongan.data.$slug") ?? abort(404);

    return view('pelamar.lowongan-detail', ['job' => $job]);
})->name('lowongan.detail');
Route::view('/riwayat-lamaran', 'pelamar.riwayat')->name('riwayat');
Route::view('/profil', 'pelamar.profil')->name('profil');
Route::view('/profil/edit', 'pelamar.profil-edit')->name('profil.edit');
