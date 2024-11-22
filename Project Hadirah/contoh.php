<?php 
session_start();  // Start session to manage cart data

// Initialize total cost
$totalCost = 0;

// Database connection (update credentials as needed)
$host = 'localhost'; 
$dbname = 'admin_dashboard';
$username = 'root';
$password = 'Hadirah07_';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Remove item from cart
if (isset($_GET['remove_item'])) {
    $itemIndex = $_GET['remove_item'];
    unset($_SESSION['cart'][$itemIndex]);
    header("Location: " . $_SERVER['PHP_SELF']); // Reload the page after removal
    exit();
}

// Edit item quantity
if (isset($_POST['edit_item_index']) && isset($_POST['new_quantity'])) {
    $itemIndex = $_POST['edit_item_index'];
    $newQuantity = $_POST['new_quantity'];
    $_SESSION['cart'][$itemIndex]['quantity'] = $newQuantity;
    header("Location: " . $_SERVER['PHP_SELF']); // Reload the page after editing
    exit();
}

// Confirm order and save to database
if (isset($_POST['confirm_order'])) {
    if (!empty($_SESSION['cart'])) {
        try {
            // Insert order into database
            $pdo->beginTransaction();

            // Example: Create a new order
            $stmt = $pdo->prepare("INSERT INTO orders (order_date, total_cost) VALUES (NOW(), ?)");
            $stmt->execute([$totalCost]);
            $orderId = $pdo->lastInsertId();

            // Insert each item in the cart into the order_details table
            $stmt = $pdo->prepare("INSERT INTO order_details (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
            foreach ($_SESSION['cart'] as $item) {
                $stmt->execute([$orderId, $item['name'], $item['price'], $item['quantity']]);
            }

            $pdo->commit();

            // Clear the cart
            unset($_SESSION['cart']);

            // Redirect to thank you page
            header("Location: thank_you.php");
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            die("Error saving order: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        /* Basic Styles for Checkout Page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }
        .checkout-container {
            width: 80%;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .checkout-container h2 {
            text-align: center;
        }
        .checkout-items {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }
        .checkout-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .checkout-item h3 {
            font-size: 1.2em;
        }
        .checkout-total {
            font-size: 1.5em;
            text-align: right;
            margin-top: 20px;
        }
        .empty-cart-message {
            text-align: center;
            font-size: 1.2em;
            color: #888;
            margin-top: 20px;
        }
        .button {
            padding: 5px 10px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            margin-right: 5px;
        }
        .button-danger {
            background-color: #dc3545;
        }
        .button-confirm {
            background-color: #28a745;
            color: white;
            text-align: center;
            padding: 10px;
            display: block;
            margin-top: 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="checkout-container">
        <h2>Checkout Summary</h2>

        <!-- Cart Items will be inserted here -->
        <ul class="checkout-items">
            <?php if (empty($_SESSION['cart'])): ?>
                <li class="empty-cart-message">Your cart is empty.</li>
            <?php else: ?>
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                    <li class="checkout-item">
                        <div><?= htmlspecialchars($item['name']) ?></div>
                        <div>RM <?= number_format($item['price'], 2) ?></div>
                        <div>Quantity: <?= $item['quantity'] ?></div>
                        <div>Total: RM <?= number_format($item['price'] * $item['quantity'], 2) ?></div>

                        <!-- Edit and Remove Buttons -->
                        <div>
                            <!-- Edit Button (opens in the same page) -->
                            <form action="" method="post" style="display:inline;">
                                <input type="number" name="new_quantity" value="<?= $item['quantity'] ?>" min="1" required>
                                <input type="hidden" name="edit_item_index" value="<?= $index ?>">
                                <button type="submit" class="button">Edit Quantity</button>
                            </form>
                            
                            <!-- Remove Button (removes from the cart) -->
                            <a href="?remove_item=<?= $index ?>" class="button button-danger" onclick="return confirm('Are you sure you want to remove this item?');">Remove</a>
                        </div>
                    </li>
                    <?php $totalCost += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <!-- Display Total Cost -->
        <div class="checkout-total">
            <p>Total: RM <?= number_format($totalCost, 2) ?></p>
        </div>

        <!-- Confirm Order Form -->
        <form action="" method="post">
            <input type="hidden" name="confirm_order" value="1">
            <button type="submit" class="button-confirm">Confirm Order</button>
        </form>
    </div>

</body>
</html>
