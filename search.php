<?php
declare(strict_types=1);

require_once 'database.php';

    function e(string $value): string { 
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); 
    }


$search_recipe = $_GET['search_recipe'] ?? '';
$search_recipe = trim($search_recipe);


if (!is_string($search_recipe)) {
  $search_recipe = '';
}
    
else {
    $search_recipe = htmlspecialchars($search_recipe, ENT_QUOTES, 'UTF-8');
    echo "You searched for: " . $search_recipe;
}



$sql = 'SELECT * FROM recipes';
$result = mysqli_query($conn, $sql);
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

//
// Prepared statement
// Asked Chatgpt: Why are all my recipe results showing up? Here is my Prepared Statement. ($sql = 'SELECT * FROM recipes';
//$result = mysqli_query($conn, $sql); $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC); 
//AI Answer: You have an all list query use. 


?>
<h2> Search Results </h2>
<?php foreach ($recipes as $recipe): ?>
  <h2>
    <?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') ?>
  </h2>

  <p>
    <?= htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8') ?>
  </p>
  <p>
    <?= htmlspecialchars($recipe['prep_time'], ENT_QUOTES, 'UTF-8') ?>
</p>
<p>
<li>Category: <?= e($recipe['category_name']) ?></li>
<?php endforeach; ?>



<!-- Ai prompt: When I type in chicken and hit submit it says "Please enter a recipe to search for." but I did enter chicken. Why is it saying that? -->