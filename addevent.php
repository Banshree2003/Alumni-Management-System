<?php
session_start(); // Start the session (if not already started)

// Include database connection script
include_once "connect_database.php";

// Function to generate automatic event ID
function generateEventID($conn) {
    // Generate a unique event ID based on current timestamp
    $timestamp = time(); // Current timestamp
    $eventID = 'EVENT_' . $timestamp; // You can adjust this format as needed

    // Check if the generated ID already exists in the database
    $stmt = $conn->prepare("SELECT e_id FROM event WHERE e_id = ?");
    $stmt->bind_param("s", $eventID);
    $stmt->execute();
    $result = $stmt->get_result();

    // If ID already exists, generate a new one recursively
    if ($result->num_rows > 0) {
        return generateEventID($conn); // Recursive call
    } else {
        return $eventID;
    }
}

// Check if the form for adding an event is submitted
if(isset($_POST['addevent'])) {
    // Retrieve event details from the form
    $ENAME = $_POST['eventname'];
    $EDATE = $_POST['eventdate'];
    $ETIME = $_POST['eventtime'];
    $EDESC = $_POST['eventdesc'];
    $EVENUE = $_POST['eventvenue'];

    // Generate automatic event ID
    $EID = generateEventID($conn);

    // Check if the event date is in the future
    if(strtotime($EDATE) < strtotime(date('Y-m-d'))) {
        $error = "Event date cannot be in the past.";
    } else {
        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO event (e_id, e_name, e_date, e_time, e_desc, e_venue) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $EID, $ENAME, $EDATE, $ETIME, $EDESC, $EVENUE);

        if ($stmt->execute()) {
            echo "<p class='p1'>*****Event successfully created.*****</p>";
            echo "<p class='p2'><a href='events.php'>Go to Event</a></p>";

            // Use JavaScript to redirect
            echo "<script>window.location = 'events.php';</script>";
        } else {
            $error = "Failed to add event: " . $stmt->error; // Get specific error message
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html> 
<html>
<head>
    <title>Add Event</title>
</head>
<body>
    <center><h2>Add Event</h2></center>
    <?php if(isset($error)) echo "<p>$error</p>"; ?>
    <form action="" method="post">
        <table width="850" align="center" style="border:2px hidden;" cellspacing="10">
            <tr>
                <th align="left" width="6000" style="border:hidden;font-size:25px"> Details of the event:</th>
                <td></td>
            </tr>
            <tr>
                <th align="left" width="300" style="border:hidden;font-size:18px">Event Name:</th>
                <td width="350" style="border:hidden"><input type="text" value="" name="eventname" size="59" /></td>
            </tr>
            <tr>
                <th align="left"  width="300" style="border:hidden;font-size:18px">Event Date: </label></th>
                <td width="350" style="border:hidden"><input class="i2" type="date" value="" name="eventdate" size="59" min="<?php echo date('Y-m-d');?>" required /></td>
            </tr>
            <tr>
                <th align="left"  width="300" style="border:hidden;font-size:18px">Event Time:</label></th>
                <td width="350" style="border:hidden"><input class="i3" type="time" value="" name="eventtime" size="59" /></td>
            </tr> 
            <tr>
                <th align="left"  width="300" style="border:hidden;font-size:18px">Event Description: </label></th>
                <td width="350" style="border:hidden"><textarea name="eventdesc" cols="60" rows="6" size="60"></textarea></td>
            </tr>
            <tr>
                <th align="left"  width="300" style="border:hidden;font-size:18px">Event Venue: </label></th>
                <td width="350" style="border:hidden"><input type="text" value="" name="eventvenue" size="59" /></td>
            </tr>
            <tr>
                <td colspan=2 align="right" style="border:hidden"><button class="bt1" type="submit" name="addevent" >Add Event</button></td>
            </tr>
        </table>
    </form>
</body>
</html>
