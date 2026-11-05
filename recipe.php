<?php
declare(strict_types=1);

require __DIR__ . '/config.php';

$id = $_GET['id'] ?? '';

if (!is_string($id) || !ctype_digit($id)) {
    exit('Invalid recipe.');
}

$sql = 'SELECT 
            r.id,
            r.title,
            r.description,
            r.servings,
            r.prep_time,
            c.category_name
        FROM recipes r
        JOIN categories c 
            ON c.category_id = r.category_id
        WHERE r.id = ?';

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, 'i', $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$recipe = mysqli_fetch_assoc($result);

if (!$recipe) {
    exit('Recipe not found.');
}
$steps_sql = 'SELECT step_number, instruction
              FROM recipe_steps
              WHERE recipe_id = ?
              ORDER BY step_number';

$steps_stmt = mysqli_prepare($conn, $steps_sql);

mysqli_stmt_bind_param($steps_stmt, 'i', $id);

mysqli_stmt_execute($steps_stmt);

$steps_result = mysqli_stmt_get_result($steps_stmt);

$steps = mysqli_fetch_all($steps_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($recipe['title']) ?></title>

    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <main>

        <a href="index.php">← Back to all recipes</a>

        <h1><?= e($recipe['title']) ?></h1>

        <p>
            Category: <?= e($recipe['category_name']) ?>
</p>

        <h3>
            <?= e($recipe['description']) ?>
</h3>

        <p>
            Serves <?= e($recipe['servings']) ?>
        </p>

        <p>
            Prep Time: <?= e($recipe['prep_time']) ?> min
        </p>
        <ol class="recipe-steps">
    <?php foreach ($steps as $step): ?>
        <li>
            <?= e($step['instruction']) ?>
        </li>
    <?php endforeach; ?>
    </0l>
  

    </main>

</body>
</html>