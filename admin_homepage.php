<?php 
include_once "auth.php"; ?>
<?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Homepage</title>

<link rel="stylesheet" href="css/header_navigationbar.css" />
</head>
<style>
table, th, td {
    border: 2px solid #050119;
    border-collapse: collapse;
	font-size: 20px;
	width : 900px;
	text-align: center;
}
</style>
<?php
include'setting/adminpage_navigation.php';
?>
<?php
// Connect to the database
include_once "connect_database.php"; // Include your database connection file

// Query to get total alumni count
$sql_total_alumni = "SELECT COUNT(*) AS total_alumni FROM alumniinfo";
$result_total_alumni = $conn->query($sql_total_alumni);
$row_total_alumni = $result_total_alumni->fetch_assoc();
$total_alumni = $row_total_alumni['total_alumni'];

// Query to get upcoming events
$sql_upcoming_events = "SELECT * FROM event WHERE e_date >= CURDATE() ORDER BY e_date LIMIT 5"; // Assuming 'events' table contains upcoming events
$result_upcoming_events = $conn->query($sql_upcoming_events);
// Query to get latest 5 feedback entries
$sql_latest_feedback = "SELECT * FROM feedback ORDER BY submitted_at DESC LIMIT 5"; // Adjust 'timestamp' to your actual column name
$result_latest_feedback = $conn->query($sql_latest_feedback);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
     <style>
        /* CSS styles for overview cards */
        .overview-card {
            background-color: #f3f3f3;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .overview-card h3 {
            margin-top: 0;
        }
        
        .overview-card p, .overview-card ul {
            margin-bottom: 0;
        }
        
        .overview-card ul li {
            list-style-type: none;
            padding: 5px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Admin Dashboard</h1>
        <!-- Navigation menu and other header content -->
    </header>

    <main>
        <section id="dashboard-overview">
            <h2>Dashboard Overview</h2>
            <div class="overview-card">
                <h3>Total Alumni</h3>
                <p><?php echo $total_alumni; ?></p>
            </div>
            <div class="overview-card">
                <h3>Upcoming Events</h3>
                <ul>
                    <?php
                    while ($row = $result_upcoming_events->fetch_assoc()) {
                        echo "<li>" . $row['e_name'] . " - " . $row['e_date'] . "</li>"; // Assuming 'event_name' and 'date' fields contain event details
                    }
                    ?>
                </ul>
            </div>
            <div class="overview-card">
                <h3>Latest Feedback</h3>
                <ul>
                    <?php
                    while ($row = $result_latest_feedback->fetch_assoc()) {
                        echo "<li><strong>From:</strong> " . $row['name'] . ", <strong>Email:</strong> " . $row['email'] . "</li>";
                        echo "<li><strong>Category:</strong> " . $row['category'] . "</li>";
                        echo "<li><strong>Message:</strong> " . $row['message'] . "</li>";
                        echo "<li><strong>Suggestions:</strong> " . $row['suggestions'] . "</li>";
                        echo "<hr>"; // Add a horizontal line between feedback entries
                    }
                    ?>
                </ul>
            </div>
        </section>
    </main>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>

</html>
