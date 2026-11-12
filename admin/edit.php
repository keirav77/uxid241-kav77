<?php
declare(strict_types=1);

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../require_login.php';

function post_value(string $key): string {
    return isset($_POST[$key]) && is_string($_POST[$key])
        ? trim($_POST[$key])
        : '';
}

if (!isset($_SESSION['user_id'])) {
header('Location: ../login.php');

exit;

}

$id = $_GET['id'] ?? '';
if (!is_numeric($id)) {
    exit('Invalid id.');
}

$result = mysqli_execute_query(
    $conn,
    'SELECT * FROM recipes WHERE id = ?',
    [$id]
);

$recipe = mysqli_fetch_assoc($result);

if (!$recipe) {
    exit('Recipe not found.');
}
$categories = mysqli_fetch_all(
    mysqli_query($conn, 'SELECT category_id, category_name FROM categories ORDER BY category_name'),
    MYSQLI_ASSOC);

$editTitle = (string)$recipe['title'];
$editSubtitle = (string)$recipe['subtitle'];
$editDescription = (string)$recipe['description'];
$editCategory = (string)$recipe['category_id'];
$editServings = (string)$recipe['servings'];
$editPrepTime = (string)$recipe['prep_time'];
$editImage = (string)$recipe['image'];
$error = '';

/*Didn't use ai but just copied conventions from index and changed them to edit instead of added */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$editTitle = post_value('edit-title');
$editSubtitle = post_value('edit-subtitle');
$editDescription = post_value('edit-description');
$editCategory = post_value('edit-category');
$editServings = post_value('edit-servings');
$editPrepTime = post_value('edit-prep-time');
$editImage = post_value('edit-image');
switch ($_POST['form'] ?? '') {
case "C":
    /*The edit form has a hidden field named form with the value C. The switch reads that value (or an empty string if it’s missing) and runs the matching case. Here, C means “update this recipe.” This is the same idea as your A for add and B for delete on the index page. */
if ($editTitle === '') {
$error = 'Please enter a title.';
}
if ($editCategory === '') {
$error = 'Please choose a category.';
}
if (!is_numeric($editServings)) {
$error = 'Servings must be a number.';
}
if (!is_numeric($editPrepTime)) {
$error = 'Prep time must be a number.';
}
/*is numeric checks if it's a number and ! means not */
if ($error === '') {
try {
mysqli_execute_query($conn, 'UPDATE recipes SET title = ?, subtitle = ?, description = ?, category_id = ?, servings = ?, prep_time = ?, image = ? WHERE id = ?',
[$editTitle, $editSubtitle, $editDescription, $editCategory, $editServings, $editPrepTime, $editImage, $id]);
header('Location: index.php');
exit;
}
catch (mysqli_sql_exception $e) {
$error = 'Update Error!';
error_log($e->getMessage());
}
}break;
}
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit recipe</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<header>
      <h1> Keira Vaughan's Cookbook</h1>
      <h2>Admin: Edit Recipe</h2>
      <nav class="account-nav">

    <a href="index.php">Back to Recipes</a>
<a href="logout.php">Log Out</a>
</nav>
</header>
<?php if ($error): ?>
<p class="error"><?= e($error) ?></p>
<?php endif; ?>

<form method="POST">
<input type="hidden" name="form" value="C">

<label for="edit-title">Title</label>
<input type="text" id="edit-title" name="edit-title" value="<?= e($editTitle) ?>">

<label for="edit-subtitle">Subtitle</label>
<input type="text" id="edit-subtitle" name="edit-subtitle" value="<?= e($editSubtitle) ?>">

<label for="edit-description">Description</label>
<textarea id="edit-description" name="edit-description" rows="4"><?= e($editDescription) ?></textarea>

<label for="edit-category">Category</label>
<select id="edit-category" name="edit-category">
<option value="">Choose...</option>

<?php foreach ($categories as $cat): ?>
    <option value="<?= e((string)$cat['category_id']) ?>">
   <?= $editCategory === (string)$cat['category_id'] ? 'selected' : '' ?>
    <?= e($cat['category_name']) ?>
    
</option>
<?php endforeach; ?>
</select>

<label for="edit-servings">Servings</label>
<input type="number" id="edit-servings" name="edit-servings" value="<?= e($editServings) ?>">

<label for="edit-prep-time">Prep time in minutes</label>
<input type="number" id="edit-prep-time" name="edit-prep-time" value="<?= e($editPrepTime) ?>">

<label for="edit-image">Image path</label>
<input type="text" id="edit-image" name="edit-image" value="<?= e($editImage) ?>">

<button type="submit">Save Changes</button>
</form>
</main>

</body>
</html>