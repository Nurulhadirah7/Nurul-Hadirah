<?php
// Start a session
session_start();

// Database connection
$host = "localhost";
$dbusername = "root";
$dbpassword = "Hadirah07_";
$dbname = "admin_dashboard";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['userName']);
    $phone = trim($_POST['userPhone']);
    $address = trim($_POST['userAddress']);

    // Validate inputs
    if (!empty($name) && !empty($phone) && !empty($address)) {
        // Prepare an SQL statement to insert the order
        $query = "INSERT INTO customer_detail (name, phone, address, status) VALUES (?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $name, $phone, $address);

        // Execute the query
        if ($stmt->execute()) {
            $successMessage = "Order submitted successfully!";
        } else {
            $errorMessage = "Error submitting order: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $errorMessage = "Please fill out all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceed to Payment</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .user-details label {
            font-size: 14px;
            color: #333;
        }
        .user-details input, .user-details textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .user-details textarea {
            resize: vertical;
            height: 100px;
        }
        .payment-options {
            text-align: center;
            margin-top: 20px;
        }
        .payment-options a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            background-color: #25D366;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .payment-options a:hover {
            background-color: #128C7E;
        }
        .qr-code-container {
            text-align: center;
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .qr-code-container h3 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }
        .qr-code-container img {
            width: 200px;
            height: 200px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Order Receipt</h1>

        <!-- Success or Error Message -->
        <?php if (isset($successMessage)) : ?>
            <p style="color: green; text-align: center;"><?php echo $successMessage; ?></p>
        <?php elseif (isset($errorMessage)) : ?>
            <p style="color: red; text-align: center;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <!-- User Details Form -->
        <div class="user-details">
            <h3>Enter Your Details</h3>
            <form id="user-form" method="post">
                <label for="user-name">Name:</label>
                <input name="userName" type="text" id="user-name" placeholder="Your Name" required>

                <label for="user-phone">Phone Number:</label>
                <input name="userPhone" type="tel" id="user-phone" placeholder="Your Phone Number" required>

                <label for="user-address">Address:</label>
                <textarea name="userAddress" id="user-address" placeholder="Your Address" required></textarea>

                <button type="submit" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-size: 16px;">Confirm Order</button>
            </form>
        </div>

        <p style="text-align: center;">Choose a payment method below:</p>
        <div class="payment-options">
            <a href="https://wa.me/0182322906?text=Hi,%20I%20want%20to%20make%20a%20payment" target="_blank">
                Contact us via WhatsApp
            </a>
        </div>

        <div class="qr-code-container">
            <h3>Scan QR Code for Payment</h3>
            <img src="qr-code.jpg" alt="QR Code for Payment">
        </div>

        <div class="footer">
            <p>If you need help, contact us on WhatsApp.</p>
        </div>

        <div class="back-link">
            <a href="Cafe Coffee Pandadoll.php">← Back</a>
        </div>

        <div class="admin-link">
            <a href="login.admin.php"> Admin →</a>
        </div>
    </div>

</body>
</html>
