<?php
/** modules/auth/logout.php — keluar (rute: auth/logout), hanya lewat POST + CSRF */
if (!defined('APP_NAME')) {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrfValid()) {
    unset($_SESSION['user']);
    session_regenerate_id(true);
    setFlash('sukses', 'Anda telah keluar.');
}
redirect('dashboard');
