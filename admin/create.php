<?php
declare(strict_types=1);

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../require_login.php';


if (!isset($_SESSION['user_id'])) {
header('Location: ../login.php');

exit;

}
$id = $_GET['id'] ?? '';
if (!is_numeric($id)) {
exit('Invalid id.');
}
