<?php
/**
 * views/header.php — awal dokumen HTML, navigasi, dan pesan flash.
 * Variabel dari router: $pageTitle (judul), $activeNav (menu aktif).
 */
if (!defined('APP_NAME')) {
    exit;
}

$userNow  = userLogin();
$navItems = [
    'dashboard' => ['dashboard', 'Home'],
    'profil'    => ['profil', 'Profil'],
    'kontak'    => ['kontak', 'Kontak'],
    'fungsi'    => ['fungsi', 'Latihan Function'],
    'buku'      => ['buku/list', 'Data Buku'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?> — <?= e(APP_NAME) ?></title>
  <link rel="icon" type="image/png" href="<?= e(asset('img/favicon.png')) ?>">
  <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body>
  <a class="lompat" href="#isi">Lewati ke konten</a>
  <header class="topbar">
    <div class="topbar-isi">
      <a class="brand" href="<?= e(url('dashboard')) ?>">
        <img src="<?= e(asset('img/logo.png')) ?>" alt="" width="40" height="40">
        <span><?= e(APP_NAME) ?></span>
      </a>
      <nav aria-label="Navigasi utama">
        <?php foreach ($navItems as $kunci => [$rute, $label]): ?>
          <a href="<?= e(url($rute)) ?>"<?= $kunci === $activeNav ? ' class="aktif" aria-current="page"' : '' ?>><?= e($label) ?></a>
        <?php endforeach; ?>
      </nav>
      <div class="user-box">
        <?php if ($userNow): ?>
          <span class="nama-user"><?= e($userNow['nama']) ?> <small><?= e($userNow['role']) ?></small></span>
          <form method="post" action="<?= e(url('auth/logout')) ?>">
            <?= csrfField() ?>
            <button type="submit" class="btn btn-kecil btn-garis">Keluar</button>
          </form>
        <?php else: ?>
          <a class="btn btn-kecil btn-garis" href="<?= e(url('auth/login')) ?>">Masuk</a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <main class="container" id="isi">
    <?php foreach (getFlash() as $f): ?>
      <div class="alert alert-<?= e($f['tipe']) ?>" role="<?= $f['tipe'] === 'error' ? 'alert' : 'status' ?>">
        <?= e($f['pesan']) ?>
      </div>
    <?php endforeach; ?>
