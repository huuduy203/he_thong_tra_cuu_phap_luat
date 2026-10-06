<?php
require_once "config.php";

$q = trim($_GET["q"] ?? "");
$question = null;
$questionResults = [];
$documentResults = [];

/*
 * ==========================================================
 * TÌM KIẾM AI BẰNG TF-IDF + COSINE SIMILARITY
 * ==========================================================
 *
 * TF-IDF giúp hệ thống đánh giá từ nào quan trọng trong một
 * văn bản và Cosine Similarity đo mức độ giống nhau giữa
 * câu hỏi người dùng với dữ liệu trong CSDL.
 *
 * Không cần cài thêm thư viện PHP.
 */

function normalizeText($text) {
    $text = mb_strtolower($text, 'UTF-8');

    // Giữ chữ cái, số và khoảng trắng tiếng Việt.
    $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
    $text = preg_replace('/\s+/u', ' ', $text);

    return trim($text);
}

function tokenize($text) {
    $text = normalizeText($text);

    if ($text === '') {
        return [];
    }

    $words = preg_split('/\s+/u', $text);

    // Một số từ thường xuất hiện nhưng ít mang ý nghĩa tìm kiếm.
    $stopWords = [
        'là','có','bị','được','cho','và','của','trong','khi',
        'thì','cần','phải','như','nào','gì','với','một','những',
        'người','theo','về','đến','từ','hay','không','để',
        'pháp','luật','quy','định'
    ];

    $tokens = [];

    foreach ($words as $word) {
        if ($word === '' || mb_strlen($word, 'UTF-8') < 2) {
            continue;
        }

        if (in_array($word, $stopWords, true)) {
            continue;
        }

        $tokens[] = $word;
    }

    // Thêm bigram để giữ ý nghĩa của các cụm quan trọng:
    // "mũ bảo hiểm", "giấy phép lái xe", "nồng độ cồn"...
    for ($i = 0; $i < count($words) - 1; $i++) {
        if (
            $words[$i] !== '' &&
            $words[$i + 1] !== '' &&
            !in_array($words[$i], $stopWords, true) &&
            !in_array($words[$i + 1], $stopWords, true)
        ) {
            $tokens[] = $words[$i] . ' ' . $words[$i + 1];
        }
    }

    return $tokens;
}

/*
 * Mở rộng một số từ/cụm từ gần nghĩa trước khi tính TF-IDF.
 * Đây là lớp hỗ trợ ngôn ngữ, còn thuật toán xếp hạng chính
 * vẫn là TF-IDF + Cosine Similarity.
 */
function expandQuery($text) {
    $groups = [
        "mũ bảo hiểm" => ["nón bảo hiểm", "đội mũ", "đội nón"],
        "xe máy" => ["mô tô", "xe hai bánh"],
        "ô tô" => ["xe hơi", "xe con"],
        "giấy phép lái xe" => ["bằng lái", "bằng lái xe", "gplx"],
        "vượt đèn đỏ" => ["vượt đèn tín hiệu", "không chấp hành đèn tín hiệu"],
        "nồng độ cồn" => ["rượu bia", "uống rượu", "uống bia"],
        "tốc độ" => ["quá tốc độ", "chạy quá nhanh"],
        "dừng đỗ" => ["dừng xe", "đỗ xe"],
        "tai nạn" => ["tai nạn giao thông", "va chạm"],
        "xe cứu hỏa" => ["xe ưu tiên"],
        "xe cứu thương" => ["xe ưu tiên"]
    ];

    $text = normalizeText($text);

    foreach ($groups as $canonical => $synonyms) {
        $found = false;

        if (mb_stripos($text, $canonical, 0, 'UTF-8') !== false) {
            $found = true;
        }

        foreach ($synonyms as $synonym) {
            if (mb_stripos($text, $synonym, 0, 'UTF-8') !== false) {
                $found = true;
                break;
            }
        }

        if ($found) {
            $text .= ' ' . $canonical . ' ' . implode(' ', $synonyms);
        }
    }

    return $text;
}

