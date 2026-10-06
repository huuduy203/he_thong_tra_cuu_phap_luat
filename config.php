<?php
// Kết nối MySQL
$host = "localhost";
$db   = "phapluat";
$user = "root";
$pass = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Không thể kết nối cơ sở dữ liệu. Hãy kiểm tra MySQL/XAMPP và file database.sql.");
}
?>
