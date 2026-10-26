<?php
// Beranda + katalog & pencarian buku (publik) - VERSI RENTAN
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/layout.php';

$q = $_GET['q'] ?? '';
$rows = [];
$err  = '';

if ($q !== '') {
    //TITIK RENTAN (SQL INJECTION)
    // Input pencarian langsung digabung ke query (tanpa parameter).
    $sql = "SELECT judul, pengarang, tahun, kategori FROM books
            WHERE judul LIKE '%$q%' OR pengarang LIKE '%$q%' ORDER BY judul";
    $res = mysqli_query($conn, $sql);
    if ($res === false) {
        $err = 'Terjadi kesalahan: ' . mysqli_error($conn); // error DB bocor (error-based)
    } else {
        while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
    }
} else {
    $res = mysqli_query($conn, "SELECT judul, pengarang, tahun, kategori FROM books ORDER BY judul");
    while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
}

page_header('Beranda', 'home');
?>
<section class="hero">
  <h1>Katalog Buku</h1>
  <p>Telusuri dan cari koleksi Perpustakaan Mini.</p>
  <form class="search" method="get">
    <input name="q" placeholder="Cari judul atau pengarang…" value="<?= htmlspecialchars($q) ?>">
    <button type="submit">Cari</button>
  </form>
</section>

<?php if ($err): ?><div class="alert err"><?= htmlspecialchars($err) ?></div><?php endif; ?>
<?php if ($q !== '' && !$err): ?>
  <p class="muted"><?= count($rows) ?> hasil untuk "<?= htmlspecialchars($q) ?>" ·
     <a href="index.php">tampilkan semua</a></p>
<?php endif; ?>

<div class="grid">
<?php foreach ($rows as $r): ?>
  <article class="book">
    <span class="cat"><?= htmlspecialchars($r['kategori']) ?></span>
    <h3><?= htmlspecialchars($r['judul']) ?></h3>
    <p class="by"><?= htmlspecialchars($r['pengarang']) ?> · <?= htmlspecialchars($r['tahun']) ?></p>
  </article>
<?php endforeach; ?>
</div>
<?php if (!$rows && !$err): ?><p class="muted">Tidak ada buku yang cocok dengan pencarian.</p><?php endif; ?>
<?php page_footer(); ?>
