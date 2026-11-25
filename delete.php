<?php
/**
 * modules/buku/delete.php — DELETE (rute: buku/delete, wajib login)
 * Penghapusan HANYA diproses lewat POST + token CSRF, bukan dengan membuka URL (GET).
 */
if (!defined('APP_NAME')) {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setFlash('error', 'Penghapusan hanya dapat dilakukan melalui tombol Hapus pada daftar buku.');
    redirect('buku/list');
}
if (!csrfValid()) {
    setFlash('error', 'Sesi formulir kedaluwarsa. Silakan coba lagi.');
    redirect('buku/list');
}

$id = filter_var(inputPost('id'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false) {
    setFlash('error', 'ID buku tidak valid.');
    redirect('buku/list');
}

$stmt = $pdo->prepare('DELETE FROM buku WHERE id = :id');
$stmt->execute([':id' => $id]);

if ($stmt->rowCount() > 0) {
    setFlash('sukses', 'Data buku berhasil dihapus.');
} else {
    setFlash('error', 'Data buku tidak ditemukan.');
}
redirect('buku/list');
