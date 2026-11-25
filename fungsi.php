<?php
/**
 * modules/demo/fungsi.php — peragaan seluruh function pada helpers/functions.php
 * Memakai: formatRupiah, hitungDiskon, validasiEmail, ringkasTeks, e,
 *          konversiCelciusKeFahrenheit, tentukanStatusNilai, hitungTotal
 */
if (!defined('APP_NAME')) {
    exit;
}

$teksPanjang = 'Modularisasi membagi aplikasi menjadi bagian-bagian kecil yang memiliki tanggung jawab jelas sehingga mudah dipelihara.';
$hargaContoh = 200000;

$hasil = [
    ['formatRupiah(150000)',                       formatRupiah(150000)],
    ['hitungDiskon(200000)  // default 10%',        formatRupiah(hitungDiskon($hargaContoh))],
    ['hitungDiskon(200000, 15)',                    formatRupiah(hitungDiskon($hargaContoh, 15))],
    ['validasiEmail("fakhri@mail.com")',            validasiEmail('fakhri@mail.com') ? 'true (valid)' : 'false'],
    ['validasiEmail("fakhri@")',                    validasiEmail('fakhri@') ? 'true (valid)' : 'false (tidak valid)'],
    ['ringkasTeks($teksPanjang, 50)',               ringkasTeks($teksPanjang, 50)],
    ['e(\'<script>alert("uji")</script>\')',        e('<script>alert("uji")</script>')],
    ['konversiCelciusKeFahrenheit(100)',            konversiCelciusKeFahrenheit(100) . ' °F'],
    ['tentukanStatusNilai(88)',                     tentukanStatusNilai(88)],
    ['tentukanStatusNilai(62)',                     tentukanStatusNilai(62)],
    ['hitungTotal(45000, 3)',                       formatRupiah(hitungTotal(45000, 3))],
];
?>
<h1 class="judul-halaman">Latihan Function</h1>
<p class="sub-judul">Hasil pemanggilan function dari <code>helpers/functions.php</code>.</p>

<section class="kartu">
  <div class="tabel-wrap">
    <table>
      <thead><tr><th>Pemanggilan</th><th>Hasil (nilai return)</th></tr></thead>
      <tbody>
        <?php foreach ($hasil as [$panggil, $nilai]): ?>
          <tr>
            <td><code><?= e($panggil) ?></code></td>
            <td><?= e((string) $nilai) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <p class="catatan">Baris <code>e(...)</code> menunjukkan teks berbahaya tampil sebagai teks biasa, tidak dijalankan browser.</p>
</section>
