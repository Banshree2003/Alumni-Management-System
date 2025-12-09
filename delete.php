<?php
// Check if form is submitted
if(isset($_POST['delete'])){
    // Get the selected photo to delete
    $photoToDelete = $_POST['photoToDelete'];

    // File path of the photo to delete
    $filePath = "uploads/" . $photoToDelete;

    // Check if file exists
    if(file_exists($filePath)){
        // Delete the file
        if(unlink($filePath)){
            // File deleted successfully
            echo "File ".$photoToDelete." has been deleted successfully.<br>";
        }else{
            // Error deleting file
            echo "Error deleting ".$photoToDelete."<br>";
        }
    }else{
        // File doesn't exist
        echo "File ".$photoToDelete." does not exist.<br>";
    }
}
?>
