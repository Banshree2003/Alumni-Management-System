<?php
session_start();
// Check if the admin is not logged in
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to the login page
    header("Location: admin_loginpage.php");
    exit;
}

// Check if the logged-in admin is the correct admin
if ($_SESSION["admin_email"] !== "admin@gmail.com") {
    // If not, redirect to the login page
    header("Location: admin_homepage.php");
    exit;
}
?>
