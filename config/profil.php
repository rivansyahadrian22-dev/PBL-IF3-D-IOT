<?php

/*
| CONTOH data profil pengguna — dipakai halaman Profil Saya dan Edit Profil.
| Ganti dengan data auth()->user() & relasinya setelah backend siap.
*/

return [

    'profil' => [
        'nama' => 'Andi Saputra', 'inisial' => 'AS', 'peran' => 'Junior Graphic Designer & UI/UX Aksesibilitas',
        'lokasi' => 'Jakarta Selatan', 'id' => 'TNK-2026-0941', 'terdaftar' => '14 Maret 2026', 'kelengkapan' => 78,
    ],

    // [emoji, label, nilai] — ringkasan di halaman Profil
    'komunikasi' => [
        ['🤟', 'Mode komunikasi utama', 'BISINDO & teks tertulis'],
        ['🔡', 'Saat rapat', 'Subtitle langsung / notulen tertulis'],
        ['💡', 'Notifikasi', 'Visual (lampu/layar) & getar'],
        ['🧑‍🏫', 'Saat wawancara', 'Didampingi Juru Bahasa Isyarat'],
    ],

    // [emoji, judul, lembaga, periode, keterangan]
    'pendidikan' => [
        ['🏅', 'Sertifikasi Junior Graphic Designer', 'BNSP · Lisensi resmi', '2025 – 2027', 'Lulus uji kompetensi desain grafis dengan pendampingan juru bahasa isyarat.'],
        ['💻', 'Bootcamp Frontend Inklusif', 'Akademi Inklusi Digital', '2024', 'Proyek akhir: website ramah Tuli dengan video BISINDO & subtitle.'],
        ['🎓', 'SMK Negeri 2 Jakarta, Jurusan Multimedia', 'Pendidikan menengah kejuruan', '2020 – 2023', 'Fokus desain grafis, fotografi, dan editing video.'],
    ],

    'keahlian' => [
        'Figma' => 'Mahir', 'Adobe Illustrator' => 'Mahir', 'UI Design' => 'Mahir', 'HTML & CSS' => 'Menengah',
        'Canva' => 'Mahir', 'Video Editing' => 'Menengah', 'Microsoft Office' => 'Menengah', 'Desain Aksesibel (WCAG)' => 'Menengah',
    ],

    // [bahasa, tingkat, persen]
    'bahasa' => [['BISINDO', 'Bahasa ibu', 100], ['Bahasa Indonesia (tulis)', 'Mahir', 90], ['Bahasa Inggris (tulis)', 'Menengah', 60]],

    // [emoji, nama, keterangan, sudah ada?]
    'berkas' => [
        ['📄', 'CV_Andi_Saputra.pdf', 'Diperbarui 2 hari lalu', true],
        ['🎨', 'Portofolio_Desain.pdf', '12 karya · 8 MB', true],
        ['🪪', 'Kartu Penyandang Disabilitas', 'Terverifikasi Dinsos', true],
        ['🏅', 'Sertifikat tambahan', 'Belum diunggah', false],
    ],

    // [kunci, judul, keterangan, aktif?]
    'privasi' => [
        ['profil_publik', 'Tampilkan profil ke perusahaan', 'Perusahaan mitra bisa melihat profil & CV-mu', true],
        ['notif_getar', 'Notifikasi teks & getar', 'Kirim pemberitahuan lewat WhatsApp teks', true],
        ['flash_visual', 'Kedip layar saat notifikasi', 'Tanda visual tambahan pengganti suara', false],
        ['status_disabilitas', 'Tampilkan status disabilitas', 'Membantu perusahaan menyiapkan akomodasi', true],
    ],

    // Nilai awal formulir Edit Profil
    'form' => [
        'email' => 'andi.saputra@email.com',
        'whatsapp' => '081234567890',
        'tanggal_lahir' => '2002-05-14',
        'jenis_kelamin' => 'Laki-laki',
        'tentang' => 'Desainer grafis lulusan SMK Multimedia yang suka membuat tampilan aplikasi yang mudah dipahami secara visual. Saya Tuli dan nyaman bekerja lewat tulisan serta BISINDO.',
        'kondisi' => 'Tuli (Deaf)',
        'komunikasi' => ['BISINDO', 'Tulisan / Chat'],
        'rapat' => 'Subtitle langsung / notulen tertulis',
        'notifikasi' => ['Visual (lampu/layar)', 'Getar', 'WhatsApp teks'],
        'jbi' => 'Ya',
        'akomodasi' => ['Instruksi kerja tertulis', 'Subtitle saat rapat'],
        'catatan' => 'Saya nyaman berkomunikasi lewat BISINDO dan tulisan. Mohon instruksi kerja dikirim tertulis, dan rapat online menggunakan subtitle.',
        'siap_bekerja' => true,
    ],

];
