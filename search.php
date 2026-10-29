<?php
declare(strict_types=1);

require_once 'config.php';

   // function e(string $value): string { 
      //  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); 
   // }


$search_recipe = $_GET['search_recipe'] ?? '';
$search_recipe = is_string($search_recipe) ? trim($search_recipe): '';    
$recipes = [];


if ($search_recipe !== '') {

$sql = "SELECT Recipes.*, Categories.category_name
FROM Recipes
LEFT JOIN Categories
  ON Recipes.category_id = Categories.category_id
  WHERE Recipes.title LIKE ? 
  OR Recipes.description LIKE ?";
   
  $stmt = mysqli_prepare($conn, $sql);

  $search_term = '%' . $search_recipe . '%';

mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $search_term,
        $search_term
    );
  
  mysqli_stmt_execute($stmt);

    
$result = mysqli_stmt_get_result($stmt);
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);
 
mysqli_free_result($result);
    mysqli_stmt_close($stmt);
}
?>
<!--Prepared statement
 //Asked Chatgpt: Why are all my recipe results showing up? Here is my Prepared Statement. ($sql = 'SELECT * FROM recipes';
//$result = mysqli_query($conn, $sql); $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC); 
//AI Answer: You have an all list query use. ---
!-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID-241-kav77 Cookbook</title>
    <link rel= "stylesheet" href="styles/style.css"> 
</head>
<body>

<h2> Search Results </h2>

<?php if ($search_recipe !== ''): ?>
  <p> you searched for: <?= e($search_recipe)?> </p>
<?php endif; ?>

<?php if (empty($recipes)): ?>
<p>No recipes found.</p>
<?php endif; ?>
  
  <?php foreach ($recipes as $recipe): ?>

  <h2><?= e($recipe['title']) ?> </h2>
  <p><?= e($recipe['description']) ?> </p>
 <li>Serves: <?= e($recipe['servings']) ?></li>
<li>Category: <?= e($recipe['category_name']) ?></li>
<li>Prep time: <?= e($recipe['prep_time']) ?></li>
<?php endforeach; ?>



<!-- Ai prompt: When I type in chicken and hit submit it says "Please enter a recipe to search for." but I did enter chicken. Why is it saying that? -->