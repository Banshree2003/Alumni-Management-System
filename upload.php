<?php
// Function to get all files from a directory
function getFilesInDirectory($directory) {
    $files = glob($directory . "*");
    return $files;
}

// Directory where uploaded photos are stored
$targetDir = "uploads/";

// Check if the directory exists, if not create it
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true); // Recursive directory creation
}

// Check if files are uploaded
if (!empty($_FILES['fileToUpload']['name'][0])) {
    // Loop through each uploaded file
    foreach ($_FILES['fileToUpload']['tmp_name'] as $key => $tmp_name) {
        $targetFile = $targetDir . basename($_FILES['fileToUpload']['name'][$key]);

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
        } else {
            // Move uploaded file to the target directory
            if (move_uploaded_file($tmp_name, $targetFile)) {
                echo "The file " . basename($_FILES['fileToUpload']['name'][$key]) . " has been uploaded successfully.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
} else {
    echo "<p>No photos uploaded yet.</p>";
}

// Get all files from the directory
$uploadedFiles = getFilesInDirectory($targetDir);

// Check if there are uploaded files
if (!empty($uploadedFiles)) {
    echo "<h2>Admin Gallery</h2>";
    echo "<div class='gallery'>";
    
    // Loop through each uploaded file and display it
    foreach ($uploadedFiles as $file) {
        // Check if the file is an image
        if (exif_imagetype($file)) {
            echo "<div class='image-container'>";
            echo "<img src='$file' alt='Uploaded Image'>";
            // Add a delete button for each image
            echo "<form action='delete.php' method='post'>";
            echo "<input type='hidden' name='photoToDelete' value='" . basename($file) . "'>";
            echo "<button type='submit' name='delete'>Delete</button>";
            echo "</form>";
            echo "</div>";
        }
    }
    
    echo "</div>"; // Close gallery
}
?>

<!-- HTML form for uploading images -->
<h2>Upload Images</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload[]" multiple>
    <button type="submit" name="submit">Upload</button>
</form>
