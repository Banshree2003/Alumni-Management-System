<?php
// Include database connection
include_once "connect_database.php";

function generateAnnouncementID() {
    // Generate a random string
    $randomString = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);

    // Append timestamp to the random string
    $timestamp = time();
    $announcementID = 'ANN_' . $randomString . '_' . $timestamp;

    return $announcementID;
}

if(isset($_POST['add_announcement'])) {
    // Retrieve announcement details from the form
    $ann_name = $_POST['ann_name'];
    $ann_desc = $_POST['ann_desc'];

    // Validate input (you can add more validation as needed)
    if(empty($ann_name) || empty($ann_desc)) {
        $error = "All fields are required.";
    } else {
        // Connect to your database
        include_once "connect_database.php";

        // Generate unique announcement ID
        $ann_id = generateAnnouncementID();

        // Prepare and execute the SQL query to insert announcement
        $stmt = $conn->prepare("INSERT INTO announcement (ann_id, ann_name, ann_desc, ann_time) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $ann_id, $ann_name, $ann_desc);
        if($stmt->execute()) {
            // Close prepared statement and database connection
            $stmt->close();
            $conn->close();

            // Redirect to the announcement page
            header("Location: announcement.php");
            exit();
        } else {
            $error = "Failed to add announcement.";
        }
    }
}
?>

<!DOCTYPE html> 
<html>
<head>
    <title>Add Announcement</title>
</head>
<body>
    <?php if(isset($error)) echo "<p>$error</p>"; ?>
    <form action="" method="post">
        <table width="850" align="center" style="border:2px hidden;" cellspacing="10">
            <tr>
                <th align="left" width="6000" style="border:hidden;font-size:25px"> Details of the announcement:</th>
                <td></td>
            </tr>
            <tr>
                <th align="left" width="300" style="border:hidden;font-size:18px">Announcement Name:</th>
                <td width="350" style="border:hidden"><input type="text" value="" name="ann_name" size="59" /></td>
            </tr>
            <tr>
                <th align="left"  width="300" style="border:hidden;font-size:18px">Announcement Description: </label></th>
                <td width="350" style="border:hidden"><textarea name="ann_desc" cols="60" rows="6" size="60"></textarea></td>
            </tr>
            <tr>
                <td colspan=2 align="right" style="border:hidden"><button class="bt1" type="submit" name="add_announcement" >Add Announcement</button></td>
            </tr>
        </table>
    </form>
</body>
</html>
