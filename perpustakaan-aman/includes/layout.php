<?php
//  Tampilan bersama (header + footer) agar seluruh halaman
function page_header($title, $active = '') {
    $user = $_SESSION['user'] ?? null;
    ?><!DOCTYPE html>
<html lang="id"><head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title) ?> — Perpustakaan Mini</title>
<style>
:root{--hijau:#0f6b4f;--hijau2:#0b5540;--tinta:#1a2b26;--abu:#6b7a75;--garis:#e4e9e7;--bg:#f6f8f7}
*{box-sizing:border-box}
body{margin:0;font-family:system-ui,Segoe UI,Arial,sans-serif;color:var(--tinta);background:var(--bg)}
a{color:var(--hijau);text-decoration:none}
a:hover{text-decoration:underline}
.wrap{max-width:960px;margin:0 auto;padding:0 20px}
/* Topbar */
.topbar{background:var(--hijau);color:#fff}
.topbar .wrap{display:flex;align-items:center;justify-content:space-between;height:60px}
.brand{color:#fff;font-weight:800;font-size:19px}
.brand:hover{text-decoration:none;opacity:.92}
.topbar nav{display:flex;align-items:center;gap:18px}
.topbar nav a{color:#dff1ea;font-size:15px}
.topbar nav a.on{color:#fff;font-weight:700;border-bottom:2px solid #fff;padding-bottom:4px}
.topbar nav a:hover{color:#fff;text-decoration:none}
.who{color:#bfe3d7;font-size:13px}
.btn-sm{background:rgba(255,255,255,.16);padding:5px 12px;border-radius:7px;color:#fff !important;font-size:13px}
/* Main */
main.wrap{padding-top:28px;padding-bottom:48px}
.hero{background:#fff;border:1px solid var(--garis);border-radius:14px;padding:26px 24px;margin-bottom:24px}
.hero h1{margin:0 0 4px;font-size:26px}
.hero p{margin:0 0 16px;color:var(--abu)}
.search{display:flex;gap:10px}
.search input{flex:1;padding:12px 14px;border:1px solid var(--garis);border-radius:9px;font-size:15px}
.search button,.btn{background:var(--hijau);color:#fff;border:0;border-radius:9px;padding:12px 20px;font-size:15px;cursor:pointer}
.search button:hover,.btn:hover{background:var(--hijau2)}
.muted{color:var(--abu);font-size:14px}
/* Grid buku */
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:16px;margin-top:8px}
.book{background:#fff;border:1px solid var(--garis);border-radius:12px;padding:16px;transition:box-shadow .15s}
.book:hover{box-shadow:0 6px 18px rgba(15,107,79,.1)}
.book .cat{display:inline-block;background:#e7f3ee;color:var(--hijau2);font-size:11px;font-weight:700;padding:3px 9px;border-radius:999px;margin-bottom:10px}
.book h3{margin:0 0 6px;font-size:16px;line-height:1.3}
.book .by{margin:0;color:var(--abu);font-size:13px}
/* Card & form */
.card{background:#fff;border:1px solid var(--garis);border-radius:14px;padding:24px;margin-bottom:20px}
.card.narrow{max-width:420px;margin:30px auto}
.card h2,.card h3{margin-top:0}
label{display:block;font-size:13px;font-weight:600;color:var(--tinta);margin:12px 0 5px}
input[type=text],input[type=password],input:not([type]){width:100%;padding:11px 13px;border:1px solid var(--garis);border-radius:9px;font-size:15px}
form.inline{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap}
form.inline input{min-width:220px}
.alert{padding:11px 14px;border-radius:9px;font-size:14px;margin:12px 0}
.alert.ok{background:#e4f4ec;color:#0b5540;border:1px solid #bfe3d7}
.alert.err{background:#fce8e8;color:#a12a2a;border:1px solid #f3c6c6}
.stats{display:flex;gap:14px;margin:16px 0 20px;flex-wrap:wrap}
.stat{background:#fff;border:1px solid var(--garis);border-radius:12px;padding:14px 20px;min-width:130px}
.stat .n{font-size:24px;font-weight:800;color:var(--hijau)}
.stat .l{font-size:13px;color:var(--abu)}
/* Footer */
.foot{border-top:1px solid var(--garis);background:#fff;color:var(--abu);font-size:13px}
.foot .wrap{padding:18px 20px}
@media(max-width:560px){.topbar .wrap{height:auto;padding:10px 20px;flex-direction:column;gap:8px}}
</style>
</head><body>
<header class="topbar">
  <div class="wrap">
    <a class="brand" href="index.php">📚 Perpustakaan Mini</a>
    <nav>
      <a href="index.php" class="<?= $active==='home'?'on':'' ?>">Beranda</a>
      <?php if ($user): ?>
        <a href="admin.php" class="<?= $active==='admin'?'on':'' ?>">Panel Petugas</a>
        <span class="who">Hai, <?= htmlspecialchars($user) ?></span>
        <a href="logout.php" class="btn-sm">Keluar</a>
      <?php else: ?>
        <a href="login.php" class="<?= $active==='login'?'on':'' ?>">Login Petugas</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="wrap"><?php
}

function page_footer() {
    ?></main>
<footer class="foot"><div class="wrap">Perpustakaan Mini — Kelompok ambar</div></footer>
</body></html><?php
}
