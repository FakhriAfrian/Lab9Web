<?php
/**
 * modules/page/kontak.php — halaman Kontak (Latihan 1)
 * Memakai: validasiEmail(), e(). Pesan hanya divalidasi (simulasi), tidak disimpan.
 */
if (!defined('APP_NAME')) {
    exit;
}

$errors = [];
$old    = ['nama' => '', 'email' => '', 'pesan' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        setFlash('error', 'Sesi formulir kedaluwarsa. Silakan coba lagi.');
        redirect('kontak');
    }
    foreach ($old as $k => $_) {
        $old[$k] = inputPost($k);
    }
    if (mb_strlen($old['nama'], 'UTF-8') < 3) {
        $errors['nama'] = 'Nama minimal 3 karakter.';
    }
    if (!validasiEmail($old['email'])) {
        $errors['email'] = 'Format email tidak valid.';
    }
    $panjangPesan = mb_strlen($old['pesan'], 'UTF-8');
    if ($panjangPesan < 10 || $panjangPesan > 500) {
        $errors['pesan'] = 'Pesan harus 10–500 karakter.';
    }
    if (!$errors) {
        setFlash('sukses', 'Terima kasih, ' . $old['nama'] . '. Pesan Anda sudah diterima (simulasi, tidak disimpan).');
        redirect('kontak');
    }
}
?>
<h1 class="judul-halaman">Kontak</h1>
<p class="sub-judul">Kirim pesan melalui formulir berikut.</p>

<section class="kartu">
  <form method="post" action="<?= e(url('kontak')) ?>" novalidate>
    <?= csrfField() ?>
    <div class="form-group<?= isset($errors['nama']) ? ' error' : '' ?>">
      <label for="nama">Nama</label>
      <input type="text" id="nama" name="nama" value="<?= e($old['nama']) ?>">
      <?php if (isset($errors['nama'])): ?><span class="pesan-error"><?= e($errors['nama']) ?></span><?php endif; ?>
    </div>
    <div class="form-group<?= isset($errors['email']) ? ' error' : '' ?>">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($old['email']) ?>">
      <?php if (isset($errors['email'])): ?><span class="pesan-error"><?= e($errors['email']) ?></span><?php endif; ?>
    </div>
    <div class="form-group<?= isset($errors['pesan']) ? ' error' : '' ?>">
      <label for="pesan">Pesan</label>
      <textarea id="pesan" name="pesan" rows="5"><?= e($old['pesan']) ?></textarea>
      <?php if (isset($errors['pesan'])): ?><span class="pesan-error"><?= e($errors['pesan']) ?></span><?php endif; ?>
    </div>
    <button type="submit" class="btn btn-emas">Kirim Pesan</button>
  </form>
</section>
