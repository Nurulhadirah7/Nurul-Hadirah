<?php
session_start();

// Database connection details
$conn = new mysqli('localhost', 'root', 'Hadirah07_', 'your_database_name');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Fetch cart items with product details
$sql = "
    SELECT 
        ci.id, 
        ci.user_id, 
        ci.quantity, 
        p.name AS product_name, 
        p.price
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.user_id='$user_id'";
$result = $conn->query($sql);

$cart_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
}

// Return the cart items as JSON
echo json_encode($cart_items);

$conn->close();
?>
