<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Homepage</title>

<link rel="stylesheet" href="css/header_navigationbar.css" />
</head>
<?php
include'setting/adminpage_navigation.php';
?>
    <style>
        /* Add your CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            max-height: 100px;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }
    </style>
</head>
<body>
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
                // Save description if provided
                if (!empty($_POST['description'][$key])) {
                    $description = $_POST['description'][$key];
                    $descriptionFile = $targetDir . "descriptions.txt";
                    file_put_contents($descriptionFile, basename($targetFile) . ': ' . $description . PHP_EOL, FILE_APPEND | LOCK_EX);
                }
                echo "The file " . basename($_FILES['fileToUpload']['name'][$key]) . " has been uploaded successfully.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
} else {
    echo "<p>No photos uploaded yet.</p>";
}

// Check if the delete button is clicked
if (isset($_POST['delete']) && isset($_POST['photoToDelete'])) {
    $photoToDelete = $_POST['photoToDelete'];
    $filePath = $targetDir . $photoToDelete;
    $descriptionFile = $targetDir . "descriptions.txt";

    // Delete the photo and its description file if they exist
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    // Remove the description from descriptions.txt
    if (file_exists($descriptionFile)) {
        $lines = file($descriptionFile);
        $output = '';
        foreach ($lines as $line) {
            if (strpos($line, $photoToDelete) === false) {
                $output .= $line;
            }
        }
        file_put_contents($descriptionFile, $output);
    }
    // Redirect to refresh the page
    header("Location: admin_gallery.php");
    exit;
}

// Get all files from the directory
$uploadedFiles = getFilesInDirectory($targetDir);

// Check if there are uploaded files
if (!empty($uploadedFiles)) {
    echo "<h2>Admin Gallery</h2>";
    echo "<table>";
    echo "<tr><th>Image</th><th>Description</th><th>Action</th></tr>";
    
    // Loop through each uploaded file and display it in a table row
foreach ($uploadedFiles as $file) {
    // Check if the file exists and is readable
    if (file_exists($file) && is_readable($file)) {
        // Check if the file is an image
        if (exif_imagetype($file)) {
            // Get description from descriptions.txt if available
            $description = "";
            $descriptionFile = $targetDir . "descriptions.txt";
            if (file_exists($descriptionFile) && is_readable($descriptionFile)) {
                $lines = file($descriptionFile);
                foreach ($lines as $line) {
                    $parts = explode(':', $line);
                    if (trim($parts[0]) === basename($file)) {
                        $description = trim($parts[1]);
                        break;
                    }
                }
            }
            
            echo "<tr>";
            echo "<td><img src='$file' alt='Uploaded Image'></td>";
            echo "<td>$description</td>";
            echo "<td>";
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='photoToDelete' value='" . basename($file) . "'>";
            echo "<button type='submit' name='delete' class='delete-btn'>Delete</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    }
}

    
    echo "</table>"; // Close table
}
?>

<!-- HTML form for uploading images -->
<h2>Upload Images</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload[]" multiple>
    <label for="description">Description:</label>
    <input type="text" name="description[]" id="description">
    <button type="submit" name="submit">Upload</button>
</form>
</body>
</html>
