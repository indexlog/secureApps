<?php
// Login petugas (VERSI AMAN)
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/layout.php';

if (!empty($_SESSION['user'])) { header('Location: admin.php'); exit; }

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    //  AMAN: prepared statement + password_verify() 
    $stmt = mysqli_prepare($conn,
        "SELECT id, username, role, password_hash FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $res  = mysqli_stmt_get_result($stmt);
    $user = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: admin.php');
        exit;
    }
    $err = 'Username atau password salah.';
}

page_header('Login Petugas', 'login');
?>
<div class="card narrow">
  <h2>Login Petugas</h2>
  <?php if ($err): ?><div class="alert err"><?= htmlspecialchars($err) ?></div><?php endif; ?>
  <form method="post">
    <label>Username</label>
    <input type="text" name="username" autocomplete="off">
    <label>Password</label>
    <input type="password" name="password" autocomplete="off">
    <button class="btn" type="submit" style="margin-top:16px">Masuk</button>
  </form>
</div>
<?php page_footer(); ?>
