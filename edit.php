<?php
/** modules/buku/edit.php — UPDATE (rute: buku/edit&id=..., wajib login) */
if (!defined('APP_NAME')) {
    exit;
}

$id = filter_var(inputGet('id'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false) {
    setFlash('error', 'ID buku tidak valid.');
    redirect('buku/list');
}

$stmt = $pdo->prepare('SELECT * FROM buku WHERE id = :id');
$stmt->execute([':id' => $id]);
$buku = $stmt->fetch();
if (!$buku) {
    setFlash('error', 'Data buku tidak ditemukan.');
    redirect('buku/list');
}

$errors = [];
$old    = $buku;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        setFlash('error', 'Sesi formulir kedaluwarsa. Silakan coba lagi.');
        redirect('buku/edit', ['id' => $id]);
    }
    [$data, $errors] = validasiBuku();
    $old = $data;

    if (!$errors) {
        $stmt = $pdo->prepare(
            'UPDATE buku SET judul = :judul, penulis = :penulis, kategori = :kategori, harga = :harga,
                             stok = :stok, cover = :cover, deskripsi = :deskripsi
             WHERE id = :id'
        );
        $stmt->execute([
            ':judul' => $data['judul'], ':penulis' => $data['penulis'], ':kategori' => $data['kategori'],
            ':harga' => $data['harga'], ':stok' => $data['stok'], ':cover' => $data['cover'],
            ':deskripsi' => $data['deskripsi'], ':id' => $id,
        ]);
        setFlash('sukses', 'Data buku "' . $data['judul'] . '" berhasil diperbarui.');
        redirect('buku/list');
    }
}

$formAction  = url('buku/edit', ['id' => $id]);
$labelTombol = 'Simpan Perubahan';
?>
<h1 class="judul-halaman">Ubah Buku</h1>
<p class="sub-judul">Perbarui data buku nomor <?= (int) $id ?>.</p>
<section class="kartu">
  <?php require __DIR__ . '/_form.php'; ?>
</section>
