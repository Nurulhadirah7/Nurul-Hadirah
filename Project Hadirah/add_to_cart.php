<?php
session_start();

// Simulate adding an item to the cart
if (isset($_POST['name'], $_POST['price'], $_POST['quantity'])) {
    // Fetch item data from form
    $item = [
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'quantity' => $_POST['quantity']
    ];

    // Add item to cart (or update quantity if already in the cart)
    $found = false;
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['name'] === $item['name']) {
            $cartItem['quantity'] += $item['quantity'];
            $found = true;
            break;
        }
    }

    // If item not found, add as a new item
    if (!$found) {
        $_SESSION['cart'][] = $item;
    }

    // Redirect to checkout or previous page
    header('Location: checkout.php');
    exit;
}
