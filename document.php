<?php
require_once "config.php";
$id = (int)($_GET["id"] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM documents WHERE id = ?");
$stmt->execute([$id]);
$doc = $stmt->fetch();

if (!$doc) {
    http_response_code(404);
    die("Không tìm thấy văn bản.");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($doc["title"]) ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="header"><div class="container nav">
<a class="logo" href="index.php">⚖️ Pháp Luật Giao Thông</a>
<nav><a href="index.php">Trang chủ</a><a href="documents.php">Văn bản</a><a href="questions.php">Hỏi đáp</a><a href="keyphrases.php">Keyphrase</a></nav>
</div></header>

<main class="container page">
<a class="back" href="documents.php">← Quay lại danh sách</a>
<div class="document-card">
<div class="doc-type"><?= htmlspecialchars($doc["type"]) ?></div>
<h1><?= htmlspecialchars($doc["title"]) ?></h1>
<div class="document-meta">
<span>📅 Hiệu lực: <?= htmlspecialchars($doc["effective_date"]) ?></span>
<span>🏛️ Cơ quan: <?= htmlspecialchars($doc["issuer"]) ?></span>
</div>
<hr>
<h2>Nội dung quy định</h2>
<p class="document-content"><?= nl2br(htmlspecialchars($doc["content"])) ?></p>
<h3>Keyphrase</h3>
<div class="tags">
<?php foreach (explode(",", $doc["keywords"]) as $tag): ?>
<span><?= htmlspecialchars(trim($tag)) ?></span>
<?php endforeach; ?>
</div>
<div class="notice">Đây là dữ liệu minh họa cho đồ án. Khi sử dụng trong thực tế, cần kiểm tra văn bản và tình trạng hiệu lực tại nguồn chính thức.</div>
</div>
</main>
<footer><div class="container"><p>© 2026 Hệ thống tra cứu pháp luật giao thông</p></div></footer>
</body>
</html>
