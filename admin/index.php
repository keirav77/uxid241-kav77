<?php
declare(strict_types=1);

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../require_login.php';


/*Asked ai how to fix an error after submitting form saying post value wasn't working */
function post_value(string $key): string {
    return isset($_POST[$key]) && is_string($_POST[$key])
        ? trim($_POST[$key])
        : '';
}
if (!isset($_SESSION['user_id'])) {
  header('Location: ../login.php');
  exit;
}
$result = mysqli_execute_query(
    $conn,'SELECT email FROM users WHERE id = ?',
    [$_SESSION['user_id']]
);
$user = mysqli_fetch_assoc($result);


$error = '';
$deleteError = '';

$categories = mysqli_fetch_all(
    mysqli_query($conn, 'SELECT category_id, category_name FROM categories ORDER BY category_name'),
    MYSQLI_ASSOC
);

if ($_SERVER['REQUEST_METHOD']=== 'POST'){
        $addedTitle = post_value('added-title');
        $addedSubtitle = post_value('added-subtitle');
        $addedDescription = post_value('added-description');
        $addedCategory = post_value('added-category');
        $addedServings = post_value('added-servings');
        $addedPrepTime = post_value('added-prep-time');
        $addedImage = post_value('added-image');
        $deleteId = post_value('delete-id');
  
     /*Asked AI for line 38 if I had enough server side validation for the forms
     Answer: your insert acceps whatever is submitted add this to protect submissions */  
switch ($_POST['form']?? '') {
case "A":
if ($addedTitle === '') {
    $error = 'Please enter a title.';
} elseif (!ctype_digit($addedCategory) || (int)$addedCategory < 1) {
    $error = 'Please choose a valid category.';
} elseif (!ctype_digit($addedServings) || (int)$addedServings < 1) {
    $error = 'Servings must be a positive number.';
} elseif (!ctype_digit($addedPrepTime)) {
    $error = 'Prep time must be a nonnegative number.';
}

if($error === ''){
try{
    mysqli_execute_query($conn, 'INSERT INTO recipes 
      (title, subtitle, description, category_id, servings, prep_time, image)
    VALUES (?, ?, ?, ?, ?, ?, ?)',
   [$addedTitle, $addedSubtitle, $addedDescription, $addedCategory,$addedServings,$addedPrepTime,$addedImage
    ] );
    $error='Your Recipe has been submitted';
    }
        catch (mysqli_sql_exception $e){
            $error= ($e->getMessage());
        }
    }
break;
/* AI use: Asked AI why my insert wasn't working. It said the query had no values list and the
   table name was wrong (recipes, not cookbook). I also learned $e->getMessage() needs error_log()
   to actually save the error. */
         case "B":
               if (!ctype_digit($deleteId) || (int)$deleteId < 1) {
        $deleteError = 'Invalid recipe ID.';
    }

    if ($deleteError === '') {
        try {
            mysqli_execute_query(
                $conn,
                'DELETE FROM recipes WHERE id = ?',
                [$deleteId]
            );
        }
        catch (mysqli_sql_exception $e) {
            $deleteError = 'There was an error with your deletion.';
            error_log($e->getMessage());
        }
    }

    default:
        echo "Something is broken.";
        break;
}
}
      
$sql = 'SELECT r.id, r.title, r.subtitle, r.description, r.servings, r.prep_time, r.image, c.category_name
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
<form action="../search.php" method="GET">
    <label for="search_recipe">Search for a Recipe here:</label>

    <input type="text" id="search_recipe" name="search_recipe">

    <button type="submit">Search Recipes</button>
</form>

<h2>Admin: Add a Recipe </h2>
<!--AI use: Asked AI to explain how to show error messages. The if checks whether $error or
   $deleteError has text (an empty string counts as false), and only then prints the message in a
   <p class="error">. e() escapes the message with htmlspecialchars before it is displayed. */ ?> !-->
<?php if ($error): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>
<?php if ($deleteError): ?>
    <p class="error"><?= e($deleteError) ?></p>
