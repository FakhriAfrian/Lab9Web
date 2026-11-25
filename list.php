<?php
/**
 * modules/buku/list.php — READ: daftar buku + pencarian (rute: buku/list)
 * Memakai: formatRupiah(), hitungDiskon(), ringkasTeks(), badgeStok(), coverBuku()
 */
if (!defined('APP_NAME')) {
    exit;
}

$q = inputGet('q');
if ($q !== '') {
    $stmt = $pdo->prepare('SELECT * FROM buku WHERE judul LIKE :q1 OR penulis LIKE :q2 ORDER BY id ASC');
    $stmt->execute([':q1' => '%' . $q . '%', ':q2' => '%' . $q . '%']);
} else {
    $stmt = $pdo->query('SELECT * FROM buku ORDER BY id ASC');
}
$daftar = $stmt->fetchAll();
$login  = isLoggedIn();
?>
<h1 class="judul-halaman">Data Buku</h1>
<p class="sub-judul">Kelola data buku (Create, Read, Update, Delete) melalui router.</p>

<form class="kartu form-cari" method="get" action="<?= e(url('buku/list')) ?>" style="grid-template-columns:1fr auto auto">
  <?php if (PRETTY_URLS === false): ?>
    <input type="hidden" name="page" value="buku/list">
  <?php endif; ?>
  <div class="form-group">
    <label for="q">Cari judul / penulis</label>
    <input type="text" id="q" name="q" value="<?= e($q) ?>" placeholder="mis. komunikasi">
  </div>
  <button type="submit" class="btn">Cari</button>
  <a class="btn btn-garis" href="<?= e(url('buku/list')) ?>">Reset</a>
</form>

<?php if ($login): ?>
  <p style="margin-bottom:14px"><a class="btn btn-emas" href="<?= e(url('buku/add')) ?>">+ Tambah Buku</a></p>
<?php else: ?>
  <div class="alert alert-info">Anda belum masuk. <a href="<?= e(url('auth/login', ['next' => 'buku/list'])) ?>">Masuk</a> untuk menambah, mengubah, atau menghapus data.</div>
<?php endif; ?>

<section class="kartu">
  <div class="tabel-wrap">
    <table>
      <thead>
        <tr>
          <th>Sampul</th><th>Judul</th><th>Penulis</th><th>Kategori</th>
          <th class="kanan">Harga</th><th class="kanan">Harga Promo (−10%)</th><th>Stok</th>
          <?php if ($login): ?><th>Aksi</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (!$daftar): ?>
          <tr><td colspan="<?= $login ? 8 : 7 ?>" class="kosong">Belum ada data buku.</td></tr>
        <?php endif; ?>
        <?php foreach ($daftar as $b): ?>
          <?php $harga = (float) $b['harga']; ?>
          <tr>
            <td><?= coverBuku($b['cover'], $b['judul']) ?></td>
            <td>
              <strong><?= e($b['judul']) ?></strong><br>
              <small><?= e(ringkasTeks((string) $b['deskripsi'], 70)) ?></small>
            </td>
            <td><?= e($b['penulis']) ?></td>
            <td><?= e($b['kategori']) ?></td>
            <td class="kanan"><?= e(formatRupiah($harga)) ?></td>
            <td class="kanan"><?= e(formatRupiah($harga - hitungDiskon($harga))) ?></td>
            <td><?= badgeStok((int) $b['stok']) ?></td>
            <?php if ($login): ?>
              <td>
                <a class="btn btn-kecil btn-garis" href="<?= e(url('buku/edit', ['id' => $b['id']])) ?>">Ubah</a>
                <form method="post" action="<?= e(url('buku/delete')) ?>" style="display:inline"
                      data-konfirm="Hapus buku &quot;<?= e($b['judul']) ?>&quot;?">
                  <?= csrfField() ?>
                  <input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                  <button type="submit" class="btn btn-kecil btn-teks-bahaya">Hapus</button>
                </form>
              </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <p class="catatan"><?= count($daftar) ?> data ditampilkan.</p>
</section>
