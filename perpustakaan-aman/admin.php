<?php
// Panel petugas + fitur export (VERSI AMAN)
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/layout.php';

if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }

$exportDir = realpath(__DIR__ . '/exports');
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'])) {
    $filename = trim($_POST['filename']);

    //  AMAN 1: allowlist nama file 
    if (!preg_match('/^[A-Za-z0-9._-]{1,50}$/', $filename)) {
        $err = 'Nama file tidak valid. Gunakan hanya huruf, angka, titik (.), strip (-), '
             . 'dan underscore (_), tanpa spasi atau karakter khusus.';
    } else {
        // Tulis katalog ke CSV
        $csvPath = $exportDir . DIRECTORY_SEPARATOR . 'books.csv';
        $fp = fopen($csvPath, 'w');
        fputcsv($fp, ['judul', 'pengarang', 'tahun', 'kategori']);
        $res = mysqli_query($conn, "SELECT judul, pengarang, tahun, kategori FROM books");
        while ($r = mysqli_fetch_assoc($res)) fputcsv($fp, $r);
        fclose($fp);

        //  AMAN 2: escapeshellarg() pada argumen 
        $isWindows = stripos(PHP_OS, 'WIN') === 0;
        if ($isWindows) {
            $cmd = 'cd ' . escapeshellarg($exportDir) . ' & copy books.csv ' . escapeshellarg($filename);
        } else {
            $cmd = 'cd ' . escapeshellarg($exportDir) . ' && tar -czf - books.csv > ' . escapeshellarg($filename);
        }
        shell_exec($cmd . ' 2>&1');
        $msg = 'Export berhasil. File "' . htmlspecialchars($filename) . '" tersimpan di folder exports/.';
    }
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
  <?php if ($msg): ?><div class="alert ok"><?= $msg ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert err"><?= htmlspecialchars($err) ?></div><?php endif; ?>
  <form method="post" class="inline">
    <div style="flex:1">
      <label>Nama file arsip</label>
      <input type="text" name="filename" placeholder="backup.tar.gz">
    </div>
    <button class="btn" type="submit">Export</button>
  </form>
</div>
<?php page_footer(); ?>
