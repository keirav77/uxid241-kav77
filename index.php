<?php 
declare(strict_types=1);

//require config so i dont have to reload it//
require 'config.php';

$host = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'cookbook';


try{$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_set_charset($conn, 'utf8mb4');
}
catch (mysqli_sql_exception $e) {
    http_response_code(500);
    exit('connection failed: ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID-241-kav77 Cookbook</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1>
        <?php echo "Keira Vaughan's Cookbook"; ?>
</h1>

<!-- Asked Ai why it was saying hello world twice, i pasted in my echo statement in the beginning of the php, and then i also put in the one in my html. 
 The answer I got was that both work but I will be able to have more control over the output, and other adjustments if I use the echo statement in the html. 
 So I decided to remove the echo "hello world!" after declaring the strict types. -->

<form action="search.php" method="GET">
    <label for="search_recipe">Search for a Recipe here:</label>

    <input type="text" id="search_recipe" name="search_recipe">
    <button type="submit">Search Recipes</button>
</form>

</body>
</html>
