# UXID241-kav77 Cookbook

## About the Project

Build a server-side web application — an online cookbook — backed by a database: a browsable, searchable recipe library with an auth-gated admin area for adding, editing, and deleting recipes. By creating a database  

## Steps

To run this project locally:

1. Clone or download this repository.
2. Open the project folder in VS Code.
3. Make sure PHP is installed on your computer.
4. Open a terminal in the project's root directory.
5. Start the PHP development server:

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