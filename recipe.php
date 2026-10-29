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

        <p>
            <?= e($recipe['description']) ?>
        </p>

        <p>
            Serves <?= e($recipe['servings']) ?>
        </p>

        <p>
            Prep Time: <?= e($recipe['prep_time']) ?> min
        </p>

    </main>

</body>
</html>