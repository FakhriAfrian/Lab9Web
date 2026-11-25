<?php
/**
 * helpers/functions.php — function umum yang dipakai banyak modul.
 * Dimuat dengan require_once agar tidak terjadi "Cannot redeclare function".
 */

/* =====================================================
 * 1. LIBRARY FUNCTION (Latihan 2 + Latihan Function)
 * ===================================================== */

/** Escaping teks sebelum dicetak ke HTML (mencegah XSS). */
function e(?string $nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

/** Format angka menjadi mata uang Rupiah, contoh: 150000 -> "Rp 150.000". */
function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/** Menghitung NILAI diskon (bukan harga akhir). Persen default 10%. */
function hitungDiskon(float $harga, float $persen = 10): float
{
    return $harga * ($persen / 100);
}

/** Mengembalikan true jika format email valid. */
function validasiEmail(string $email): bool
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}

/** Meringkas teks panjang menjadi maksimal $panjang karakter, diakhiri "…". */
function ringkasTeks(string $teks, int $panjang = 100): string
{
    $teks = trim((string) preg_replace('/\s+/', ' ', $teks));
    if (mb_strlen($teks, 'UTF-8') <= $panjang) {
        return $teks;
    }
    return rtrim(mb_substr($teks, 0, $panjang, 'UTF-8')) . '…';
}

/** Latihan function no. 1 */
function konversiCelciusKeFahrenheit(float $c): float
{
    return ($c * 9 / 5) + 32;
}

/** Latihan function no. 2: predikat nilai (rentang ditetapkan sendiri). */
function tentukanStatusNilai(float $nilai): string
{
    if ($nilai >= 85) {
        return 'A (Sangat Baik)';
    } elseif ($nilai >= 70) {
        return 'B (Baik)';
    } elseif ($nilai >= 55) {
        return 'C (Cukup)';
    } elseif ($nilai >= 40) {
        return 'D (Kurang)';
    }
    return 'E (Gagal)';
}

/** Latihan function no. 3: total belanja. */
function hitungTotal(float $harga, int $jumlah): float
{
    return $harga * $jumlah;
}

/* =====================================================
 * 2. ROUTING: pembuat URL dan redirect
 * ===================================================== */

/** URL ke Aset statis, contoh: asset('css/style.css'). */
function asset(string $path): string
{
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

/**
 * Membuat URL ke sebuah rute, contoh: url('buku/edit', ['id' => 3]).
 * Hasil (mode default): index.php?page=buku/edit&id=3
 * Hasil (PRETTY_URLS)  : /buku/edit?id=3
 */
function url(string $page = 'dashboard', array $params = []): string
{
    $query = $params ? http_build_query($params) : '';
    if (PRETTY_URLS) {
        return BASE_URL . '/' . $page . ($query !== '' ? '?' . $query : '');
    }
    return BASE_URL . '/index.php?page=' . $page . ($query !== '' ? '&' . $query : '');
}

/** Pindah ke rute lain lalu hentikan eksekusi. */
function redirect(string $page, array $params = []): void
{
    header('Location: ' . url($page, $params));
    exit;
}

/* =====================================================
 * 3. INPUT, FLASH MESSAGE, CSRF, LOGIN
 * ===================================================== */

/** Mengambil input POST berupa string (array / null diabaikan). */
function inputPost(string $kunci): string
{
    $nilai = $_POST[$kunci] ?? '';
    return is_string($nilai) ? trim($nilai) : '';
}

/** Mengambil input GET berupa string (array / null diabaikan). */
function inputGet(string $kunci): string
{
    $nilai = $_GET[$kunci] ?? '';
    return is_string($nilai) ? trim($nilai) : '';
}

/** Menyimpan pesan sukses/gagal untuk ditampilkan pada halaman berikutnya. */
function setFlash(string $tipe, string $pesan): void
{
    $_SESSION['flash'][] = ['tipe' => $tipe, 'pesan' => $pesan];
}

/** Mengambil lalu menghapus semua pesan flash. */
function getFlash(): array
{
    $pesan = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $pesan;
}

/** Token CSRF per sesi. */
function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

/** Input hidden berisi token CSRF untuk ditaruh di dalam <form>. */
function csrfField(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrfToken()) . '">';
}

/** Memeriksa token CSRF yang dikirim melalui POST. */
function csrfValid(): bool
{
    $kirim = $_POST['csrf'] ?? '';
    return is_string($kirim) && $kirim !== '' && hash_equals(csrfToken(), $kirim);
}

/** Data pengguna yang sedang login (atau null). */
function userLogin(): ?array
{
    return $_SESSION['user'] ?? null;
}

function isLoggedIn(): bool
{
    return userLogin() !== null;
}

/* =====================================================
 * 4. TAMPILAN KECIL
 * ===================================================== */

/** Label stok berwarna. */
function badgeStok(int $stok): string
{
    if ($stok <= 0) {
        return '<span class="badge habis">Habis</span>';
    } elseif ($stok < 20) {
        return '<span class="badge proses">Menipis · ' . $stok . '</span>';
    }
    return '<span class="badge sukses">Tersedia · ' . $stok . '</span>';
}

/** Tag <img> sampul buku. $cover = nama berkas di assets/img/covers/. */
function coverBuku(string $cover, string $judul, string $kelas = 'cover'): string
{
    if (!array_key_exists($cover, COVERS)) {
        $cover = 'cover-default.png';
    }
    return '<img class="' . e($kelas) . '" src="' . e(asset('img/covers/' . $cover)) . '" alt="Sampul buku '
        . e($judul) . '" loading="lazy">';
}
