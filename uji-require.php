<?php
// Praktik C.3 — menguji require: jika pesan.php tidak ada, terjadi fatal error dan proses berhenti
echo "Sebelum pemanggilan<br>";
require __DIR__ . '/pesan.php';
echo "Sesudah pemanggilan<br>";
