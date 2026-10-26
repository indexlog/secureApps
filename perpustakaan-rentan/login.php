<?php
// Login petugas (VERSI RENTAN)
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/layout.php';

if (!empty($_SESSION['user'])) { header('Location: admin.php'); exit; }

$err = '';

//   login.php?username=admin' -- &password=x
//   login.php?username=' OR '1'='1&password=' OR '1'='1
$username = $_POST['username'] ?? $_GET['username'] ?? '';
$password = $_POST['password'] ?? $_GET['password'] ?? '';
$ada_input = ($_SERVER['REQUEST_METHOD'] === 'POST')
          || isset($_GET['username']) || isset($_GET['password']);

if ($ada_input) {
    // TITIK RENTAN (SQL INJECTION - auth bypass)
    // Input langsung digabung ke query tanpa parameter
    $sql = "SELECT id, username, role FROM users
            WHERE username = '$username' AND password = '$password'";
    $res = mysqli_query($conn, $sql);

    if ($res === false) {
        $err = 'Terjadi kesalahan: ' . mysqli_error($conn);
    } elseif ($user = mysqli_fetch_assoc($res)) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: admin.php');
        exit;
    } else {
        $err = 'Username atau password salah.';
    }
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
