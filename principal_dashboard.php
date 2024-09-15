<?php
session_start();

// Database connection
$servername = "localhost";  // If you're using XAMPP/WAMP locally
$username = "root";         // Default MySQL username for XAMPP/WAMP
$password = "";             // Leave blank if using default setup in XAMPP/WAMP
$dbname = "school";      // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check username and password
    $sql = "SELECT id FROM principals WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful
        $_SESSION['principal_id'] = $result->fetch_assoc()['id'];  // Store user ID in session
        header("Location: dashboard.php");  // Redirect to dashboard
        exit;
    } else {
        echo "Invalid username or password!";
    }
}

$conn->close();
?>
