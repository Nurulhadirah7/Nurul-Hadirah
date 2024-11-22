<?php 
session_start();

// Optional: Prevent direct access without completing an order
if (!isset($_SESSION['order_complete'])) {
    header("Location: proceed_payment.php"); // Redirect to home page or appropriate page
    exit();
}

// Clear session flag after use
unset($_SESSION['order_complete']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .thank-you-container {
            text-align: center;
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
            color: #555;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <h1>Thank You!</h1>
        <p>Your order has been successfully placed.</p>
        <p>We appreciate your business and hope you enjoy your purchase!</p>
        <a href="proceed_payment.php" class="button">Continue Shopping</a>
    </div>
</body>
</html>
