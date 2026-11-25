<?php
// Praktik C.3 — menguji include: jika pesan.php tidak ada, hanya muncul peringatan
echo "Sebelum pemanggilan<br>";
include __DIR__ . '/pesan.php';
echo "Sesudah pemanggilan<br>";
