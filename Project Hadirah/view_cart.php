<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view the cart.");
}

// Connect to MySQL
$conn = new mysqli('localhost', 'root', '', 'admin_dashboard');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Retrieve cart items for the logged-in user
$sql = "SELECT * FROM cart WHERE user_id = '$user_id'";
$result = $conn->query($sql);

$items = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

// Output the items as JSON for the front-end JavaScript to use
echo json_encode($items);

$conn->close();
?>
