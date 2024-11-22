<?php
session_start();  // Start the session to manage cart items across pages

// Database connection
$servername = "localhost";
$username = "root";
$password = "Hadirah07_";
$dbname = "admin_dashboard"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch menu items from the database
$sql = "SELECT id, name, price, description, image_url FROM menu_items";
$result = $conn->query($sql);

$menu_items = [];
if ($result->num_rows > 0) {
    // Store each menu item in an array
    while ($row = $result->fetch_assoc()) {
        $menu_items[] = $row;
    }
}

// Handle cart item addition (store in session and database)
if (isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $user_id = 1;  // Replace with actual user ID (if implementing a login system)

    // Fetch item name and price from menu_items table
    $query = "SELECT name, price FROM menu_items WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $stmt->bind_result($item_name, $price);
    $stmt->fetch();
    $stmt->close();

    // Add item to session cart
    $_SESSION['cart'][] = [
        'name' => $item_name,
        'price' => $price,
        'quantity' => $quantity
    ];

    // Insert cart item into the database
    $stmt = $conn->prepare("INSERT INTO cart (user_id, item_name, price, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isdi", $user_id, $item_name, $price, $quantity);

    if ($stmt->execute()) {
        echo "<script>alert('Item added to cart!');</script>";  // Alert message
    } else {
        echo "<script>alert('Error adding item to cart: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Menu</title>
    <link rel="stylesheet" href="styless.css"> <!-- Your CSS file -->
    <script src="Order Menu.js" defer></script> <!-- Your JS file -->
    <style>
/* General Reset */
body, h1, h2, p, ul, li, a, button, input {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #333;
    color: #fff;
    line-height: 1.6;
    display: flex; /* Center everything horizontally and vertically */
    justify-content: center;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

/* Container for the menu */
.menu-container {
    width: 90%;
    max-width: 1200px;
    margin: auto;
    text-align: center;
}

/* Header Styles */
header {
    margin-bottom: 30px;
}

header h1 {
    font-size: 2.5rem;
    color: #fff;
}

header p {
    font-size: 1rem;
    color: #aaa;
}

/* Menu Grid */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    justify-content: center;
}

.menu-item {
    background-color: #444;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.menu-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
}

.menu-item img {
    width: 200px; /* Medium image size */
    height: 200px;
    object-fit: cover; /* Maintain aspect ratio */
    border-radius: 8px;
    margin-bottom: 15px;
}

.menu-item h2 {
    font-size: 1.5rem;
    color: #f1f1f1;
    margin-bottom: 10px;
}

.menu-item p {
    font-size: 1rem;
    color: #ccc;
    margin-bottom: 10px;
}

/* Add to Cart Form */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

form input[type="number"] {
    width: 60px;
    padding: 5px;
    margin-bottom: 10px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
}

form button {
    background-color: #f90;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #e68000;
}

/* Checkout Button */
.checkout-button {
    display: inline-block;
    margin: 30px auto;
    padding: 10px 30px;
    background-color: #e63946;
    color: #fff;
    text-align: center;
    text-decoration: none;
    font-size: 1.2rem;
    border-radius: 4px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.checkout-button:hover {
    background-color: #d62839;
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
}

</style>
</head>
<body>
<!-- Product List -->
<ul id="product-list">
    <div class="menu-grid">
        <div class="menu-container">
            <header>
                <h1>Coffee Menu</h1>
                <p>All Drinks Are In Medium Cup.</p>
            </header>

            <div class="menu-grid">
                <?php foreach ($menu_items as $item): ?>
                <div class="menu-item">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <h2><?= htmlspecialchars($item['name']) ?></h2>
                    <p>RM <?= number_format($item['price'], 2) ?></p>
                    <p><?= htmlspecialchars($item['description']) ?></p>
                    <!-- Add to Cart Button -->
                    <form method="POST" action="">
                        <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</ul>

<!-- Button to Navigate to Checkout -->
<a href="contoh.php" id="go-to-checkout" class="checkout-button">Go to Checkout</a>

</body>
</html>
