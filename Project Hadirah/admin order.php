<?php
// Database connection (same as your existing code)
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

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
        $stmt->execute(['status' => $newStatus, 'order_id' => $orderId]);
        header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
        exit();
    } catch (PDOException $e) {
        die("Error updating status: " . $e->getMessage());
    }
}

// Fetch orders and order details (modified to use actual status column)
try {
    $stmt = $pdo->query("
        SELECT 
            o.id AS order_id, 
            o.total_cost, 
            o.order_date, 
            GROUP_CONCAT(CONCAT(od.product_name, ' (', od.quantity, ' x RM ', od.price, ')') SEPARATOR '<br>') AS order_details, 
            o.status
        FROM orders o
        JOIN order_details od ON o.id = od.order_id
        GROUP BY o.id
        ORDER BY o.order_date DESC
    ");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching orders: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <style>
        /* CSS Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            width: 90%;
            margin: auto;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .logout-button {
            display: block;
            text-align: right;
            margin-bottom: 20px;
        }

        .logout-button a {
            text-decoration: none;
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .logout-button a:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }

        table thead {
            background-color: #007BFF;
            color: #fff;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Admin Orders</h1>
        
        <!-- Logout Button -->
        <div class="logout-button">
            <a href="login.admin.php">Logout</a>
        </div>
        
        <table id="orderTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date & Time</th>
                    <th>Order Details</th>
                    <th>Total Cost (RM)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)) : ?>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo $order['order_details']; ?></td>
                            <td><?php echo number_format($order['total_cost'], 2); ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="Pending" <?php echo $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Processing" <?php echo $order['status'] === 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                        <option value="Completed" <?php echo $order['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                        <option value="Cancelled" <?php echo $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No orders found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>