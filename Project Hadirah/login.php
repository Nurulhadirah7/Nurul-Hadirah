<?php
// Start session
session_start();

$host = 'localhost';
$dbname = 'admin_dashboard';
$username = 'root';
$password = 'Hadirah07_';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get user data from the database
    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password matches, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "Login successful!";
            // Redirect to another page
            header('Location: menu.php');
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Username not found!";
    }
}
$conn->close();
?>
