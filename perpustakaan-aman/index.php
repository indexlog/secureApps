<?php
// Beranda + katalog & pencarian buku (publik)
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/layout.php';

$q = $_GET['q'] ?? '';
$rows = [];

if ($q !== '') {
    //  AMAN: prepared statement 
    $like = '%' . $q . '%';
    $stmt = mysqli_prepare($conn,
        "SELECT judul, pengarang, tahun, kategori FROM books
         WHERE judul LIKE ? OR pengarang LIKE ? ORDER BY judul");
    mysqli_stmt_bind_param($stmt, 'ss', $like, $like);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
    mysqli_stmt_close($stmt);
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

<?php if ($q !== ''): ?>
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
<?php if (!$rows): ?><p class="muted">Tidak ada buku yang cocok dengan pencarian.</p><?php endif; ?>
<?php page_footer(); ?>
