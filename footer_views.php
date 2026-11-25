<?php
/** views/footer.php — penutup halaman (menutup <main>, <body>, <html>). */
if (!defined('APP_NAME')) {
    exit;
}
?>
  </main>

  <footer class="footer">
    &copy; <?= date('Y') ?> <?= e(APP_NAME) ?> · Praktikum 9 Pemrograman Web — PHP Modular
  </footer>
  <script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
