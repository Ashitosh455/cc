<?php
header("Content-Type: application/json");
$pdo = new PDO("mysql:host=YOUR_RDS_ENDPOINT;dbname=gallery", "admin", "YOUR_PASSWORD");
$stmt = $pdo->query("SELECT filename, url FROM images");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($images);
?>
