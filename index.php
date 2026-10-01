<?php 
declare(strict_types=1);

// AI Use, I used AI to ask a question about what strict_type to use or snake_case.
//  Here are my prompts: I'm working in PHP and starting my index file, for declaring the strict-type what is better? Would it be 1 or 3? How are each strict-type different?What would Snake case be used for?
//  AI ANSWER: Strict type=1 Strict typing on — PHP enforces scalar parameter and return types more strictly. Using strict_types=1 is a good choice when you're learning PHP because it makes type-related mistakes easier to catch rather than having PHP silently convert values for you. (KV- now I know that I want to use this because it will declare any errors and strict type 0 wouldn't make sense in this case. )
// SNAKE CASE ANSWER: "In PHP projects, you'll commonly encounter snake_case for things like database columns, configuration values, array keys, and sometimes variables, depending on the project's coding style." 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID-241-kav77 Cookbook</title>
</head>
<body>
<p>
    <?php echo "Hello World!!"; ?>
</p>
<!-- Asked Ai why it was saying hello world twice, i pasted in my echo statement in the beginning of the php, and then i also put in the one in my html. 
 The answer I got was that both work but I will be able to have more control over the output, and other adjustments if I use the echo statement in the html. 
 So I decided to remove the echo "hello world!" after declaring the strict types. -->
</body>
</html>
