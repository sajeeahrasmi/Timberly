<?php
include '../../api/auth.php'; // adjust the path if needed
include '../../api/db.php'; // adjust the path if needed
// Fetch completed orders
$query = "SELECT * FROM orders WHERE status = 'completed'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching order data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Completed Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #eee;
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
    <h2>Completed Orders</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['orderId']) ?></td>
                        <td><?= htmlspecialchars($order['userId'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($order['totalAmount'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($order['category']) ?></td>
                        <td><?= htmlspecialchars($order['date'] ?? '') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="message">No completed orders found.</p>
    <?php endif; ?>
</body>
</html>