function termFrequency($tokens) {
    $tf = [];
    $count = count($tokens);

    if ($count === 0) {
        return $tf;
    }

    foreach ($tokens as $token) {
        if (!isset($tf[$token])) {
            $tf[$token] = 0;
        }
        $tf[$token]++;
    }

    foreach ($tf as $token => $value) {
        $tf[$token] = $value / $count;
    }

    return $tf;
}

function inverseDocumentFrequency($documents) {
    $idf = [];
    $n = count($documents);

    if ($n === 0) {
        return $idf;
    }

    foreach ($documents as $tokens) {
        foreach (array_unique($tokens) as $token) {
            if (!isset($idf[$token])) {
                $idf[$token] = 0;
            }
            $idf[$token]++;
        }
    }

    foreach ($idf as $token => $df) {
        // Smooth IDF để tránh log(0).
        $idf[$token] = log(($n + 1) / ($df + 1)) + 1;
    }

    return $idf;
}

function tfidfVector($tokens, $idf) {
    $tf = termFrequency($tokens);
    $vector = [];

    foreach ($tf as $token => $frequency) {
        if (isset($idf[$token])) {
            $vector[$token] = $frequency * $idf[$token];
        }
    }

    return $vector;
}

function cosineSimilarity($vectorA, $vectorB) {
    if (empty($vectorA) || empty($vectorB)) {
        return 0;
    }

    $dot = 0;
    $normA = 0;
    $normB = 0;

    foreach ($vectorA as $term => $value) {
        if (isset($vectorB[$term])) {
            $dot += $value * $vectorB[$term];
        }

        $normA += $value * $value;
    }

    foreach ($vectorB as $value) {
        $normB += $value * $value;
    }

    if ($normA == 0 || $normB == 0) {
        return 0;
    }

    return $dot / (sqrt($normA) * sqrt($normB));
}

