<?php
declare(strict_types=1);

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../require_login.php';

$result = mysqli_execute_query(
    $conn,
    'SELECT email FROM users WHERE id = ?',
    [$_SESSION['user_id']]
);
$user = mysqli_fetch_assoc($result);



$sql = 'SELECT r.id, r.title, r.description, r.servings, r.prep_time, r.image, c.category_name
        FROM recipes r
        JOIN categories c ON c.category_id = r.category_id
        ORDER BY r.title';
$recipes = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cookbook</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<header>
      <h1> Keira Vaughan's Cookbook</h1>
<form action="search.php" method="GET">
    <label for="search_recipe">Search for a Recipe here:</label>

    <input type="text" id="search_recipe" name="search_recipe">

    <button type="submit">Search Recipes</button>
</form>
 <nav class="account-nav">
        <a href="../index.php">Home</a>
        <a href="logout.php">Log Out</a>
    </nav>

</header>

<main>
    <main class="page-layout">

    <section class="recipe-content">
        <!-- All your recipe cards go here -->
    </section>

    <aside class="login-card">
        <!-- Your login form goes here -->
    </aside>

</main>
<h2>All Recipes</h2>
 <section class="recipe-grid">
<!-- AI use: ChatGPT helped troubleshoot the recipe card foreach loop
// and explained how to structure one card for each recipe.!-->
        <?php foreach ($recipes as $recipe): ?>
    <article class="recipe-card">

<!-- AI use: ChatGPT helped troubleshoot the e() escaping function
// so it could safely display database values. !-->
         <h3><?= e($recipe['title']) ?></h3>

           <p class="category">
            Category: <?= e($recipe['category_name']) ?></p>
           <p class= "description"><?= e($recipe['description']) ?></p>
           
           <div class="recipe-details">
            <span>
           Serves <?= e($recipe['servings']) ?> 
        </span>
        <span>
            Category: <?= ($recipe['category_name']) ?> 
        </span>
       
     <a class="recipe-button"
                   href="recipe.php?id=<?= e((string)$recipe['id']) ?>">
                    View Recipe
                </a>
        </div>  
       <!--Ai: How do i add the images as files:!-->
       


              <!-- AI use: Asked ai where i was getting a parse error on line 70:
               Answer: you forgot the php end for each which is needed to close the loop.
               Other things that ai noticed: By doing the same php to list out the actual cards you are duplicating your php, consider deleting 
               the one above that doesn't print as cards. -->  
            </article>
              <?php endforeach; ?>
            </section>
      

    <h2>Welcome!</h2>

    <p>You are logged in as <?= e($user['email']) ?>.</p>

    <a href="logout.php">Log Out</a>
</main>

</body>
</html>