<?php 
declare(strict_types=1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require 'config.php';

try {
    $conn = mysqli_connect($host, $user, $pass, $db);
   
    mysqli_set_charset($conn, 'utf8mb4');}
     
    catch (mysqli_sql_exception $e) {
  exit('Database connection failed.');

}