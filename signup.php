<?php
// Database connection
$servername = "localhost"; // Change this to your MySQL server hostname
$username = "root"; 
$password = ""; 
$dbname = "hostel_booking"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username=$_POST['username'];
    $password=$_POST['password'];
    $email=$_POST['email'];
    
    $check_query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    
    if ($result->num_rows > 0) {
        echo "User with the same username or email already exists.";
    } else {
        
        $insert_query = "INSERT INTO users (username, password, email) VALUES ('$username','$password','$email')";
        $result=$conn->query($insert_query);
        
        if ($result) {
            echo "Signup successful!";
            header("Location: login.html"); 
            exit(); 
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
   
 
}

// Close connection

?>
