<?php
require_once "config.php";

$stats = [
    "documents" => $pdo->query("SELECT COUNT(*) FROM documents")->fetchColumn(),
    "questions" => $pdo->query("SELECT COUNT(*) FROM questions")->fetchColumn(),
    "keyphrases" => $pdo->query("SELECT COUNT(*) FROM keyphrases")->fetchColumn()
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu pháp luật giao thông</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="header">
    <div class="container nav">
        <a class="logo" href="index.php">⚖️ Pháp Luật Giao Thông</a>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="documents.php">Văn bản</a>
            <a href="questions.php">Hỏi đáp</a>
            <a href="keyphrases.php">Keyphrase</a>
        </nav>
    </div>
</header>

<main>
<section class="hero">
    <div class="container">
        <span class="badge">HỆ THỐNG TRA CỨU KIẾN THỨC PHÁP LUẬT</span>
        <h1>Tra cứu pháp luật giao thông<br>nhanh và dễ hiểu</h1>
        <p>Nhập câu hỏi tự nhiên như: <b>“Đi xe máy không đội mũ bảo hiểm bị phạt bao nhiêu?”</b></p>

        <form action="search.php" method="get" class="search-box">
            <input type="text" name="q" placeholder="Nhập câu hỏi hoặc từ khóa..." required>
            <button type="submit">🔍 Tra cứu</button>
        </form>

        <div class="suggestions">
            <a href="search.php?q=giấy phép lái xe">Giấy phép lái xe</a>
            <a href="search.php?q=mũ bảo hiểm">Mũ bảo hiểm</a>
            <a href="search.php?q=vượt đèn đỏ">Vượt đèn đỏ</a>
            <a href="search.php?q=nồng độ cồn">Nồng độ cồn</a>
        </div>
    </div>
</section>

<section class="container section">
    <div class="section-title">
        <div>
            <h2>Hệ thống có gì?</h2>
            <p>Phiên bản đơn giản phục vụ học tập và minh họa bài toán tra cứu.</p>
        </div>
    </div>

    <div class="cards">
        <div class="card">
            <div class="icon">📚</div>
            <h3>Tra cứu văn bản</h3>
            <p>Tìm Luật, Nghị định và các quy định liên quan đến giao thông đường bộ.</p>
        </div>
        <div class="card">
            <div class="icon">💬</div>
            <h3>Tra cứu theo câu hỏi</h3>
            <p>Người dùng có thể nhập câu hỏi bằng ngôn ngữ gần với cách nói hằng ngày.</p>
        </div>
        <div class="card">
            <div class="icon">🧠</div>
            <h3>Tra cứu bằng AI</h3>
            <p>Hệ thống sử dụng TF-IDF và Cosine Similarity để đo độ tương đồng giữa câu hỏi và dữ liệu pháp luật.</p>
        </div>
    </div>
</section>

<section class="container section">
    <div class="stats">
        <div><strong><?= $stats["documents"] ?></strong><span>Văn bản mẫu</span></div>
        <div><strong><?= $stats["questions"] ?></strong><span>Câu hỏi mẫu</span></div>
        <div><strong><?= $stats["keyphrases"] ?></strong><span>Keyphrase</span></div>
    </div>
</section>

<section class="container section">
    <div class="info-box">
        <h2>Ví dụ truy vấn</h2>
        <div class="example-list">
            <a href="search.php?q=xe máy không đội mũ bảo hiểm">“Xe máy không đội mũ bảo hiểm bị phạt thế nào?”</a>
            <a href="search.php?q=giấy phép lái xe hạng B">“Giấy phép lái xe hạng B có thời hạn bao lâu?”</a>
            <a href="search.php?q=vượt đèn đỏ">“Vượt đèn đỏ bị xử phạt như thế nào?”</a>
        </div>
    </div>
</section>
</main>

<footer>
    <div class="container">
        <p>© 2026 Hệ thống tra cứu pháp luật giao thông - Đồ án học tập</p>
        <p class="small">Dữ liệu minh họa. Khi áp dụng thực tế cần đối chiếu văn bản pháp luật đang có hiệu lực.</p>
    </div>
</footer>
</body>
</html>
