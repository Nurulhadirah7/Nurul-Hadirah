<?php
// Start the session
session_start();

// Database connection
$host = 'localhost';
$dbname = 'admin_dashboard';
$username = 'root';
$password = 'Hadirah07_';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if user is already logged in
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header('Location: dashboard.php'); // Redirect to dashboard if logged in
    exit();
}

// Utility section: Update password for testing or creating a new admin password
if (isset($_GET['update_password']) && $_GET['update_password'] === 'true') {
    // Hash a new password
    $new_password = 'admin123'; // Change this to the desired new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update the password in the database
    $stmt = $pdo->prepare("UPDATE admins SET password = :password WHERE username = :username");
    $stmt->execute(['password' => $hashed_password, 'username' => 'root']);
    
    echo "Password updated successfully! (New password is: $new_password)<br>";
    // Remove this section after use to avoid unauthorized changes
}

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Query to fetch the admin from the database
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
    $stmt->execute(['username' => $input_username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and verify password
    if ($admin && password_verify($input_password, $admin['password'])) {
        $_SESSION['admin'] = true; // Set session for admin
        header('Location: admin_login.php'); // Redirect to self or dashboard
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            width: 300px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        h2 {
            margin-bottom: 20px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>

        <!-- Display error message if login fails -->
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Login form -->
        <form action="admin_login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

</body>
</html>
