<?php
session_start();
include_once "connect_database.php";

if(isset($_POST['amount'], $_POST['description'])) {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $pi_register = $_SESSION['pi_register']; // Assuming you have this session variable
    
    // Assuming you have a table named 'payments' with the mentioned columns
    $sql = "INSERT INTO payments (payment_id, total_payment, payment_purpose, pi_register, payment_date) 
            VALUES (NULL, '$amount', '$description', '$pi_register', CURDATE())";
            
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Payment added successfully.";
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: financial_record.php");
    exit();
} else {
    $_SESSION['error_message'] = "Please fill in all fields.";
    header("Location: add_payment.php");
    exit();
}
?>
