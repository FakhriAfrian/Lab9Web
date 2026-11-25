<?php
/** modules/page/profil.php — halaman Profil (Latihan 1) */
if (!defined('APP_NAME')) {
    exit;
}
$identitas = [
    'Nama'          => 'Fakhri Afrian',
    'NIM'           => '312410074',
    'Kelas'         => 'I252A',
    'Program Studi' => 'Teknik Informatika',
    'Universitas'   => 'Universitas Pelita Bangsa',
    'Mata Kuliah'   => 'Pemrograman Web (Semester 3)',
    'Dosen'         => 'Agung Nugroho, S.Kom., M.Kom.',
    'Tugas'         => 'Praktikum 9 — PHP Modular (Pertemuan 11)',
];
?>
<h1 class="judul-halaman">Profil</h1>
<p class="sub-judul">Identitas pembuat aplikasi praktikum.</p>

<section class="kartu">
  <div class="tabel-wrap">
    <table>
      <tbody>
        <?php foreach ($identitas as $label => $nilai): ?>
          <tr><th style="width:200px"><?= e($label) ?></th><td><?= e($nilai) ?></td></tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
