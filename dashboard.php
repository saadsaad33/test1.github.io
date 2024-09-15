<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['principal_id'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Principal's Dashboard!</h1>
    <p>You are logged in as the principal.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
