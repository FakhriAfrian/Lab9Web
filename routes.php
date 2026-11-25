<?php
/**
 * config/routes.php — daftar rute yang BOLEH diakses (whitelist).
 *
 * Kunci   : nilai parameter ?page=
 * file    : lokasi berkas konten (relatif terhadap folder project)
 * title   : judul halaman
 * nav     : kelompok menu yang ditandai aktif pada navigasi
 * auth    : true = hanya dapat diakses setelah login
 */
return [
    'dashboard'   => ['file' => 'views/dashboard.php',       'title' => 'Home',            'nav' => 'dashboard', 'auth' => false],
    'profil'      => ['file' => 'modules/page/profil.php',   'title' => 'Profil',          'nav' => 'profil',    'auth' => false],
    'kontak'      => ['file' => 'modules/page/kontak.php',   'title' => 'Kontak',          'nav' => 'kontak',    'auth' => false],
    'fungsi'      => ['file' => 'modules/demo/fungsi.php',   'title' => 'Latihan Function', 'nav' => 'fungsi',   'auth' => false],
    'buku/list'   => ['file' => 'modules/buku/list.php',     'title' => 'Data Buku',       'nav' => 'buku',      'auth' => false],
    'buku/add'    => ['file' => 'modules/buku/add.php',      'title' => 'Tambah Buku',     'nav' => 'buku',      'auth' => true],
    'buku/edit'   => ['file' => 'modules/buku/edit.php',     'title' => 'Ubah Buku',       'nav' => 'buku',      'auth' => true],
    'buku/delete' => ['file' => 'modules/buku/delete.php',   'title' => 'Hapus Buku',      'nav' => 'buku',      'auth' => true],
    'auth/login'  => ['file' => 'modules/auth/login.php',    'title' => 'Masuk',           'nav' => 'login',     'auth' => false],
    'auth/logout' => ['file' => 'modules/auth/logout.php',   'title' => 'Keluar',          'nav' => '',          'auth' => false],
];
