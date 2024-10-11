<?php
session_start(); // Start the session at the beginning of the script

// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "hostel_booking";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
}
    //die("Connection failed: " . $conn->connect_error);

// Login user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows>0) {
     $user = $result->fetch_assoc();
    
    
        // Verify password
        if ($user['password']==$password) {
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Redirect to dashboard
            header("Location: Homepage.html");
            exit(); // Ensure no further code is executed after redirect
        } else {
            echo "Invalid password.";
           
        }
    } else {
        echo "Invalid user, user doesn't exist";
       
    }

}

?>
