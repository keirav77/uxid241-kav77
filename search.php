<?php
declare(strict_types=1);

$search_recipe = $_GET['search_recipe'] ?? '';
$search_recipe = trim($search_recipe);

if (empty($search_recipe === '')) {
    echo 'Please enter a recipe to search for.';
}
else {
    $search_recipe = htmlspecialchars($search_recipe, ENT_QUOTES, 'UTF-8');
    echo 'You searched for: ' . $search_recipe;
}

?>
