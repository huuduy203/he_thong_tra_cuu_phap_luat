<?php
require_once "config.php";
$questions = $pdo->query("SELECT * FROM questions ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Câu hỏi pháp luật</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="header"><div class="container nav">
<a class="logo" href="index.php">⚖️ Pháp Luật Giao Thông</a>
<nav><a href="index.php">Trang chủ</a><a href="documents.php">Văn bản</a><a href="questions.php">Hỏi đáp</a><a href="keyphrases.php">Keyphrase</a></nav>
</div></header>
<main class="container page">
<h1>💬 Kho câu hỏi - trả lời</h1>
<p class="lead">Các câu hỏi mẫu dùng để minh họa chức năng tra cứu theo ngữ nghĩa.</p>
<div class="qa-list">
<?php foreach ($questions as $q): ?>
<div class="qa-item">
<h3><?= htmlspecialchars($q["question"]) ?></h3>
<p><?= nl2br(htmlspecialchars($q["answer"])) ?></p>
<div class="source">Nguồn: <?= htmlspecialchars($q["source"]) ?></div>
<div class="tags">
<?php foreach (explode(",", $q["keywords"]) as $tag): ?><span><?= htmlspecialchars(trim($tag)) ?></span><?php endforeach; ?>
</div>
</div>
<?php endforeach; ?>
</div>
</main>
<footer><div class="container"><p>© 2026 Hệ thống tra cứu pháp luật giao thông</p></div></footer>
</body>
</html>
