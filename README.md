# UXID241-kav77 Cookbook

## About the Project

Build a server-side web application — an online cookbook — backed by a database: a browsable, searchable recipe library with an auth-gated admin area for adding, editing, and deleting recipes. By creating a database  

## Steps

To run this project locally:

1. Clone or download this repository.
2. Open the project folder in VS Code.
3. Make sure PHP is installed on your computer.
4. Make sure to copy my config.php file so you can fill in all credentials
5. Open a terminal in the project in htdocs
6. Start the PHP development server:

## Recipe Management (CRUD)

Create: Administrators can add new recipes through a form.

Read: Visitors can browse recipes and view individual recipe details.

Update: Administrators can edit existing recipe information.

Delete: Administrators can remove recipes from the database.

All database write operations use prepared statements. Recipe forms include server-side validation, and dynamic output is escaped using htmlspecialchars().

## Authentication and Admin Access

Login system using email and password.

Passwords are stored securely using PHP's password_hash().

Login credentials are verified using password_verify().

PHP sessions protect the admin area.

Anonymous visitors are redirected to the login page when attempting to access protected admin pages.

# Admin account: [Document whether you use a seeded admin account or a registration system. Include the login email and explain how the password is provided without publishing the password.]

Recipe Search

Visitors can search for recipes by title using a search form. The search feature uses a prepared SQL statement with a LIKE parameter to find matching recipes.


## AI USE  

- Chatgpt-5.6sol: (September 30th) asked ai to explain the difference between strict_type 1 and strict_type 0 why declare strict_types=1 could be used. I reviewed the explanation and chose to use strict typing in my index.php.
  
- Chatgpt-5.6sol: (September 30th) trouble shooted my Hello world message since it was appearing twice, The issue ai found was that I had an echo statement right after the strict type and in the html. I decided to keep the      php: hello world in my body of html, because ai said I will have more control over the look of it.

Prepared statement(46)
 //Asked Chatgpt: Why are all my recipe results showing up? Here is my Prepared Statement. $sql = 'SELECT * FROM recipes';
//$result = mysqli_query($conn, $sql); $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC); 
//AI Answer: You have an all list query use. ---

 Ai use(Config line 22):  I kept getting an error that said my user and pass was a fatal error. I pasted in the error to 
 ChatGpt and asked what it meant they said: That error means your PHP code is reaching MySQL, but MySQL is rejecting the username/password in your config file.
 Do you still have a placeholder as a user-name?" So i changed it to root and it worked.-->

  AI use(Index line: 82): Asked ai where i was getting a parse error on line 70:
               Answer: you forgot the php end for each which is needed to close the loop.
               Other things that ai noticed: By doing the same php to list out the actual cards you are duplicating your php, consider deleting
               the one above that doesn't print as cards

     AI use INDEX line50 : ChatGPT helped troubleshoot the e() escaping function
// so it could safely display database values    

AI use(lines: 55/56):  AI use: ChatGPT helped troubleshoot the recipe card foreach loop
and explained how to structure one card for each recipe.!
Next line down from that: AI use: ChatGPT helped troubleshoot the e() escaping function
// so it could safely display database values. 
 
 Index-Admin:79-89: Asked AI why my insert wasn't working. It said the query had no values list and the
   table name was wrong (recipes, not cookbook). I also learned $e->getMessage() needs error_log()
   to actually save the error.

   INdex-Admin: 125-17: AI use: Asked AI to explain how to show error messages. The if checks whether $error or
   $deleteError has text (an empty string counts as false), and only then prints the message in a p class="error">. e() escapes the message with htmlspecialchars before it is displayed.

   Index: Servings and Prep time added because Ai mentioned I forgot it which was causing a bug since it was being called but wasn't on the form.

Edit.php linen55: Explain what to call the field, and why. The edit form has a hidden field named form with the value C. The switch reads that value (or an empty string if it’s missing) and runs the matching case. Here, C means “update this recipe.” This is the same idea as your A for add and B for delete on the index page. 

Search.php: Asked Ai to help debug: Why are all my recipe results showing up? Here is my Prepared Statement. $sql = 'SELECT * FROM recipes';
//$result = mysqli_query($conn, $sql); $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC); 
//AI Answer: You have an all list query use.

Register.php ai use:  //AI use: $email = trim($_POST 'email' ?? ''); I used ai to figure out why I was getting an error from
        //$email = post_value('email'); and it was because my php didn't recognize post_value, changed POST_VALUE to $POSTit to

        Config: <!-- Ai use: I kept getting an error that said my user and pass was a fatal error. I pasted in the error to 
 ChatGpt and asked what it meant they said: That error means your PHP code is reaching MySQL, but MySQL is rejecting the username/password in your config file.
 Do you still have a placeholder as a user-name?" So i changed it to root and it worked.-->