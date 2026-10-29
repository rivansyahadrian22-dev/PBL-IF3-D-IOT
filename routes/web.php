<?php

/*
| Rute situs TUNAKER dipisah per peran supaya mudah dicari:
|   routes/pelamar.php : halaman publik dan area pelamar (pencari kerja)
|   routes/admin.php   : area admin (prefix /admin)
*/

require __DIR__.'/pelamar.php';
require __DIR__.'/admin.php';
