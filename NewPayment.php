<?php
session_start();
include_once "connect_database.php"; // Include your database connection script

// Check if the form is submitted
if(isset($_POST['addpayment'])) {
    // Retrieve form data
    $payment_purpose = $_POST['payment_purpose'];
    $payment_date = $_POST['payment_date'];
    $total_payment = $_POST['total_payment'];
    $pi_register = $_POST['pi_register'];
    
    // Validate form data
    if (empty($payment_purpose) || empty($payment_date) || empty($total_payment) || empty($pi_register)) {
        $error_message = "Please fill in all fields.";
    } elseif (strtotime($payment_date) < strtotime(date("Y-m-d"))) {
        $error_message = "Payment date cannot be in the past.";
    } else {
        // Generate payment ID automatically (example: current timestamp)
        $payment_id = time(); // You can use any method to generate a unique ID
        
        // Insert the new payment into the database
        $sql = "INSERT INTO financialdata (payment_id, total_payment, payment_purpose, pi_register, payment_date) 
                VALUES ('$payment_id', '$total_payment', '$payment_purpose', '$pi_register', '$payment_date')";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Payment successfully added.";
            header("Location: Financial_Record.php"); // Redirect to financial data page
            exit();
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Payment Entry</title>
    <!-- Add your CSS stylesheets here -->
</head>
<body>
    <center>
    <h2>New Payment Entry</h2></center>
    <?php if(isset($error_message)) { ?>
        <div style="color: red;"><?php echo $error_message; ?></div>
    <?php } ?>
    <?php if(isset($_SESSION['success_message'])) { ?>
        <div style="color: green;"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php } ?>
    <form action="" method="post">
    <table width="850" align="center" style="border:2px hidden;" cellspacing="10">
    <tr>
        <th align="left" width="6000" style="border:hidden;font-size:18px">Payment Purpose:</th>
        <td width="350" style="border:hidden"><input size="59" type="text" value="" name="payment_purpose"/></td>
    </tr>
    <tr>
        <th align="left" width="6000" style="border:hidden;font-size:18px">Payment Date</th>
        <td width="350" style="border:hidden"><input size="59" type="date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" name="payment_date"/></td>
    </tr>
    <tr>
        <th align="left" width="6000" style="border:hidden;font-size:18px">Total Payment :</th>
        <td width="350" style="border:hidden"><input size="59" type="number" value="" name="total_payment"/></td>
    </tr>
    <tr>
        <th align="left" width="6000" style="border:hidden;font-size:18px">Alumni Registration Number:</th>
        <td width="350" style="border:hidden"><input size="59" type="text" value="" name="pi_register"/></td>
    </tr>
    <tr>
        <td colspan=2 align="right" style="border:hidden"><button class="bt1" type="submit" name="addpayment" value="Add Payment">Add Payment</button></td>
    </tr>
    </table>
    </form>
</body>
</html>
