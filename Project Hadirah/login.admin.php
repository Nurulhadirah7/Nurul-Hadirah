<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Styling for the login container */
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        /* Styling for the title */
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        /* Styling for the form groups (input fields) */
        .form-group {
            margin-bottom: 15px;
        }

        /* Styling for the labels */
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        /* Styling for the input fields */
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
        }

        /* Add focus effect to input fields */
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }

        /* Styling for the submit button */
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Button hover effect */
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login to Admin Dashboard</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if inputs are empty
    if (empty($username) || empty($password)) {
        header("Location: error.html");
        exit();
    }

    // Database connection
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "Hadirah07_";
    $dbname = "admin_dashboard";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validate login authentication using prepared statements
    $query = "SELECT * FROM login WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Preparation failed: " . $conn->error); // Add this for better debugging
    }
    
     // Validate login authentication using prepared statements
     $query = "SELECT * FROM login WHERE username = ?";
     $stmt = $conn->prepare($query);
     $stmt->bind_param("s", $username);
     $stmt->execute();
     $result = $stmt->get_result();
 
     if ($result->num_rows === 1) {
         $user = $result->fetch_assoc();
 
         // Use password_verify if passwords are hashed
         if ($password === $user['password']) { // Replace with `password_verify` for hashed passwords
             // Set session variables
             $_SESSION['username'] = $username;
             header("Location: admin order.php");
             exit();
         }
     }
 
     // Login failed
     header("Location: error.html");
     exit();
 }
 ?>