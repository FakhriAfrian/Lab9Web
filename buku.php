<?php
/**
 * helpers/buku.php — validasi input form buku (dipakai modul add dan edit).
 */

/**
 * Membaca & memvalidasi input POST form buku.
 * @return array [$data, $errors]  $data = nilai bersih, $errors = pesan per kolom
 */
function validasiBuku(): array
{
    $data = [
        'judul'     => inputPost('judul'),
        'penulis'   => inputPost('penulis'),
        'kategori'  => inputPost('kategori'),
        'harga'     => inputPost('harga'),
        'stok'      => inputPost('stok'),
        'cover'     => inputPost('cover'),
        'deskripsi' => inputPost('deskripsi'),
    ];
    $errors = [];

    $len = mb_strlen($data['judul'], 'UTF-8');
    if ($len < 3 || $len > 150) {
        $errors['judul'] = 'Judul harus 3–150 karakter.';
    }

    $len = mb_strlen($data['penulis'], 'UTF-8');
    if ($len < 3 || $len > 100) {
        $errors['penulis'] = 'Nama penulis harus 3–100 karakter.';
    }

    if (!in_array($data['kategori'], KATEGORI, true)) {
        $errors['kategori'] = 'Pilih kategori yang tersedia.';
    }

    $harga = filter_var($data['harga'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 99999999]]);
    if ($harga === false) {
        $errors['harga'] = 'Harga harus berupa angka bulat 0–99.999.999.';
    }

    $stok = filter_var($data['stok'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100000]]);
    if ($stok === false) {
        $errors['stok'] = 'Stok harus berupa angka bulat 0–100.000.';
    }

    if (!array_key_exists($data['cover'], COVERS)) {
        $errors['cover'] = 'Pilih sampul yang tersedia.';
    }

    if (mb_strlen($data['deskripsi'], 'UTF-8') > 500) {
        $errors['deskripsi'] = 'Deskripsi maksimal 500 karakter.';
    }

    if (!$errors) {
        $data['harga'] = $harga;
        $data['stok']  = $stok;
    }
    return [$data, $errors];
}
