<?php
// Veritabanı bağlantı ayarları
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tatil_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("<div style='font-family:sans-serif;padding:40px;text-align:center;'>
        <h2>⚠️ Veritabanı bağlantısı kurulamadı.</h2>
        <p>Lütfen XAMPP/MAMP'ın çalıştığından ve <code>tatil_db</code> veritabanının oluşturulduğundan emin olun.</p>
        <p style='color:#999;font-size:13px;'>Hata: " . $conn->connect_error . "</p>
    </div>");
}
?>