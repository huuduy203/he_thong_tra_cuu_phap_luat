<?php
require_once "config.php";
$documents = $pdo->query("SELECT * FROM documents ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Văn bản pháp luật</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="header"><div class="container nav">
<a class="logo" href="index.php">⚖️ Pháp Luật Giao Thông</a>
<nav><a href="index.php">Trang chủ</a><a href="documents.php">Văn bản</a><a href="questions.php">Hỏi đáp</a><a href="keyphrases.php">Keyphrase</a></nav>
</div></header>

<main class="container page">
<h1>📚 Văn bản pháp luật</h1>
<p class="lead">Danh sách văn bản được dùng làm dữ liệu minh họa cho hệ thống.</p>
<div class="result-list">
<?php foreach ($documents as $item): ?>
<article class="result-item">
<div class="doc-type"><?= htmlspecialchars($item["type"]) ?></div>
<h3><?= htmlspecialchars($item["title"]) ?></h3>
<p><?= htmlspecialchars($item["content"]) ?></p>
<div class="meta"><span>Ngày hiệu lực: <?= htmlspecialchars($item["effective_date"]) ?></span></div>
<a class="detail-link" href="document.php?id=<?= $item["id"] ?>">Xem chi tiết →</a>
</article>
<?php endforeach; ?>
</div>
</main>
<footer><div class="container"><p>© 2026 Hệ thống tra cứu pháp luật giao thông</p></div></footer>
</body>
</html>
