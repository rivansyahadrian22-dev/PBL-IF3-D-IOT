<?php

namespace App\Support\Admin;

use Carbon\Carbon;

/**
 * CONTOH data operasional untuk halaman admin: perusahaan, lowongan, lamaran, kartu RFID, pelatihan.
 *
 * Semuanya saling terhubung dan dihitung dari ContohAdmin::semuaPencari() serta config/lowongan.php,
 * jadi angka di tiap halaman konsisten (jumlah pelamar per lowongan = jumlah lamaran sebenarnya, dst).
 * Ganti dengan query database setelah backend siap.
 */
class ContohOperasional
{
    public const STATUS_LOWONGAN = ['aktif' => 'Aktif', 'review' => 'Perlu Review', 'ditutup' => 'Ditutup', 'draft' => 'Draft'];

    public const STATUS_PERUSAHAAN = ['aktif' => 'Aktif', 'verifikasi' => 'Menunggu Verifikasi', 'nonaktif' => 'Nonaktif'];

    public const TAHAP = [1 => 'Review Berkas', 2 => 'Tes / Portofolio', 3 => 'Wawancara', 4 => 'Offering'];

    public const STATUS_KARTU = ['aktif' => 'Aktif', 'menunggu' => 'Menunggu Aktivasi', 'hilang' => 'Rusak / Hilang'];

    public const GATE = ['Gate Disnaker Pusat', 'Gate BLK Bekasi', 'Gate SLB Bandung', 'Gate Job Fair Jakarta', 'Gate Kantor Mitra'];

    private static array $cache = [];

    /** Samakan nama sektor dari config/lowongan.php dengan daftar sektor di sistem. */
    private static function sektor(string $nama): string
    {
        return [
            'Perkantoran & Umum' => 'Perkantoran & Administrasi',
            'Studio Desain & Kreatif' => 'Desain & Kreatif',
            'Multimedia & Content Studio' => 'Desain & Kreatif',
            'Software House & Engineering' => 'Teknologi & Software',
            'Layanan Pelanggan Digital' => 'Layanan Pelanggan',
            'Finansial & Perbankan' => 'Keuangan & Perbankan',
        ][$nama] ?? $nama;
    }

    private static function ingat(string $kunci, callable $buat): array
    {
        return self::$cache[$kunci] ??= $buat();
    }

    /* ------------------------------------------------------------------ Perusahaan */

