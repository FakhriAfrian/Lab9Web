<?php
/** modules/buku/add.php — CREATE (rute: buku/add, wajib login) */
if (!defined('APP_NAME')) {
    exit;
}

$errors = [];
$old    = ['judul' => '', 'penulis' => '', 'kategori' => '', 'harga' => '', 'stok' => '', 'cover' => 'cover-default.png', 'deskripsi' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        setFlash('error', 'Sesi formulir kedaluwarsa. Silakan coba lagi.');
        redirect('buku/add');
    }
    [$data, $errors] = validasiBuku();
    $old = $data;

    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO buku (judul, penulis, kategori, harga, stok, cover, deskripsi)
             VALUES (:judul, :penulis, :kategori, :harga, :stok, :cover, :deskripsi)'
        );
        $stmt->execute([
            ':judul' => $data['judul'], ':penulis' => $data['penulis'], ':kategori' => $data['kategori'],
            ':harga' => $data['harga'], ':stok' => $data['stok'], ':cover' => $data['cover'],
            ':deskripsi' => $data['deskripsi'],
        ]);
        setFlash('sukses', 'Buku "' . $data['judul'] . '" berhasil ditambahkan.');
        redirect('buku/list');
    }
}

$formAction  = url('buku/add');
$labelTombol = 'Simpan';
?>
<h1 class="judul-halaman">Tambah Buku</h1>
<p class="sub-judul">Isi data buku baru lalu tekan Simpan.</p>
<section class="kartu">
  <?php require __DIR__ . '/_form.php'; ?>
</section>
