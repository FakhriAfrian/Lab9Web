# Lab9Web — Praktikum 9: PHP Modular (Toko Buku Kampus)

Aplikasi latihan **Pemrograman Web (Universitas Pelita Bangsa)** — Pertemuan 11.
Menerapkan modularisasi PHP: template bersama, library function, router berbasis *whitelist*,
dan CRUD data buku dengan MySQL. Tema tampilan memakai aset dari proyek `toko-buku-php`.

Pembuat: Fakhri Afrian · NIM 312410074 · Kelas I252A

## 1. Tujuan project
1. Memisahkan header, footer, dan konten halaman ke dalam file template yang dipakai bersama.
2. Menyusun function umum pada `helpers/functions.php` dan menggunakannya ulang di banyak halaman.
3. Menyusun struktur direktori modular (`config/`, `views/`, `helpers/`, `modules/`, `assets/`).
4. Membuat router satu pintu (`index.php?page=...`) dengan whitelist dan halaman 404.
5. Merefaktor aplikasi CRUD database agar berjalan di atas struktur modular tersebut.

## 2. Kebutuhan perangkat
| Kebutuhan | Keterangan |
|---|---|
| XAMPP / Laragon | Apache + MySQL/MariaDB (PHP 7.4 atau lebih baru; PHP 8.x disarankan) |
| Ekstensi PHP | `pdo_mysql` dan `mbstring` (aktif secara bawaan di XAMPP) |
| Browser | Chrome / Firefox / Edge |
| Editor | Visual Studio Code |

## 3. Cara menjalankan aplikasi
1. Buka **XAMPP Control Panel**, tekan **Start** pada **Apache** dan **MySQL** sampai berlatar hijau.
2. Salin folder `Lab9Web` ke `C:\xampp\htdocs\` sehingga menjadi `C:\xampp\htdocs\Lab9Web\`.
3. Buka `http://localhost/phpmyadmin/` → tab **Import** → pilih `database/lab9_tokobuku.sql` → **Go**.
   Database `lab9_tokobuku` beserta tabel `users` dan `buku` akan terbentuk.
4. Jika MySQL Anda memakai user/password selain `root` tanpa password, ubah `config/database.php`.
5. Buka `http://localhost/Lab9Web/` di browser.
6. Masuk dengan akun demo untuk mencoba tambah/ubah/hapus data.

| Peran | Email | Password |
|---|---|---|
| Admin | siti@gmail.com | siti123 |
| User | rina@gmail.com | rina123 |

Latihan dasar (Praktik C.3 dan D) ada di folder `latihan/`, dibuka lewat
`http://localhost/Lab9Web/latihan/uji-include.php` dan `.../latihan/home.php`.

## 4. Struktur direktori
```
Lab9Web/
├── index.php                  router + titik masuk aplikasi
├── .htaccess                  aturan rewrite URL ringkas (opsional)
├── README.md
├── config/
│   ├── app.php                konstanta, session, BASE_URL, whitelist form
│   ├── database.php           satu-satunya koneksi database (PDO)
│   └── routes.php             daftar rute yang diizinkan
├── database/
│   └── lab9_tokobuku.sql      struktur tabel + data awal
├── helpers/
│   ├── functions.php          function umum (formatRupiah, hitungDiskon, ...)
│   └── buku.php               validasi form buku
├── views/
│   ├── header.php  footer.php  dashboard.php  404.php
├── modules/
│   ├── page/    profil.php  kontak.php
│   ├── demo/    fungsi.php
│   ├── buku/    list.php  add.php  edit.php  delete.php  _form.php
│   └── auth/    login.php  logout.php
├── assets/      css/  js/  img/ (logo, favicon, covers/)
└── latihan/     pesan.php, uji-include.php, uji-require.php, home/about/kontak + header/footer
```

## 5. Daftar rute
| Rute (`?page=`) | Berkas | Login | Keterangan |
|---|---|---|---|
| `dashboard` (default) | views/dashboard.php | tidak | Home, ringkasan data |
| `profil` | modules/page/profil.php | tidak | Profil pembuat |
| `kontak` | modules/page/kontak.php | tidak | Formulir kontak (validasi email) |
| `fungsi` | modules/demo/fungsi.php | tidak | Peragaan semua function |
| `buku/list` | modules/buku/list.php | tidak | Read + pencarian |
| `buku/add` | modules/buku/add.php | **ya** | Create |
| `buku/edit&id=N` | modules/buku/edit.php | **ya** | Update |
| `buku/delete` | modules/buku/delete.php | **ya** | Delete (hanya POST + CSRF) |
| `auth/login` | modules/auth/login.php | tidak | Masuk |
| `auth/logout` | modules/auth/logout.php | tidak | Keluar (POST + CSRF) |
| selain di atas | views/404.php | — | Status HTTP 404 |

## 6. Langkah praktikum
1. Praktik C.3 — uji `include` vs `require` di folder `latihan/`.
2. Praktik D — template header/footer pada `latihan/home.php`, `about.php`, `kontak.php`.
3. Latihan function — function pada `helpers/functions.php`, ditampilkan di rute `fungsi`.
4. Struktur direktori modular (bagian F modul).
5. Router dengan whitelist + halaman 404 (`index.php`, `config/routes.php`).
6. Integrasi CRUD buku dengan MySQL melalui router (`modules/buku/`).
7. Tantangan mandiri: menu aktif, pesan flash, pembatasan akses login, `.htaccess`.
8. Pengujian setiap fitur dan penyusunan laporan.

## 7. Tantangan mandiri
- **Menu aktif**: kunci `nav` pada `config/routes.php` dibandingkan dengan `$activeNav` di `views/header.php`.
- **Pesan sukses/gagal**: `setFlash()` dan `getFlash()` pada `helpers/functions.php`.
- **Pembatasan akses**: rute dengan `'auth' => true` dialihkan ke `auth/login` oleh router.
- **URL rewrite**: ubah `PRETTY_URLS` menjadi `true` di `config/app.php`. Pastikan `mod_rewrite` aktif dan
  `AllowOverride All` pada konfigurasi Apache (`httpd.conf`, blok `<Directory "C:/xampp/htdocs">`), lalu restart
  Apache. URL menjadi `http://localhost/Lab9Web/buku/list`.

## 8. Catatan keamanan yang diterapkan
- Parameter `page` hanya dipakai sebagai kunci whitelist, tidak pernah digabung menjadi path file.
- Semua query memakai *prepared statement* (PDO); output memakai `e()` / `htmlspecialchars`.
- Tambah/ubah/hapus/logout memakai token CSRF; hapus hanya lewat POST.
- Password disimpan sebagai hash bcrypt; `session_regenerate_id()` dipanggil saat login.
- Folder `config/`, `helpers/`, `views/`, `modules/`, `database/` diblokir dari akses langsung via `.htaccess`.

## 9. Kendala umum dan solusi
| Gejala | Penyebab | Solusi |
|---|---|---|
| "Terjadi kesalahan pada koneksi database" | MySQL belum aktif / SQL belum diimpor | Start MySQL, impor `database/lab9_tokobuku.sql` |
| Halaman 404 untuk rute yang benar | Ejaan `page` tidak ada di `config/routes.php` | Periksa ejaan rute |
| CSS tidak tampil | Folder diletakkan di tempat berbeda | Pastikan dibuka lewat `http://localhost/Lab9Web/` |
| URL rewrite tidak bekerja | `mod_rewrite` / `AllowOverride` belum aktif | Aktifkan di Apache, restart |