    private static function dasarPerusahaan(): array
    {
        return self::ingat('dasarPerusahaan', function () {
            $sekarang = Carbon::now()->startOfDay();
            $depan = ['Maju', 'Sentosa', 'Karya', 'Nusantara', 'Cahaya', 'Mitra', 'Global', 'Prima', 'Bersama', 'Digital', 'Kreasi', 'Mandiri', 'Harapan', 'Sinergi', 'Jaya', 'Teknologi', 'Kencana', 'Surya', 'Bintang', 'Anugerah'];
            $belakang = ['Abadi', 'Utama', 'Lestari', 'Perkasa', 'Makmur', 'Sejahtera', 'Indonesia', 'Persada', 'Solusi', 'Industri'];
            $sektor = ['Manufaktur & Produksi', 'Desain & Kreatif', 'Teknologi & Software', 'Layanan Pelanggan', 'Perdagangan & Retail', 'Logistik & Pergudangan', 'Kuliner & Hospitality', 'Pendidikan & Komunitas', 'Keuangan & Perbankan', 'Kesehatan', 'Perkantoran & Administrasi'];
            $kota = ['Jakarta Selatan', 'Jakarta Timur', 'Bandung', 'Bekasi', 'Tangerang', 'Depok', 'Surabaya', 'Malang', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar'];

            $baris = [];
            $tambah = function (string $nama, string $sektorNama, string $lokasi, bool $ramah, string $status) use (&$baris, $sekarang) {
                $n = count($baris);
                $slug = trim(preg_replace('/[^a-z0-9]+/', '', strtolower($nama)), '-');
                $baris[] = [
                    'id' => sprintf('PRS-%03d', $n + 1),
                    'nama' => $nama,
                    'nib' => '9120' . sprintf('%09d', (($n + 1) * 7345921) % 1000000000),
                    'sektor' => $sektorNama,
                    'lokasi' => $lokasi,
                    'ramah' => $ramah,
                    'status' => $status,
                    'email' => 'hrd@' . $slug . '.co.id',
                    'bergabung' => $sekarang->copy()->subDays(($n * 9) % 700)->format('Y-m-d'),
                ];
            };

            // Perusahaan yang punya lowongan di config/lowongan.php
            $dikenal = [];
            foreach (config('lowongan.data') as $j) {
                if (isset($dikenal[$j['perusahaan']])) {
                    continue;
                }
                $dikenal[$j['perusahaan']] = true;
                $tambah($j['perusahaan'], self::sektor($j['bidang']), $j['lokasi'] === 'Remote' ? 'Jakarta Pusat' : $j['lokasi'], true, 'aktif');
            }

            // Sisanya dibuat otomatis sampai 128 perusahaan
            for ($k = 0; count($baris) < 128; $k++) {
                $nama = ($k % 4 === 3 ? 'CV ' : 'PT ') . $depan[$k % 20] . ' ' . $belakang[intdiv($k, 20) % 10];
                $v = ($k * 7 + 3) % 100;
                $status = $v < 6 ? 'verifikasi' : ($v < 20 ? 'nonaktif' : 'aktif');
                $tambah($nama, $sektor[($k * 3) % count($sektor)], $kota[($k * 5) % count($kota)], ($k * 11) % 100 < 34, $status);
            }

            return $baris;
        });
    }

    public static function perusahaan(): array
    {
        $jumlah = [];
        foreach (self::lowongan() as $l) {
            $jumlah[$l['perusahaan']] = ($jumlah[$l['perusahaan']] ?? 0) + 1;
        }

        return array_map(fn ($p) => $p + ['lowongan' => $jumlah[$p['nama']] ?? 0], self::dasarPerusahaan());
    }

    /* ------------------------------------------------------------------ Lowongan */

    private static function dasarLowongan(): array
    {
        return self::ingat('dasarLowongan', function () {
            $sekarang = Carbon::now()->startOfDay();
            $perusahaan = collect(self::dasarPerusahaan())->keyBy('nama');
            $kunciAkses = array_keys(config('tunaker.akses'));
            $baris = [];
            $nyata = array_values(array_unique(array_column(config('lowongan.data'), 'perusahaan')));

            foreach (config('lowongan.data') as $slug => $j) {
                $p = $perusahaan[$j['perusahaan']];
                $baris[] = [
                    'id' => sprintf('LWG-%04d', count($baris) + 1),
                    'slug' => $slug,
                    'posisi' => $j['posisi'],
                    'perusahaan' => $j['perusahaan'],
                    'perusahaanId' => $p['id'],
                    'sektor' => self::sektor($j['bidang']),
                    'lokasi' => $j['lokasi'],
                    'tipe' => $j['tipe'],
                    'kuota' => 2 + (count($baris) * 3) % 5,
                    'akses' => $j['akses'],
                    'gaji' => $j['gaji'],
                    'dibuat' => $sekarang->copy()->subDays($j['hari'])->format('Y-m-d'),
                    'batas' => $j['batas'],
                    'status' => $slug === 'staff-rekonsiliasi-dokumen' ? 'review' : 'aktif',
                ];
            }

            $posisi = ['Staff Gudang', 'Admin Penjualan', 'Operator Mesin', 'Desainer Kemasan', 'Kasir', 'Barista', 'Pembuat Konten', 'Staff Arsip', 'Tukang Jahit', 'Quality Checker', 'Teknisi Komputer', 'Asisten Dapur',
                       'Staff Input Data', 'Fotografer Produk', 'Pengemas Barang', 'Staff Kebersihan Kantor', 'Editor Video', 'Staff Keuangan', 'Operator Produksi', 'Customer Service (Chat)'];
            $tipe = ['Full Time', 'Full Time', 'Part Time', 'Hybrid', 'Magang'];

            foreach (self::dasarPerusahaan() as $idx => $p) {
                // Perusahaan dari config sudah punya lowongan sendiri; yang lain bergiliran
                if ($p['status'] !== 'aktif' || in_array($p['nama'], $nyata, true) || $idx % 3 !== 0) {
                    continue;
                }
                for ($k = 0; $k < 1 + ($idx % 2); $k++) {
                    $n = count($baris);
                    $v = ($n * 17) % 100;
                    $akses = [];
                    foreach ([0, 2, 4] as $o) {
                        if (($n + $o) % 3 !== 0 || $o === 0) {
                            $akses[] = $kunciAkses[($n + $o) % count($kunciAkses)];
                        }
                    }
                    $baris[] = [
                        'id' => sprintf('LWG-%04d', $n + 1),
                        'slug' => null,
                        'posisi' => $posisi[($idx * 3 + $k * 7) % count($posisi)],
                        'perusahaan' => $p['nama'],
                        'perusahaanId' => $p['id'],
                        'sektor' => $p['sektor'],
                        'lokasi' => $p['lokasi'],
                        'tipe' => $tipe[($n * 3) % count($tipe)],
                        'kuota' => 1 + ($n * 5) % 6,
                        'akses' => array_values(array_unique($akses)),
                        'gaji' => [3.5 + ($n % 4) * 0.5, 4.5 + ($n % 5) * 0.8],
                        'dibuat' => $sekarang->copy()->subDays(($n * 3) % 40)->format('Y-m-d'),
                        'batas' => $sekarang->copy()->addDays(10 + ($n * 4) % 45)->format('Y-m-d'),
                        'status' => $v < 10 ? 'review' : ($v < 22 ? 'ditutup' : ($v < 28 ? 'draft' : 'aktif')),
                    ];
                }
            }

            return $baris;
        });
    }

    public static function lowongan(): array
    {
        $jumlah = [];
        $siap = [];
        foreach (self::lamaran() as $l) {
            $jumlah[$l['lowonganId']] = ($jumlah[$l['lowonganId']] ?? 0) + 1;
            if ($l['tahap'] === 1 && $l['status'] === 'review') {
                $siap[$l['lowonganId']] = ($siap[$l['lowonganId']] ?? 0) + 1;
            }
        }

        return array_map(fn ($l) => $l + [
            'pelamar' => $jumlah[$l['id']] ?? 0,
            'siapVerifikasi' => $siap[$l['id']] ?? 0,
        ], self::dasarLowongan());
    }

    /* ------------------------------------------------------------------ Lamaran */

    public static function lamaran(): array
    {
        return self::ingat('lamaran', function () {
            $sekarang = Carbon::now();
            $layak = array_values(array_filter(ContohAdmin::semuaPencari(), fn ($p) => in_array($p['status'], ['terverifikasi', 'bekerja'], true)));
            $terbuka = array_values(array_filter(self::dasarLowongan(), fn ($l) => in_array($l['status'], ['aktif', 'review'], true)));
            $baris = [];

            for ($i = 0; $i < 420; $i++) {
                $p = $layak[$i % count($layak)];
                $l = $terbuka[($i * 7 + intdiv($i, count($layak))) % count($terbuka)];

                $tanggal = Carbon::parse($p['daftar'])->addDays(1 + ($i * 3) % 25)->setTime(8 + ($i * 5) % 10, ($i * 17) % 60);
                if ($tanggal->gt($sekarang)) {
                    $tanggal = $sekarang->copy()->subDays($i % 9)->setTime(8 + ($i * 5) % 10, ($i * 17) % 60);
                }

                $v = ($i * 29 + 11) % 100;
                if ($v < 18) { $status = 'review'; $tahap = 1; }
                elseif ($v < 40) { $status = 'tes'; $tahap = 2; }
                elseif ($v < 62) { $status = 'wawancara'; $tahap = 3; }
                elseif ($v < 78) { $status = 'offering'; $tahap = 4; }
                elseif ($v < 92) { $status = 'diterima'; $tahap = 4; }
                else { $status = 'ditolak'; $tahap = 1 + $i % 3; }

                $baris[] = [
                    'id' => sprintf('LMR-%04d', $i + 1),
                    'pencariId' => $p['id'],
                    'nama' => $p['nama'],
                    'rfid' => str_replace('TNK', 'RFID', $p['id']),
                    'lowonganId' => $l['id'],
                    'posisi' => $l['posisi'],
                    'perusahaan' => $l['perusahaan'],
                    'tanggal' => $tanggal->format('Y-m-d H:i'),
                    'tahap' => $tahap,
                    'status' => $status,
                    'komunikasi' => $p['komunikasi'],
                    'jbi' => $p['komunikasi'] === 'BISINDO',
                    'prioritas' => $i % 5 === 0,
                ];
            }

            usort($baris, fn ($a, $b) => [$b['tanggal'], $b['id']] <=> [$a['tanggal'], $a['id']]);

            return $baris;
        });
    }

    /* ------------------------------------------------------------------ RFID */

    public static function rfid(): array
    {
        return self::ingat('rfid', function () {
            $sekarang = Carbon::now();
            $baris = [];
            $i = 0;

            foreach (ContohAdmin::semuaPencari() as $p) {
                if ($p['status'] === 'ditolak') {
                    continue;
                }
                $v = ($i * 37) % 100;
                $status = $p['status'] === 'menunggu' ? 'menunggu' : ($v < 4 ? 'hilang' : ($v < 8 ? 'menunggu' : 'aktif'));
                $tap = $status === 'aktif' ? $sekarang->copy()->subMinutes(30 + ($i * 977) % 28000) : null;

                $baris[] = [
                    'id' => str_replace('TNK', 'RFID', $p['id']),
                    'serial' => strtoupper(implode(':', str_split(substr(md5($p['id']), 0, 12), 2))),
                    'pencariId' => $p['id'],
                    'nama' => $p['nama'],
                    'nik' => '3174••••••••' . sprintf('%04d', (($i + 5) * 7919) % 10000),
                    'komunikasi' => $p['komunikasi'],
                    'batch' => 'Batch ' . Carbon::parse($p['daftar'])->format('Y-m'),
                    'status' => $status,
                    'tap' => $tap?->format('Y-m-d H:i'),
                    'gate' => $tap ? self::GATE[($i * 3) % count(self::GATE)] : null,
                    'diterbitkan' => $p['daftar'],
                ];
                $i++;
            }

            return $baris;
        });
    }

    /* ------------------------------------------------------------------ Pelatihan */

    public static function pelatihan(): array
    {
        return self::ingat('pelatihan', function () {
            $hari = Carbon::now()->startOfDay();
            $d = fn (int $selisih) => $hari->copy()->addDays($selisih)->format('Y-m-d');

            // [judul, kategori, instruktur, instruktur Tuli?, dukungan bahasa, kuota, terisi, mulai, minggu, status, lulus %, sertifikasi, lokasi, perlu update bahasa?]
            $data = [
                ['Frontend Development & Accessibility Web', 'Teknologi', 'Rizky Pratama', true, 'BISINDO penuh + subtitle', 30, 28, -21, 8, 'berjalan', null, 'BNSP', 'Hybrid', false],
                ['UI/UX Design Mentoring Inklusif', 'Desain', 'Maya Anggraini', true, 'BISINDO penuh + subtitle', 25, 25, -35, 6, 'berjalan', null, 'BNSP', 'Online', false],
                ['Barista Profesional & Manajemen Kafe Inklusif', 'Kuliner', 'Agus Setiawan', true, 'Juru bahasa sesi live', 20, 14, 12, 5, 'dibuka', null, 'Kemnaker', 'Onsite', false],
                ['Administrasi Perkantoran & Spreadsheet', 'Administrasi', 'Dewi Lestari', false, 'Video BISINDO + teks', 40, 33, -14, 4, 'berjalan', null, 'Internal', 'Online', true],
                ['Pelatihan Bahasa Isyarat (BISINDO) Tingkat Profesional HRD', 'Bahasa Isyarat', 'Komunitas Gerkatin', true, 'BISINDO penuh', 35, 21, 20, 6, 'dibuka', null, 'Internal', 'Hybrid', false],
                ['Data Entry & Otomasi Microsoft Excel', 'Administrasi', 'Disnaker Kota Bandung', false, 'Video BISINDO + teks', 40, 40, -80, 4, 'selesai', 94, 'Kemnaker', 'Online', false],
                ['Video Editing & Animasi Motion', 'Desain', 'Studio Visual Nusa', true, 'Subtitle lengkap', 24, 24, -95, 5, 'selesai', 89, 'Internal', 'Online', true],
                ['Pemrograman Web Dasar: HTML, CSS & JavaScript', 'Teknologi', 'Akademi Inklusi Digital', true, 'BISINDO penuh + subtitle', 30, 30, -120, 8, 'selesai', 92, 'BNSP', 'Online', false],
                ['Menjahit & Produksi Garmen', 'Manufaktur', 'PT Garmen Sejahtera', false, 'Juru bahasa sesi live', 18, 11, 30, 6, 'dibuka', null, 'Kemnaker', 'Onsite', true],
                ['Komunikasi Tertulis di Tempat Kerja', 'Soft Skill', 'Gerkatin Pusat', true, 'Teks dan contoh email', 50, 46, -10, 3, 'berjalan', null, 'Internal', 'Online', false],
                ['Fotografi Produk untuk Toko Online', 'Desain', 'Kreatif Media Nusantara', false, 'Subtitle lengkap', 20, 20, -150, 4, 'selesai', 96, 'Internal', 'Hybrid', false],
                ['Customer Service via Chat dan Email', 'Soft Skill', 'PT Layanan Prima', true, 'Teks dan contoh percakapan', 45, 0, 45, 4, 'draft', null, 'Internal', 'Online', true],
            ];

            return array_map(function ($r, $i) use ($d) {
                return [
                    'id' => sprintf('PLT-%03d', $i + 1),
                    'judul' => $r[0], 'kategori' => $r[1], 'instruktur' => $r[2], 'instrukturTuli' => $r[3], 'bahasa' => $r[4],
                    'kuota' => $r[5], 'terisi' => $r[6], 'mulai' => $d($r[7]), 'selesai' => $d($r[7] + $r[8] * 7), 'minggu' => $r[8],
                    'status' => $r[9], 'lulus' => $r[10], 'sertifikasi' => $r[11], 'lokasi' => $r[12], 'perluUpdate' => $r[13],
                ];
            }, $data, array_keys($data));
        });
    }

    /* ------------------------------------------------------------------ Ringkasan halaman */

    public static function lencanaMenu(): array
    {
        return [
            'lowongan' => count(self::dasarLowongan()),
            'pelatihan' => count(self::pelatihan()),
            'perusahaan' => count(self::dasarPerusahaan()),
            'lamaran' => count(self::lamaran()),
        ];
    }

    /** Data mentah untuk Statistik & Laporan (dihitung ulang di browser sesuai periode). */
    public static function laporan(): array
    {
        return [
            'pencari' => array_map(fn ($p) => ['daftar' => $p['daftar'], 'bekerja' => $p['bekerja'], 'status' => $p['status'], 'komunikasi' => $p['komunikasi'], 'bidang' => $p['bidang']], ContohAdmin::semuaPencari()),
            'lamaran' => array_map(fn ($l) => ['tanggal' => substr($l['tanggal'], 0, 10), 'status' => $l['status'], 'lowonganId' => $l['lowonganId']], self::lamaran()),
            'lowongan' => array_map(fn ($l) => ['id' => $l['id'], 'sektor' => $l['sektor'], 'kuota' => $l['kuota'], 'status' => $l['status']], self::dasarLowongan()),
            'perusahaan' => array_map(fn ($p) => ['sektor' => $p['sektor'], 'ramah' => $p['ramah'], 'status' => $p['status']], self::dasarPerusahaan()),
            'komunikasi' => ContohAdmin::KOMUNIKASI,
        ];
    }
}
