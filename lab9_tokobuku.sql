-- Praktikum 9 PHP Modular — database aplikasi Toko Buku Kampus
-- Cara impor: phpMyAdmin > tab Import > pilih berkas ini > Go
-- PERHATIAN: mengimpor ulang akan MENGHAPUS dan membuat ulang tabel (data kembali ke awal).

CREATE DATABASE IF NOT EXISTS lab9_tokobuku CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lab9_tokobuku;

DROP TABLE IF EXISTS buku;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama       VARCHAR(100) NOT NULL,
  email      VARCHAR(100) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  role       ENUM('Admin','User') NOT NULL DEFAULT 'User',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE buku (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  judul      VARCHAR(150) NOT NULL,
  penulis    VARCHAR(100) NOT NULL,
  kategori   VARCHAR(30)  NOT NULL,
  harga      INT UNSIGNED NOT NULL DEFAULT 0,
  stok       INT UNSIGNED NOT NULL DEFAULT 0,
  cover      VARCHAR(60)  NOT NULL DEFAULT 'cover-default.png',
  deskripsi  VARCHAR(500) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password disimpan sebagai hash bcrypt (password_hash). Siti = siti123, Rina = rina123
INSERT INTO users (nama, email, password, role) VALUES
('Siti Marlina',   'siti@gmail.com', '$2y$10$tFliP6dzgGHNq91geDLUWOMb/CiABFe/w4XUh4XBG6YbZTzLqfDWG', 'Admin'),
('Rina Wulandari', 'rina@gmail.com', '$2y$10$cK.WCqe40p70s1UsRCNdE.WEUmSgPO.GcPQrZKoGNJAnGcUnKY6z6', 'User');

INSERT INTO buku (judul, penulis, kategori, harga, stok, cover, deskripsi) VALUES
('Pengantar Ilmu Komunikasi', 'Tim Penyusun UT', 'Buku Ajar', 180000, 548, 'pengantar_komunikasi.jpg',
 'Membahas konsep dasar komunikasi, unsur-unsur proses komunikasi, serta bentuk komunikasi antarpribadi, kelompok, dan massa.'),
('Manajemen Keuangan', 'Tim Penyusun UT', 'Buku Ajar', 220000, 392, 'manajemen_keuangan.jpg',
 'Pengantar pengelolaan keuangan perusahaan: analisis laporan keuangan, nilai waktu uang, dan keputusan investasi.'),
('Kepemimpinan', 'Tim Penyusun UT', 'Buku Ajar', 150000, 278, 'kepemimpinan.jpg',
 'Teori dan praktik kepemimpinan dalam organisasi, meliputi gaya kepemimpinan, motivasi, dan pengambilan keputusan.'),
('Mikrobiologi Dasar', 'Tim Penyusun UT', 'Buku Ajar', 200000, 165, 'mikrobiologi.jpg',
 'Dasar-dasar mikrobiologi: struktur dan fisiologi mikroorganisme serta peranannya bagi kehidupan.'),
('Perkembangan Anak Usia Dini', 'Tim Penyusun UT', 'Buku Ajar', 250000, 204, 'paud_perkembangan.jpg',
 'Tahap perkembangan fisik, kognitif, bahasa, dan sosial-emosional anak usia dini beserta implikasinya bagi pendidikan.'),
('Pemrograman Web dengan PHP', 'Agung Nugroho', 'Modul', 95000, 15, 'cover-default.png',
 'Modul praktikum PHP dasar hingga modular: template, function, routing, dan koneksi database MySQL.');
