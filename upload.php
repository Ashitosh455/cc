<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;

$bucket = 'YOUR_S3_BUCKET';
$region = 'YOUR_REGION';
$pdo = new PDO("mysql:host=YOUR_RDS_ENDPOINT;dbname=gallery", "admin", "YOUR_PASSWORD");

if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['image']['tmp_name'];
    $fileName = basename($_FILES['image']['name']);
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => $region,
        'credentials' => [
            'key'    => 'YOUR_ACCESS_KEY',
            'secret' => 'YOUR_SECRET_KEY',
        ]
    ]);

    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key'    => $fileName,
        'SourceFile' => $fileTmp,
        'ACL'    => 'public-read'
    ]);

    $url = $result['ObjectURL'];

    $stmt = $pdo->prepare("INSERT INTO images (filename, url) VALUES (?, ?)");
    $stmt->execute([$fileName, $url]);

    header("Location: index.html");
}
?>
