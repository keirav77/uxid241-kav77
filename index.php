<?php 
declare(strict_types=1);

//require config so i dont have to reload it//
//require 'config.php';
require __DIR__ . '/config.php';



//Asked Ai how why Im getting this error: Fatal error: Uncaught Error: Call to undefined function escape_html() in /Applications/MAMP/htdocs/uxid241-kav77/index.php:53 Stack trace: #0 {main} thrown in /Applications/MAMP/htdocs/uxid241-kav77/index.php on line 53


$host = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'cookbook';




$sql = 'SELECT r.id, r.title, r.description, r.servings, r.prep_time, c.category_name
        FROM recipes r
        JOIN categories c ON c.category_id = r.category_id
        ORDER BY r.title';
$recipes = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID-241-kav77 Cookbook</title>
    <link rel= "stylesheet" href="styles/style.css"> 
</head>
<body>
    <header>
    <h1> Keira Vaughan's Cookbook</h1>

<!-- Asked Ai why it was saying hello world twice, i pasted in my echo statement in the beginning of the php, and then i also put in the one in my html. 
 The answer I got was that both work but I will be able to have more control over the output, and other adjustments if I use the echo statement in the html. 
 So I decided to remove the echo "hello world!" after declaring the strict types. -->

<form action="search.php" method="GET">
    <label for="search_recipe">Search for a Recipe here:</label>

    <input type="text" id="search_recipe" name="search_recipe">

    <button type="submit">Search Recipes</button>
</form>
</header>

<main>
<h2>All Recipes</h2>
 <section class="recipe-grid">
        <?php foreach ($recipes as $recipe): ?>
    <article class="recipe-card">

       <div class="card-body"> 

         <h3><?= e($recipe['title']) ?></h3>
           <p class="category">
            Category: <?= e($recipe['category_name']) ?></p>
           <p class= "description"><?= e($recipe['description']) ?></p>
           
           <div class="recipe-details">
           <p>Serves <?= e($recipe['servings']) ?> · <?= e($recipe['prep_time']) ?> min</p>
            <p>Prep Time: <?= ($recipe['category_name']) ?></p>
        </div>  

              <!-- AI use: Asked ai where i was getting a parse error on line 70:
               Answer: you forgot the php end for each which is needed to close the loop.
               Other things that ai noticed: By doing the same php to list out the actual cards you are duplicating your php, consider deleting 
               the one above that doesn't print as cards. -->
                </div>  
            </article>
              <?php endforeach; ?>
            </section>
        </main>
        </body>
</html>
