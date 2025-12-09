

<?php
include_once "connect_database.php"; // Include database connection

// Check if form is submitted
if(isset($_POST['register'])) {
    // Retrieve form data
    $full_name = $_POST['pi_name'];
    list($first_name, $last_name) = explode(" ", $full_name, 2); // Split full name into first and last name
    $gender = $_POST['pi_gender'];
    $registration = $_POST['pi_register'];
    $branch = $_POST['pi_branch'];
    $session = $_POST['pi_session'];
    $email = $_POST['pi_email'];
    $mobile = $_POST['pi_mobile'];
    $password = $_POST['pi_password'];
    
    // Check if any required field is empty
    if (empty($first_name) || empty($last_name) || empty($gender) || empty($registration) || empty($branch) || empty($session) || empty($email) || empty($mobile) || empty($password)) {
        echo "Incomplete information. Please try again.";
        echo "<br/><br/>"; 
        echo "Redirecting you back to the main page in 5 seconds.";
        header("refresh:5;url=index.php");
        exit;
    }

    // Sanitize inputs
    $first_name = mysqli_real_escape_string($conn, $first_name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $gender = mysqli_real_escape_string($conn, $gender);
    $registration = mysqli_real_escape_string($conn, $registration);
    $branch = mysqli_real_escape_string($conn, $branch);
    $session = mysqli_real_escape_string($conn, $session);
    $email = mysqli_real_escape_string($conn, $email);
    $mobile = mysqli_real_escape_string($conn, $mobile);
    $password = mysqli_real_escape_string($conn, $password);

    // Insert data into the database
    $al_status = "Not Approve";
    $register_sql = "INSERT INTO alumnimember (pi_register, al_password, al_status) VALUES ('$registration', '$password', '$al_status')";

    if ($conn->query($register_sql) === TRUE) {
        $register_sql = "INSERT INTO alumniinfo (pi_name, last_name, pi_gender, pi_register, pi_branch, pi_session, pi_email, pi_mobile) VALUES ('$first_name', '$last_name', '$gender', '$registration', '$branch', '$session', '$email', '$mobile')";
        if ($conn->query($register_sql) === TRUE) {
            echo "Registration successful. ";
            echo "<br/><br/>"; 
            echo "Redirecting you to the login page in 5 seconds.";
            header("refresh:5;url=login.html" );
            exit;
        } else {
            echo "Error: " . $register_sql . "<br>" . $conn->error;
            header("refresh:10;url=register.html" );
            exit;
        }
    } else {
        echo "Error: " . $register_sql . "<br>" . $conn->error;
        header("refresh:10;url=register.html" );
        exit;
    }
}
?> 