<?php endif; ?>
<form method="POST">
    <input type="hidden" name="form" value="A">

 <label for="added-title">Title</label>
    <input type="text" id="added-title" name="added-title" required>

    <label for="added-subtitle">Subtitle</label>
    <input type="text" id="added-subtitle" name="added-subtitle">

    <label for="added-description">Description</label>
    <textarea id="added-description" name="added-description" rows="4"></textarea>

<!--Asked ai to help me debug positive number servings error it told me i forgot to add it along with prep time !-->
<label for="added-servings">Servings</label>
<input
    type="number"
    id="added-servings"
    name="added-servings"
    min="1"
    required
>
<label for="added-prep-time">Prep time in minutes</label>
<input
    type="number"
    id="added-prep-time"
    name="added-prep-time"
    min="0"
    required
>



    <label for="added-category">Category</label>
    <select id="added-category" name="added-category" required>

        <option value="">Choose...</option>
        <!-- AI use: Asked what the category foreach does. It makes an option for every category in my
   database, so I don't type them by hand. I learned the value is the id that gets saved, and 'selected'
   keeps the choice after a validation error.!-->
        <?php foreach ($categories as $cat): ?>
            <option value="<?= e((string)$cat['category_id']) ?>">
                <?= e($cat['category_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Add Recipe</button>
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

<h2>All Recipes</h2>
<!-- AI use: ChatGPT helped troubleshoot the recipe card foreach loop
// and explained how to structure one card for each recipe.!-->
<section class="recipe-grid">
<?php foreach ($recipes as $recipe): ?>
    <article class="recipe-card">
<form method="POST">
    <input type="hidden" name="form" value="B">
    <input type="hidden" name="delete-id"
           value="<?= e((string)$recipe['id']) ?>">
    <button type="submit">Delete Recipe</button>
</form>
<?php if (!empty($recipe['image'])): ?>
        <img class="recipe-image"
     src="../<?=e($recipe['image']) ?>"
     alt="<?= e($recipe['title']) ?>">
<?php endif; ?>

<!-- AI use: ChatGPT helped troubleshoot the e() escaping function
// so it could safely display database values. !-->
        

        <!--AI USE PHOTO INLINE: Asked what to do when I don't want the blue question mark there, 
        Ai said: Wrap the image class section in a if empty so I can get the function and ignore it if theres nothing !-->
        
<!-- Recipe info to put smaller information in it !-->
 <div class="recipe-info"> 
    <!--Edit Recipe!-->
    <div class="recipe-actions">
<a class="edit-button" href="edit.php?id=<?= e((string)$recipe['id']) ?>">
   <img src="../uploads/images/pen.svg" alt="Pencil icon">
</a>
</div>
   <p class="category">
    <?= e($recipe['category_name']) ?></p> 
 <h3><?= e($recipe['title']) ?> </h3>  
 <p class="subtitle"><?= e($recipe['subtitle']) ?></p>     
    <p class= "description"><?= e($recipe['description']) ?></p>
           
     <div class="recipe-details">
        <span>
           Serves <?= e($recipe['servings']) ?> 
        </span>
     <a class="recipe-button"
                   href="../recipe.php?id=<?= e((string)$recipe['id']) ?>">
                    View Recipe
                </a>
            </div>  
        </div>
       <!--Ai: How do i add the images as files:!-->
     
       <!--Prompt: Hello, may you assist me in learning how to code in photos for my php project as inline folder location names inside of php my admin, instead of hard coding it into vs code. 
       AI: 
       Tips: Make sure image varcar length is 255 and allows null!-->




              <!-- AI use: Asked ai where i was getting a parse error on line 70:
               Answer: you forgot the php end for each which is needed to close the loop.
               Other things that ai noticed: By doing the same php to list out the actual cards you are duplicating your php, consider deleting 
               the one above that doesn't print as cards. !-->
        </article>
    <?php endforeach; ?>
    </section>
      

    <h2>Welcome!</h2>

    <p>You are logged in as <?= e($user['email']) ?>.</p>

    <a href="logout.php">Log Out</a>
</main>
<footer>
    <h2>Credits</h2>
    <h3>Attributions</h3>
    <p>Pencil Icon: Pen by novani from <a href="https://thenounproject.com/browse/icons/term/pen/" target="_blank" title="Pen Icons">Noun Project</a> (CC BY 3.0) </p>
</body>
</html>