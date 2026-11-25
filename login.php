<?php
/**
 * modules/auth/login.php — halaman Masuk (rute: auth/login)
 * Memakai: validasiEmail(), password_verify()
 */
if (!defined('APP_NAME')) {
    exit;
}

if (isLoggedIn()) {
    redirect('dashboard');
}

// Tujuan setelah login: hanya nama rute yang terdaftar di whitelist (bukan URL bebas)
$next = inputGet('next');
if ($next === '' || !isset($routes[$next]) || $next === 'auth/login' || $next === 'auth/logout') {
    $next = 'dashboard';
}

$errors = [];
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        setFlash('error', 'Sesi formulir kedaluwarsa. Silakan coba lagi.');
        redirect('auth/login', ['next' => $next]);
    }
    $email    = inputPost('email');
    $password = inputPost('password');

    if (!validasiEmail($email)) {
        $errors['email'] = 'Format email tidak valid.';
    }
    if ($password === '') {
        $errors['password'] = 'Password wajib diisi.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id, nama, email, password, role FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $akun = $stmt->fetch();

        if ($akun && password_verify($password, $akun['password'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id'    => (int) $akun['id'],
                'nama'  => $akun['nama'],
                'email' => $akun['email'],
                'role'  => $akun['role'],
            ];
            setFlash('sukses', 'Selamat datang, ' . $akun['nama'] . '.');
            redirect($next);
        }
        $errors['umum'] = 'Email atau password salah.';
    }
}
?>
<h1 class="judul-halaman">Masuk</h1>
<p class="sub-judul">Login diperlukan untuk menambah, mengubah, dan menghapus data buku.</p>

<section class="kartu" style="max-width:460px">
  <?php if (isset($errors['umum'])): ?>
    <div class="alert alert-error" role="alert"><?= e($errors['umum']) ?></div>
  <?php endif; ?>
  <form method="post" action="<?= e(url('auth/login', ['next' => $next])) ?>" novalidate>
    <?= csrfField() ?>
    <div class="form-group<?= isset($errors['email']) ? ' error' : '' ?>">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($email) ?>" autocomplete="username">
      <?php if (isset($errors['email'])): ?><span class="pesan-error"><?= e($errors['email']) ?></span><?php endif; ?>
    </div>
    <div class="form-group<?= isset($errors['password']) ? ' error' : '' ?>">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" autocomplete="current-password">
      <?php if (isset($errors['password'])): ?><span class="pesan-error"><?= e($errors['password']) ?></span><?php endif; ?>
    </div>
    <button type="submit" class="btn btn-emas btn-blok">Masuk</button>
  </form>
  <p class="catatan">Akun demo: <b>siti@gmail.com</b> / <b>siti123</b> (Admin) atau <b>rina@gmail.com</b> / <b>rina123</b> (User).</p>
</section>
