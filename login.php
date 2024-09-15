<?php
session_start();

// Database connection settings
$servername = "localhost";  // For local setup with XAMPP/WAMP
$dbUsername = "root";       // Default username for MySQL
$dbPassword = "";           // Default password (leave blank for XAMPP/WAMP)
$dbName = "school";         // Your database name

// Create a connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevent SQL injection by escaping user input
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // SQL query to check the credentials
    $sql = "SELECT id FROM principals WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Successful login
        $_SESSION['principal_id'] = $result->fetch_assoc()['id'];  // Store principal ID in session
        header("Location: dashboard.php");  // Redirect to dashboard
        exit;
    } else {
        // Invalid login
        $error = "Invalid username or password!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Directeur</title>
    <style>
        /* Base Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9fb;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container img {
            height: 80px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 30px;
            color: #0072ff;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1em;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #005bb5;
        }

        a {
            display: block;
            margin-top: 15px;
            color: #0072ff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Error message styling */
        .error {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="manarlogo.png" alt="Groupe Scolaire Manar El Khair Logo">
        <h2>Connexion Directeur</h2>
        
        <!-- Display error message if login fails -->
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="POST">
            <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <a href="#">Mot de passe oublié ?</a>
    </div>

</body>
</html>
