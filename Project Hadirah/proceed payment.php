<?php
// PHP to handle dynamic content or variables, for example:
$whatsapp_number = "0182322906";  // Example WhatsApp number
$qr_code_image = "qr-code.jpg";  // Assuming the image is inside an 'images' folder
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceed to Payment</title>
    <style>
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
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
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
        }
        .payment-options img {
            max-width: 150px;
            margin-top: 15px;
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
        <h1>Proceed to Payment</h1>

        <p style="text-align: center;">Choose a payment method below:</p>

        <div class="payment-options">
            <!-- WhatsApp Link -->
            <a href="https://wa.me/<?php echo $whatsapp_number; ?>?text=Hi,%20I%20want%20to%20make%20a%20payment" target="_blank">
                Contact us via WhatsApp
            </a>

            <!-- QR Code Container -->
        <div class="qr-code-container">
            <h3>Scan QR Code for Payment</h3>
            <!-- QR Code Image for Payment -->
            <img id="qr-code" src="<?php echo $qr_code_image; ?>" alt="QR Code for Payment">
        
        </div>
        
        <div class="footer">
            <p>If you need help, contact us on WhatsApp.</p>
        </div>
    </div>

</body>
</html>
