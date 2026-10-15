<?php declare(strict_types=1);


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$user = 'YOUR_USERNAME';
$pass = 'YOUR_PASSWORD';
$db = 'cookbook';

$conn = mysqli_connect($host, $user, $pass, $db);

mysqli_set_charset($conn, 'utf8mb4');
?>