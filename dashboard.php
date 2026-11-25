<?php
/**
 * views/dashboard.php — halaman Home (rute: dashboard)
 * Memakai: formatRupiah(), ringkasTeks()
 */
if (!defined('APP_NAME')) {
    exit;
}

$ringkas = $pdo->query('SELECT COUNT(*) AS judul, COALESCE(SUM(stok), 0) AS total_stok, COALESCE(SUM(harga * stok), 0) AS nilai FROM buku')->fetch();
$terbaru = $pdo->query('SELECT id, judul, penulis, cover, deskripsi FROM buku ORDER BY id DESC LIMIT 3')->fetchAll();
?>
<section class="hero" aria-labelledby="sapa">
  <div>
    <p class="hero-hari"><?= e(date('d-m-Y')) ?></p>
    <h1 id="sapa">Selamat datang di <?= e(APP_NAME) ?></h1>
    <p>Aplikasi latihan PHP modular: template bersama, function helper, router berbasis whitelist, dan CRUD data buku dengan MySQL.</p>
  </div>
  <a href="<?= e(url('buku/list')) ?>" class="btn btn-emas">Lihat Data Buku</a>
</section>

<section class="stat-grid" aria-label="Ringkasan data">
  <div class="stat"><b><?= (int) $ringkas['judul'] ?></b><small>Judul buku</small></div>
  <div class="stat"><b><?= number_format((int) $ringkas['total_stok'], 0, ',', '.') ?></b><small>Total stok</small></div>
  <div class="stat"><b><?= e(formatRupiah((float) $ringkas['nilai'])) ?></b><small>Nilai persediaan</small></div>
</section>

<h2 class="judul-bagian">Buku Terbaru</h2>
<?php if (!$terbaru): ?>
  <p class="kosong">Belum ada data buku.</p>
<?php else: ?>
  <div class="grid-buku">
    <?php foreach ($terbaru as $b): ?>
      <article class="kartu" style="display:flex;gap:14px;margin-bottom:0">
        <?= coverBuku($b['cover'], $b['judul']) ?>
        <div>
          <strong><?= e($b['judul']) ?></strong><br>
          <small><?= e($b['penulis']) ?></small>
          <p class="catatan"><?= e(ringkasTeks((string) $b['deskripsi'], 80)) ?></p>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
