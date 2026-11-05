<?php 
declare(strict_types=1);
session_start();

require_once 'database.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $plain = $_POST['password'] ?? '';
    $hash = password_hash($plain, PASSWORD_DEFAULT);

$result = mysqli_execute_query(
    $conn,
    'SELECT id, password_hash FROM users WHERE email = ?',
    [$email]
);

$user = mysqli_fetch_assoc($result);

if ($user !== null && password_verify($plain, $user['password_hash'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$user['id'];

    header('Location: admin/index.php');
    exit;}

else{
    $error = 'invalid email or password';
}}

?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook - Login</title>
    <link rel="icon" type="image/x-icon" href="assets/images/placeholder.png">
    
      <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header class="site-header">
        <a href="index.php" class="site-logo"> Cookbook  </a>
        <nav>
        <a href="index.php">Home</a>
    </nav>
</header>
      <h1>Login</h1>
       <form method = "post">
            <input type="email" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="password" required>
            <button type="submit">Submit</button>
        </form>
        <a href="register.php">Don't have an Account? Register Here.</a>
       
        <?php if (!empty($error)): ?>
            <p><?= e($error)?> </p>
        <?php endif?>
        </body>
        </html>