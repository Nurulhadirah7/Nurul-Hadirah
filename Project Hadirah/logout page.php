<?php
session_start(); // Start session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .logout-message {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logout-message h2 {
            color: #333;
        }

        .logout-message a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .logout-message a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="logout-message">
        <h2>You have successfully logged out</h2>
        <a href="http://localhost/Project%20Hadirah/login.admin.php">Return to Login Page</a>
    </div>

    <script>
        // JavaScript for any additional functionality if needed in the future
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Logout page loaded.");
        });
    </script>
</body>
</html>

<?php
session_start(); // Start session

// Check if user is logged in
if (isset($_SESSION['username'])) {
    // Destroy all active sessions
    session_unset(); // Remove all session variables
    session_destroy(); // Destroy the session
    header("Location: logout.php?logout=success"); // Redirect to this page with a message
    exit(); // Stop further execution of the code
} else {
    header("Location: login.admin.php"); // Redirect to login page if no session is active
    exit();
}
?>
