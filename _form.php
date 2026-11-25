<?php
/**
 * modules/buku/_form.php — potongan formulir yang dipakai bersama oleh add.php dan edit.php.
 * Variabel yang dibutuhkan: $formAction (URL), $old (nilai isian), $errors, $labelTombol
 * (Bukan rute: tidak terdaftar di whitelist sehingga tidak bisa dibuka lewat URL.)
 */
if (!defined('APP_NAME')) {
    exit;
}
?>
<form method="post" action="<?= e($formAction) ?>" novalidate>
  <?= csrfField() ?>

  <div class="form-group<?= isset($errors['judul']) ? ' error' : '' ?>">
    <label for="judul">Judul Buku</label>
    <input type="text" id="judul" name="judul" maxlength="150" value="<?= e((string) $old['judul']) ?>">
    <?php if (isset($errors['judul'])): ?><span class="pesan-error"><?= e($errors['judul']) ?></span><?php endif; ?>
  </div>

  <div class="form-group<?= isset($errors['penulis']) ? ' error' : '' ?>">
    <label for="penulis">Penulis</label>
    <input type="text" id="penulis" name="penulis" maxlength="100" value="<?= e((string) $old['penulis']) ?>">
    <?php if (isset($errors['penulis'])): ?><span class="pesan-error"><?= e($errors['penulis']) ?></span><?php endif; ?>
  </div>

  <div class="baris-form">
    <div class="form-group<?= isset($errors['kategori']) ? ' error' : '' ?>">
      <label for="kategori">Kategori</label>
      <select id="kategori" name="kategori">
        <option value="">— pilih —</option>
        <?php foreach (KATEGORI as $kat): ?>
          <option value="<?= e($kat) ?>"<?= $old['kategori'] === $kat ? ' selected' : '' ?>><?= e($kat) ?></option>
        <?php endforeach; ?>
      </select>
      <?php if (isset($errors['kategori'])): ?><span class="pesan-error"><?= e($errors['kategori']) ?></span><?php endif; ?>
    </div>

    <div class="form-group<?= isset($errors['harga']) ? ' error' : '' ?>">
      <label for="harga">Harga (Rp)</label>
      <input type="number" id="harga" name="harga" min="0" step="1" value="<?= e((string) $old['harga']) ?>">
      <?php if (isset($errors['harga'])): ?><span class="pesan-error"><?= e($errors['harga']) ?></span><?php endif; ?>
    </div>

    <div class="form-group<?= isset($errors['stok']) ? ' error' : '' ?>">
      <label for="stok">Stok</label>
      <input type="number" id="stok" name="stok" min="0" step="1" value="<?= e((string) $old['stok']) ?>">
      <?php if (isset($errors['stok'])): ?><span class="pesan-error"><?= e($errors['stok']) ?></span><?php endif; ?>
    </div>
  </div>

  <div class="form-group<?= isset($errors['cover']) ? ' error' : '' ?>">
    <label for="cover">Sampul</label>
    <select id="cover" name="cover">
      <?php foreach (COVERS as $berkas => $label): ?>
        <option value="<?= e($berkas) ?>"<?= $old['cover'] === $berkas ? ' selected' : '' ?>><?= e($label) ?></option>
      <?php endforeach; ?>
    </select>
    <?php if (isset($errors['cover'])): ?><span class="pesan-error"><?= e($errors['cover']) ?></span><?php endif; ?>
  </div>

  <div class="form-group<?= isset($errors['deskripsi']) ? ' error' : '' ?>">
    <label for="deskripsi">Deskripsi (opsional)</label>
    <textarea id="deskripsi" name="deskripsi" rows="4" maxlength="500"><?= e((string) $old['deskripsi']) ?></textarea>
    <?php if (isset($errors['deskripsi'])): ?><span class="pesan-error"><?= e($errors['deskripsi']) ?></span><?php endif; ?>
  </div>

  <button type="submit" class="btn btn-emas"><?= e($labelTombol) ?></button>
  <a class="btn btn-garis" href="<?= e(url('buku/list')) ?>">Batal</a>
</form>
