<?php

namespace App\Support\Admin;

use Carbon\Carbon;

/**
 * CONTOH data untuk halaman admin (belum ada database).
 *
 * Semua angka di dashboard (statistik, grafik tren, donut komunikasi, aktivitas terbaru)
 * dihitung dari satu daftar pencari kerja yang sama, jadi angkanya selalu konsisten.
 * Ganti isi pencari() dengan query ke database setelah backend siap.
 */
class ContohAdmin
{
    public const STATUS = [
        'menunggu' => 'Menunggu Verifikasi',
        'terverifikasi' => 'Terverifikasi',
        'bekerja' => 'Sudah Bekerja',
        'ditolak' => 'Ditolak',
    ];

    public const KOMUNIKASI = ['BISINDO', 'Tulisan / Chat', 'Membaca Gerak Bibir', 'Lisan / Alat Bantu'];

    public const PENDIDIKAN = ['SMA / SMK / SLB', 'D3', 'S1', 'S2'];

    private static ?array $cache = null;

    /** Daftar pencari kerja contoh (240 orang, didaftarkan selama 36 bulan terakhir). */
    public static function semuaPencari(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $depan = ['Dwi', 'Eka', 'Rina', 'Andi', 'Siti', 'Budi', 'Ayu', 'Rizky', 'Putri', 'Fajar', 'Nina', 'Agus', 'Dewi', 'Hendra', 'Maya', 'Yoga', 'Lestari', 'Bagas', 'Citra', 'Wahyu',
                  'Intan', 'Rendi', 'Sari', 'Arif', 'Mega', 'Dimas', 'Tika', 'Galih', 'Nur', 'Reza', 'Wulan', 'Joko', 'Fitri', 'Aldi', 'Rani', 'Taufik', 'Salsa', 'Ilham', 'Bella', 'Rama'];
        $belakang = ['Santoso', 'Wijaya', 'Lestari', 'Pratama', 'Saputra', 'Hidayat', 'Kurniawan', 'Rahmawati', 'Nugroho', 'Permata', 'Setiawan', 'Maulana', 'Utami', 'Firmansyah', 'Anggraini',
                     'Susanto', 'Ramadhan', 'Puspita', 'Wibowo', 'Handayani', 'Siregar', 'Nasution', 'Simanjuntak', 'Hasibuan', 'Lubis', 'Gunawan', 'Halim', 'Suryani', 'Mahendra', 'Purnama'];
        $kota = ['Jakarta Selatan', 'Jakarta Timur', 'Bandung', 'Bekasi', 'Tangerang', 'Depok', 'Surabaya', 'Malang', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar', 'Denpasar', 'Bogor'];
        $bidang = ['Desain & Kreatif', 'Teknologi & IT', 'Administrasi', 'Produksi', 'Kuliner', 'Retail'];
        $pendidikan = ['SMA / SMK / SLB', 'SMA / SMK / SLB', 'SMA / SMK / SLB', 'SMA / SMK / SLB', 'D3', 'S1', 'S1', 'S2'];

        $sekarang = Carbon::now()->startOfDay();
        $awalBulan = $sekarang->copy()->startOfMonth();
        $baris = [];

        for ($i = 0; $i < 240; $i++) {
            $nama = $depan[$i % 40] . ' ' . $belakang[(intdiv($i, 40) * 11 + $i * 7) % 30];

            // Lebih banyak pendaftar di bulan-bulan terakhir (pertumbuhan)
            $u = fmod(($i + 1) * 0.6180339887, 1);
            $bulanLalu = (int) floor(36 * (1 - sqrt($u)));
            $daftar = $awalBulan->copy()->subMonths($bulanLalu)->addDays(($i * 5) % 27);
            if ($daftar->gt($sekarang)) {
                $daftar = $sekarang->copy()->subDays($i % 9);
            }

            $v = ($i * 37) % 100;
            $komunikasi = $v < 48 ? self::KOMUNIKASI[0] : ($v < 83 ? self::KOMUNIKASI[1] : ($v < 94 ? self::KOMUNIKASI[2] : self::KOMUNIKASI[3]));

            $s = ($i * 53 + 17) % 100;
            $status = $s < 3 ? 'ditolak' : ($s < 15 ? 'menunggu' : ($s < 43 ? 'bekerja' : 'terverifikasi'));
            if ($daftar->diffInDays($sekarang) < 14 && $status !== 'ditolak') {
                $status = 'menunggu';
            }

            $bekerja = null;
            if ($status === 'bekerja') {
                $bekerja = $daftar->copy()->addDays(20 + ($i * 13) % 70);
                if ($bekerja->gt($sekarang)) {
                    $status = 'terverifikasi';
                    $bekerja = null;
                }
            }

            $slug = strtolower(str_replace(' ', '.', $nama));
            $baris[] = [
                'id' => sprintf('TNK-%s-%04d', $daftar->format('Y'), $i + 1),
                'nama' => $nama,
                'email' => $slug . '@contoh.id',
                'wa' => '0812' . sprintf('%08d', (($i + 3) * 7919011) % 100000000),
                'kota' => $kota[($i * 3) % count($kota)],
                'pendidikan' => $pendidikan[($i * 5) % count($pendidikan)],
                'komunikasi' => $komunikasi,
                'kondisi' => ($i * 7) % 10 < 7 ? 'Tuli' : 'Hard of Hearing',
                'bidang' => $bidang[($i * 11) % count($bidang)],
                'status' => $status,
                'daftar' => $daftar->format('Y-m-d'),
                'bekerja' => $bekerja?->format('Y-m-d'),
                'berkas' => ['ktp' => true, 'disabilitas' => $i % 7 !== 0, 'cv' => $i % 5 !== 0],
            ];
        }

        // Terbaru di atas
        usort($baris, fn ($a, $b) => [$b['daftar'], $b['id']] <=> [$a['daftar'], $a['id']]);

        return self::$cache = $baris;
    }

    /** Data ringkas untuk memilih pencari kerja di formulir lain. */
    public static function ringkas(): array
    {
        return array_map(fn ($p) => ['id' => $p['id'], 'nama' => $p['nama'], 'komunikasi' => $p['komunikasi'], 'status' => $p['status']], self::semuaPencari());
    }

    /** Data untuk halaman Pencari Kerja. */
    public static function pencari(): array
    {
        $baris = self::semuaPencari();

        return [
            'pencari' => $baris,
            'statistik' => self::statistik($baris),
            'opsi' => [
                'komunikasi' => self::KOMUNIKASI,
                'pendidikan' => self::PENDIDIKAN,
                'status' => self::STATUS,
                'kota' => collect($baris)->pluck('kota')->unique()->sort()->values()->all(),
                'bidang' => collect($baris)->pluck('bidang')->unique()->sort()->values()->all(),
            ],
        ];
    }

    /** Angka kecil untuk lencana menu sidebar admin. */
    public static function lencanaMenu(): array
    {
        return [
            'menungguIds' => collect(self::semuaPencari())->where('status', 'menunggu')->pluck('id')->values()->all(),
        ] + ContohOperasional::lencanaMenu();
    }

    /** Data untuk Dashboard Admin. */
    public static function dashboard(): array
    {
        $baris = self::semuaPencari();
        $lowongan = config('lowongan.data');

        // Donut komunikasi
        $donut = [];
        foreach (self::KOMUNIKASI as $k) {
            $donut[] = ['label' => $k, 'jumlah' => count(array_filter($baris, fn ($r) => $r['komunikasi'] === $k))];
        }

        // Aktivitas terbaru: 12 pendaftar terakhir, masing-masing dipasangkan dengan lowongan contoh
        $kunciLowongan = array_keys($lowongan);
        $aktivitas = [];
        foreach (array_slice($baris, 0, 12) as $n => $r) {
            $lw = $lowongan[$kunciLowongan[($n * 5 + 2) % count($kunciLowongan)]];
            $aktivitas[] = $r + [
                'posisi' => $lw['posisi'],
                'perusahaan' => $lw['perusahaan'],
                'dokumen' => $r['status'] === 'menunggu' ? (($n % 3 === 0) ? 'Belum ada CV' : 'Lengkap') : 'Lengkap',
            ];
        }

        return [
            'statistik' => self::statistik($baris),
            'lowonganAktif' => count($lowongan),
            'perusahaan' => collect($lowongan)->pluck('perusahaan')->unique()->count(),
            'tren' => self::tren($baris),
            'donut' => $donut,
            'aktivitas' => $aktivitas,
            'menungguIds' => collect($baris)->where('status', 'menunggu')->pluck('id')->values()->all(),
            'bekerjaIds' => collect($baris)->where('status', 'bekerja')->pluck('id')->values()->all(),
            'antrean' => ContohOperasional::antrean(),
        ];
    }

    private static function statistik(array $baris): array
    {
        $hitung = fn (string $status) => count(array_filter($baris, fn ($r) => $r['status'] === $status));
        $bulanIni = Carbon::now()->format('Y-m');
        $bulanLalu = Carbon::now()->subMonth()->format('Y-m');
        $baru = count(array_filter($baris, fn ($r) => str_starts_with($r['daftar'], $bulanIni)));
        $lalu = count(array_filter($baris, fn ($r) => str_starts_with($r['daftar'], $bulanLalu)));

        return [
            'total' => count($baris),
            'menunggu' => $hitung('menunggu'),
            'terverifikasi' => $hitung('terverifikasi') + $hitung('bekerja'),
            'bekerja' => $hitung('bekerja'),
            'ditolak' => $hitung('ditolak'),
            'baruBulanIni' => $baru,
            'naikPersen' => $lalu > 0 ? (int) round(($baru - $lalu) / $lalu * 100) : 0,
        ];
    }

    /** Pendaftaran vs penyerapan kerja: bulanan (12), kuartalan (8), tahunan. */
    private static function tren(array $baris): array
    {
        $sekarang = Carbon::now()->locale('id');
        $hitung = function (Carbon $dari, Carbon $sampai) use ($baris) {
            $daftar = $kerja = 0;
            foreach ($baris as $r) {
                if ($r['daftar'] >= $dari->toDateString() && $r['daftar'] <= $sampai->toDateString()) {
                    $daftar++;
                }
                if ($r['bekerja'] && $r['bekerja'] >= $dari->toDateString() && $r['bekerja'] <= $sampai->toDateString()) {
                    $kerja++;
                }
            }

            return [$daftar, $kerja];
        };

        $susun = function (array $rentang) use ($hitung) {
            $hasil = ['label' => [], 'daftar' => [], 'kerja' => []];
            foreach ($rentang as [$label, $dari, $sampai]) {
                [$d, $k] = $hitung($dari, $sampai);
                $hasil['label'][] = $label;
                $hasil['daftar'][] = $d;
                $hasil['kerja'][] = $k;
            }

            return $hasil;
        };

        $bulanan = [];
        for ($k = 11; $k >= 0; $k--) {
            $b = $sekarang->copy()->startOfMonth()->subMonths($k);
            $bulanan[] = [$b->translatedFormat($b->month === 1 ? 'M Y' : 'M'), $b, $b->copy()->endOfMonth()];
        }

        $kuartalan = [];
        for ($k = 7; $k >= 0; $k--) {
            $q = $sekarang->copy()->startOfQuarter()->subQuarters($k);
            $kuartalan[] = ['K' . $q->quarter . ' ' . $q->format('y'), $q, $q->copy()->endOfQuarter()];
        }

        $tahunan = [];
        for ($k = 2; $k >= 0; $k--) {
            $t = $sekarang->copy()->startOfYear()->subYears($k);
            $tahunan[] = [(string) $t->year, $t, $t->copy()->endOfYear()];
        }

        return ['bulan' => $susun($bulanan), 'kuartal' => $susun($kuartalan), 'tahun' => $susun($tahunan)];
    }
}
