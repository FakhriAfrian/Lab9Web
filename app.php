<?php
/**
 * config/app.php — konfigurasi umum aplikasi (konstanta, session, BASE_URL).
 * Dimuat satu kali oleh index.php dengan require_once.
 */

define('APP_NAME', 'Toko Buku Kampus');
define('APP_ROOT', dirname(__DIR__));

// false = URL berbentuk index.php?page=buku/list (default, selalu bekerja)
// true  = URL ringkas /buku/list (butuh mod_rewrite + file .htaccess, lihat README)
define('PRETTY_URLS', false);

// Folder aplikasi relatif terhadap domain, mis. "/Lab9Web" (kosong jika di root domain)
define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/'));

// Daftar nilai yang diizinkan (whitelist) untuk form buku
const KATEGORI = ['Buku Ajar', 'Modul', 'Buku Referensi', 'Lainnya'];

// Nama berkas sampul => label pilihan. Hanya berkas ini yang boleh dipilih.
const COVERS = [
    'cover-default.png'        => 'Sampul standar',
    'pengantar_komunikasi.jpg' => 'Pengantar Komunikasi',
    'manajemen_keuangan.jpg'   => 'Manajemen Keuangan',
    'kepemimpinan.jpg'         => 'Kepemimpinan',
    'mikrobiologi.jpg'         => 'Mikrobiologi',
    'paud_perkembangan.jpg'    => 'Perkembangan Anak Usia Dini',
];

date_default_timezone_set('Asia/Jakarta');

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
