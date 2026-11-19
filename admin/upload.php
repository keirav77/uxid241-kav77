<?php
declare(strict_types=1);

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../require_login.php';

$folder = __DIR__ . '/../form-uploads';
$recipe_id = (int) ($_GET['id'] ?? $_POST['recipe_id'] ?? 0);

$message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $file = $_FILES['photo'];

    try {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Upload failed.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];

        if (!isset($allowed[$mime]) || $file['size'] > 2 * 1024 * 1024) {
            throw new RuntimeException('Invalid image or file too large.');
        }

        $saved = uniqid('upload-') . '.' . $allowed[$mime];

        if (!move_uploaded_file($file['tmp_name'], $folder . '/' . $saved)) {
            throw new RuntimeException('Upload failed.');
        }

        mysqli_execute_query(
            $conn,
            'UPDATE Recipes SET main_image = ? WHERE id = ?',
            [$saved, $recipe_id]
        );

        $message = 'Image uploaded!';

    } catch (RuntimeException $e) {
        $errors[] = $e->getMessage();
    }
}

//AI USE: Help me create a safe readable unique name for the file, I want to make sure that its clean before I approve it to my folders. When writing it out highlight and explain which parts of the code are meeting the 3 requirements of it. The 3 requirements are, make sure it's safe by using pathinfo, make it has a verified extension, and the name is unique.
//This AI use is for Lines: 41-63   
//function make_safe_name(string $original_name, string $ext, string $folder): string{

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File form</title>
</head>
<body>
    <?php if ($message !== ''): ?>
     <p> <?= htmlspecialchars($message) ?> </p>
     <?php endif; ?>   
    <form action="upload.php" method="post"
  enctype="multipart/form-data">
  <input type="file" name="photo">
  <button type="submit">Upload</button>
</form>
<button class="back">
    <a href="index.php">Back</button>
</body>
</html>
<html>
