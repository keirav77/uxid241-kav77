<?php
declare(strict_types=1);

$search_recipe = $_GET['search_recipe'] ?? '';
$search_recipe = trim($search_recipe);

if ($search_recipe === '') {
    echo 'Please enter a recipe to search for.';
}
else {
    $search_recipe = htmlspecialchars($search_recipe, ENT_QUOTES, 'UTF-8');
    echo "You searched for: " . $search_recipe;
}

require_once 'config.php';

$sql = 'SELECT * FROM recipes';
$result = mysqli_query($conn, $sql);
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<h2> Search Results </h2>
<?php foreach ($recipes as $recipe): ?>
  <h2>
    <?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') ?>
  </h2>

  <p>
    <?= htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8') ?>
  </p>
<?php endforeach; ?>



<!-- Ai prompt: When I type in chicken and hit submit it says "Please enter a recipe to search for." but I did enter chicken. Why is it saying that? -->