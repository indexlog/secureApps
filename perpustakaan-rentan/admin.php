<?php
// Panel petugas + fitur export (VERSI RENTAN)
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/layout.php';

if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }

$exportDir = realpath(__DIR__ . '/exports');
$msg = '';
$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename']) && $_POST['filename'] !== '') {
    $filename = $_POST['filename'];

    $csvPath = $exportDir . DIRECTORY_SEPARATOR . 'books.csv';
    $fp = fopen($csvPath, 'w');
    fputcsv($fp, ['judul', 'pengarang', 'tahun', 'kategori']);
    $res = mysqli_query($conn, "SELECT judul, pengarang, tahun, kategori FROM books");
    while ($r = mysqli_fetch_assoc($res)) fputcsv($fp, $r);
    fclose($fp);

    // TITIK RENTAN (COMMAND INJECTION)
    // Nama file dari input user ditempel langsung ke perintah shell.
    $isWindows = stripos(PHP_OS, 'WIN') === 0;
    if ($isWindows) {
        $cmd = "cd " . escapeshellarg($exportDir) . " & copy books.csv $filename";
    } else {
        $cmd = "cd " . escapeshellarg($exportDir) . " && tar -czf - books.csv > $filename";
    }
    $output = shell_exec($cmd . ' 2>&1');
    $msg = 'Proses export dijalankan.';
}

$nbooks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM books"))['c'];
$nmem   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM members"))['c'];

page_header('Panel Petugas', 'admin');
?>
<h2>Panel Petugas</h2>
<p class="muted">Masuk sebagai <b><?= htmlspecialchars($_SESSION['user']) ?></b>
   (<?= htmlspecialchars($_SESSION['role']) ?>)</p>

<div class="stats">
  <div class="stat"><div class="n"><?= (int)$nbooks ?></div><div class="l">Koleksi buku</div></div>
  <div class="stat"><div class="n"><?= (int)$nmem ?></div><div class="l">Anggota terdaftar</div></div>
</div>

<div class="card">
  <h3>Export Daftar Buku</h3>
  <p class="muted">Simpan katalog buku ke sebuah file arsip di server.</p>
  <?php if ($msg): ?><div class="alert ok"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <form method="post" class="inline">
    <div style="flex:1">
      <label>Nama file arsip</label>
      <input type="text" name="filename" placeholder="backup.tar.gz">
    </div>
    <button class="btn" type="submit">Export</button>
  </form>
  <?php if ($output !== ''): ?>
    <pre style="background:#0b0b0b;color:#b6ffb6;padding:14px;border-radius:9px;overflow:auto;font-size:13px;margin-top:14px"><?= htmlspecialchars($output) ?></pre>
  <?php endif; ?>
</div>
<?php page_footer(); ?>
