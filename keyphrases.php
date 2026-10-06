<?php
require_once "config.php";
$items = $pdo->query("SELECT * FROM keyphrases ORDER BY category, phrase")->fetchAll();
$groups = [];
foreach ($items as $item) $groups[$item["category"]][] = $item;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Keyphrase pháp luật giao thông</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="header"><div class="container nav">
<a class="logo" href="index.php">⚖️ Pháp Luật Giao Thông</a>
<nav><a href="index.php">Trang chủ</a><a href="documents.php">Văn bản</a><a href="questions.php">Hỏi đáp</a><a href="keyphrases.php">Keyphrase</a></nav>
</div></header>
<main class="container page">
<h1>🧠 Bộ Keyphrase</h1>
<p class="lead">Các cụm từ quan trọng trong lĩnh vực giao thông được phân nhóm để hỗ trợ tra cứu ngữ nghĩa.</p>
<?php foreach ($groups as $category => $items): ?>
<section class="key-section">
<h2><?= htmlspecialchars($category) ?></h2>
<div class="key-grid">
<?php foreach ($items as $item): ?>
<div class="key-card">
<b><?= htmlspecialchars($item["phrase"]) ?></b>
<p><?= htmlspecialchars($item["synonyms"]) ?></p>
</div>
<?php endforeach; ?>
</div>
</section>
<?php endforeach; ?>
</main>
<footer><div class="container"><p>© 2026 Hệ thống tra cứu pháp luật giao thông</p></div></footer>
</body>
</html>
