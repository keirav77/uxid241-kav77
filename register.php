<?php
    declare(strict_types=1);
    require 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //AI use: $email = trim($_POST['email'] ?? ''); I used ai to figure out why I was getting an error from
        //$email = post_value('email'); and it was because my php didn't recognize post_value
        $email = trim($_POST['email'] ?? '');
        $plain = $_POST['password'] ?? '';
       
       //Password hash//
        $hash = password_hash($plain, PASSWORD_DEFAULT);

        try{
            mysqli_execute_query(
                $conn, 'INSERT INTO users (email, password_hash) VALUES (?, ?)',
                [$email, $hash]
            );
            header('Location: login.php');
            exit;
        }
        catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
        $error = 'This email is already registered.';
    } else {
        $error = 'Registration failed. Please try again.';
    } 
}
 }
    ?>
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>UXID 241 Cookbook - Register</title>

    <link rel="icon" type="image/x-icon" href="assets/images/placeholder.png">
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header class="site-header">
        <a href="index.php" class="site-logo"> Cookbook  </a>
        <nav>
        <a href="index.php">Home</a>
    </nav>
</header>

    <h1>Create an Account</h1>

    <form method="post">

        <input  type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required >
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <button type="submit">Register</button>

    </form>

    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <a href="login.php">Already have an account? Login here.</a>

</body>
</html>
