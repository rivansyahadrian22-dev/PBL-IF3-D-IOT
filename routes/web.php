<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::view('/daftar', 'auth.daftar')->name('daftar');
Route::view('/masuk', 'auth.masuk')->name('masuk');
Route::view('/beranda', 'beranda')->name('beranda');
Route::view('/rekomendasi', 'rekomendasi')->name('rekomendasi');
Route::view('/pelatihan', 'pelatihan')->name('pelatihan');
Route::view('/konsultasi', 'konsultasi')->name('konsultasi');
Route::view('/lowongan', 'lowongan')->name('lowongan');
Route::view('/riwayat-lamaran', 'riwayat')->name('riwayat');
Route::view('/profil', 'profil')->name('profil');
Route::get('/lowongan/{slug}', function (string $slug) {
    $job = config("lowongan.data.$slug") ?? abort(404);

    return view('lowongan-detail', ['job' => $job]);
})->name('lowongan.detail');
Route::view('/profil/edit', 'profil-edit')->name('profil.edit');