if ($q !== "") {
    // 1. Lấy dữ liệu từ MySQL.
    $questions = $pdo->query("SELECT * FROM questions ORDER BY id DESC")->fetchAll();
    $documents = $pdo->query("SELECT * FROM documents ORDER BY id DESC")->fetchAll();

    // 2. Tạo corpus thống nhất.
    $corpus = [];
    $items = [];

    foreach ($questions as $row) {
        $text = $row["question"] . " " . $row["answer"] . " " . $row["keywords"];
        $items[] = [
            "kind" => "question",
            "data" => $row,
            "text" => expandQuery($text)
        ];
        $corpus[] = tokenize(expandQuery($text));
    }

    foreach ($documents as $row) {
        $text = $row["title"] . " " . $row["type"] . " " .
                $row["issuer"] . " " . $row["content"] . " " . $row["keywords"];

        $items[] = [
            "kind" => "document",
            "data" => $row,
            "text" => expandQuery($text)
        ];
        $corpus[] = tokenize(expandQuery($text));
    }

    // 3. Tính IDF cho toàn bộ dữ liệu.
    $idf = inverseDocumentFrequency($corpus);

    // 4. Vector TF-IDF của câu hỏi người dùng.
    $queryText = expandQuery($q);
    $queryTokens = tokenize($queryText);
    $queryVector = tfidfVector($queryTokens, $idf);

    // 5. Tính Cosine Similarity cho từng bản ghi.
    foreach ($items as $index => $item) {
        $tokens = $corpus[$index];
        $documentVector = tfidfVector($tokens, $idf);

        $score = cosineSimilarity($queryVector, $documentVector);

        $items[$index]["score"] = $score;
    }

    // 6. Chỉ lấy kết quả có điểm > 0 và sắp xếp giảm dần.
    usort($items, function ($a, $b) {
        return $b["score"] <=> $a["score"];
    });

    $items = array_values(array_filter($items, function ($item) {
        return $item["score"] > 0;
    }));

    // 7. Tách câu hỏi và văn bản để hiển thị.
    foreach ($items as $item) {
        if ($item["kind"] === "question") {
            $item["data"]["score"] = $item["score"];
            $questionResults[] = $item["data"];
        } else {
            $item["data"]["score"] = $item["score"];
            $documentResults[] = $item["data"];
        }
    }

    // Câu trả lời tốt nhất.
    if (!empty($questionResults)) {
        $question = $questionResults[0];
    }

    // Giới hạn kết quả hiển thị.
    $questionResults = array_slice($questionResults, 0, 5);
    $documentResults = array_slice($documentResults, 0, 10);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kết quả tra cứu AI</title>
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

<main class="container page">
<div class="search-inline">
<form action="search.php" method="get">
<input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Nhập câu hỏi hoặc từ khóa...">
<button>🔍 Tìm kiếm</button>
</form>
</div>

<?php if ($q === ""): ?>
<div class="empty">
<h2>Hãy nhập nội dung cần tra cứu</h2>
<p>Ví dụ: “xe máy không đội nón bảo hiểm”, “bằng lái xe”, “uống bia lái xe”.</p>
</div>
<?php else: ?>

<div class="result-header">
<h1>🤖 Kết quả tra cứu AI</h1>
<p>Từ khóa: <b>“<?= htmlspecialchars($q) ?>”</b></p>
</div>

<?php if ($question): ?>
<section class="answer-card">
<div class="answer-label">💡 CÂU TRẢ LỜI PHÙ HỢP NHẤT</div>
<h2><?= htmlspecialchars($question["question"]) ?></h2>
<p><?= nl2br(htmlspecialchars($question["answer"])) ?></p>
<div class="source">
Nguồn tham khảo: <?= htmlspecialchars($question["source"]) ?>
<br>
Độ tương đồng TF-IDF: <b><?= number_format($question["score"] * 100, 2) ?>%</b>
</div>
</section>
<?php endif; ?>

<h2 class="subheading">💬 Các câu hỏi gần nhất</h2>
<?php if (!$questionResults): ?>
<div class="empty"><p>Chưa tìm thấy câu hỏi tương tự.</p></div>
<?php else: ?>
<div class="qa-list">
<?php foreach ($questionResults as $item): ?>
<div class="qa-item">
<h3><?= htmlspecialchars($item["question"]) ?></h3>
<p><?= nl2br(htmlspecialchars($item["answer"])) ?></p>
<div class="source">
Độ tương đồng: <b><?= number_format($item["score"] * 100, 2) ?>%</b>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<h2 class="subheading">📚 Văn bản pháp luật liên quan</h2>
<?php if (!$documentResults): ?>
<div class="empty">
<h3>Chưa tìm thấy văn bản phù hợp</h3>
<p>Hãy thử các từ khóa như “mũ bảo hiểm”, “giấy phép lái xe”, “nồng độ cồn”.</p>
</div>
<?php else: ?>
<div class="result-list">
<?php foreach ($documentResults as $item): ?>
<article class="result-item">
<div class="doc-type"><?= htmlspecialchars($item["type"]) ?></div>
<h3><?= htmlspecialchars($item["title"]) ?></h3>
<p><?= htmlspecialchars(mb_substr($item["content"], 0, 260, 'UTF-8')) ?>...</p>
<div class="meta">
<span>📅 <?= htmlspecialchars($item["effective_date"]) ?></span>
<span>🧠 Tương đồng: <?= number_format($item["score"] * 100, 2) ?>%</span>
</div>
<a class="detail-link" href="document.php?id=<?= $item["id"] ?>">Xem chi tiết →</a>
</article>
<?php endforeach; ?>
</div>
<?php endif; ?>

<div class="method-box">
<b>🧠 Hệ thống AI đã xử lý truy vấn như thế nào?</b>
<p>
Chuẩn hóa câu hỏi → tách từ → loại bỏ từ ít ý nghĩa →
mở rộng một số từ đồng nghĩa → tính TF-IDF →
tính Cosine Similarity → xếp hạng kết quả.
</p>
<p class="small">
<b>TF-IDF:</b> đánh giá mức độ quan trọng của từ trong dữ liệu.
<b>Cosine Similarity:</b> đo mức độ giống nhau giữa câu hỏi và từng dữ liệu.
</p>
</div>

<?php endif; ?>
</main>

<footer><div class="container"><p>© 2026 Hệ thống tra cứu pháp luật giao thông - Đồ án học tập</p></div></footer>
</body>
</html>
