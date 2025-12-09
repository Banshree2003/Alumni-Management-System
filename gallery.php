<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>About Us</title>
<link rel="stylesheet" href="css/about_us.css" />

<?php
include_once"setting/gallery_navigation.php";
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }
    .gallery {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 20px;
    }
    .gallery-item {
        margin: 10px;
        text-align: center;
    }
    .gallery img {
        width: 300px;
        height: 200px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .description {
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 10px;
        border-radius: 5px;
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-item:hover .description {
        opacity: 1;
    }
</style>

</head>
<body>
    <div class="gallery">
        <?php
        $files = glob('uploads/*');
        foreach ($files as $file) {
            if (basename($file) === 'descriptions.txt') {
                continue; // Skip the descriptions.txt file
            }
            $filename = basename($file);
            echo "<div class='gallery-item'>";
            echo "<img src='$file' alt='$filename'>";
            // Read description from the descriptions.txt file
            $descriptionFile = 'uploads/descriptions.txt';
            if (file_exists($descriptionFile)) {
                $lines = file($descriptionFile, FILE_IGNORE_NEW_LINES);
                foreach ($lines as $line) {
                    list($image, $description) = explode(':', $line, 2);
                    if ($image === $filename) {
                        echo "<p class='description'>$description</p>";
                        break; // Stop searching once description is found
                    }
                }
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
