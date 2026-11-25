<?php
/**
 * config/database.php — SATU-SATUNYA tempat koneksi database dikelola.
 * Menggunakan PDO. Hasil koneksi disimpan pada variabel $pdo.
 * Sesuaikan nilai di bawah dengan pengaturan MySQL/XAMPP Anda.
 */

$host = 'localhost';
$db   = 'lab9_tokobuku';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // Detail error hanya dicatat di log server, tidak ditampilkan ke pengguna
    error_log($e->getMessage());
    http_response_code(500);
    exit('Terjadi kesalahan pada koneksi database. Pastikan MySQL aktif dan database lab9_tokobuku sudah diimpor.');
}
