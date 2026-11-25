<?php
/**
 * index.php — TITIK MASUK APLIKASI (router)
 * Semua halaman diakses lewat sini, contoh: index.php?page=buku/list
 *
 * Alur:
 *  1. muat konfigurasi, koneksi database, dan helper (require_once)
 *  2. baca parameter ?page= lalu cocokkan dengan whitelist rute
 *  3. rute tidak dikenal -> status 404; rute terlindungi -> wajib login
 *  4. jalankan modul (di-buffer agar redirect/POST tetap bisa dilakukan),
 *     lalu tampilkan: header -> konten -> footer
 */
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/helpers/buku.php';

$routes = require __DIR__ . '/config/routes.php';

$page = $_GET['page'] ?? 'dashboard';

// Input URL TIDAK PERNAH dipakai langsung sebagai path file:
// hanya dipakai sebagai kunci untuk mencari path pada daftar $routes.
if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $page  = '404';
    $route = [
        'file'  => 'views/404.php',
        'title' => '404 - Halaman tidak ditemukan',
        'nav'   => '',
        'auth'  => false,
    ];
} else {
    $route = $routes[$page];
}

// Pembatasan akses (tantangan mandiri)
if ($route['auth'] && !isLoggedIn()) {
    setFlash('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman tersebut.');
    redirect('auth/login', ['next' => $page]);
}

$pageTitle = $route['title'];
$activeNav = $route['nav'];

// Modul dijalankan lebih dulu dan keluarannya ditampung di buffer
ob_start();
require __DIR__ . '/' . $route['file'];
$content = ob_get_clean();

require_once __DIR__ . '/views/header.php';
echo $content;
require_once __DIR__ . '/views/footer.php';
