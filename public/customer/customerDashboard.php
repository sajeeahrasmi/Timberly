<?php

session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];


include '../../config/db_connection.php';

$query = "SELECT COUNT(orderId) as totalOrders FROM orders WHERE userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalorders = $row['totalOrders'] ?? '0';

//this is to get the orderId of the last order
$queryLastOrder = "SELECT orderId, totalAmount, category FROM orders WHERE userId = ? ORDER BY orderId DESC LIMIT 1;";
$stmtLastOrder = $conn->prepare($queryLastOrder);
$stmtLastOrder->bind_param("i", $userId);
$stmtLastOrder->execute();
$lastOrderResult = $stmtLastOrder->get_result();
$rowLastOrder = $lastOrderResult->fetch_assoc();
$lastOrderId = $rowLastOrder['orderId'] ?? 0;
$lastOrderIdTotalAmount = $rowLastOrder['totalAmount'] ?? 0;
$lastOrderIdCategory = $rowLastOrder['category'] ?? '';

$queryPaid = "SELECT SUM(amount) AS paidAmount FROM payment WHERE orderId = ?";
$stmt = $conn->prepare($queryPaid);
$stmt->bind_param("i", $lastOrderId);
$stmt->execute();
$resultPaid = $stmt->get_result();
$paidData = $resultPaid->fetch_assoc();
$paidAmount = $paidData['paidAmount'] ?? 0;

$balance = $lastOrderIdTotalAmount - $paidAmount;

$orderItems = [];
if($lastOrderId != 0){
    //check the category for lumber
    if ($lastOrderIdCategory === 'Furniture') {
        $query4 = "SELECT f.description, o.itemId, o.qty, o.unitPrice, o.status, o.type
                  FROM orderfurniture o 
                  JOIN furnitures f ON o.itemId = f.furnitureId 
                  WHERE o.orderId = ?";
        $stmt4 = $conn->prepare($query4);
        $stmt4->bind_param("i", $lastOrderId);
        $stmt4->execute();
        $orderItems = $stmt4->get_result();
        // $orderItems = $stmt4->get_result()->fetch_all(MYSQLI_ASSOC);

    
    } elseif ($lastOrderIdCategory === 'Lumber') {
        $query4 = "SELECT l.type, CONCAT(l.length, 'm x ', l.width, 'mm x ', l.thickness, 'mm') AS description, l.unitPrice, o.itemId, o.qty, o.status
                  FROM orderlumber o 
                  JOIN lumber l ON o.itemId = l.lumberId 
                  WHERE o.orderId = ?";
        $stmt4 = $conn->prepare($query4);
        $stmt4->bind_param("i", $lastOrderId);
        $stmt4->execute();
        $orderItems = $stmt4->get_result();
        // $orderItems = $stmt4->get_result()->fetch_all(MYSQLI_ASSOC);

    
    } elseif ($lastOrderIdCategory === 'CustomisedFurniture') {
        $query4 = "SELECT o.itemId, o.category as description, o.qty,  o.unitPrice , o.status, o.type
                  FROM ordercustomizedfurniture o 
                  WHERE o.orderId = ?";
        $stmt4 = $conn->prepare($query4);
        $stmt4->bind_param("i", $lastOrderId);
        $stmt4->execute();
        $orderItems = $stmt4->get_result();
        // $orderItems = $stmt4->get_result()->fetch_all(MYSQLI_ASSOC);

    }
}

//checked

$querym = "SELECT m.*  FROM orders o JOIN measurement m ON o.orderId = m.orderId WHERE o.userId = ? AND m.date IS NOT NULL ORDER BY m.date DESC LIMIT 1";
$stmtm = $conn->prepare($querym);
$stmtm->bind_param("i", $userId);
$stmtm->execute();
$resultm = $stmtm->get_result();

$measurementDate = null;
if ($rowm = $resultm->fetch_assoc()) {
    $measurementDate = $rowm['date']; 
}

//now the delivery date
$query3 = "SELECT 
        MAX(latest_date) AS driverDate
    FROM (
        SELECT MAX(ol.date) AS latest_date
        FROM orders o
        JOIN orderlumber ol ON o.orderId = ol.orderId
        WHERE o.userId = ?
        
        UNION
        
        SELECT MAX(ofr.date) AS latest_date
        FROM orders o
        JOIN orderfurniture ofr ON o.orderId = ofr.orderId
        WHERE o.userId = ?
        
        UNION
        
        SELECT MAX(oc.date) AS latest_date
        FROM orders o
        JOIN ordercustomizedfurniture oc ON o.orderId = oc.orderId
        WHERE o.userId = ?
    ) AS combined_dates
";

$stmt3 = $conn->prepare($query3);
$stmt3->bind_param("iii", $userId, $userId, $userId);
$stmt3->execute();
$result3 = $stmt3->get_result();
$data3 = $result3->fetch_assoc();

$driverDate = $data3['driverDate'] ?? '';

//everything checked,done
$queryNot = "SELECT * FROM customernotification WHERE userId = ? AND view = 'no' LIMIT 2";
$stmtNot = $conn->prepare($queryNot);

$notifications = [];

if ($stmtNot) {
    $stmtNot->bind_param("i", $userId);
    $stmtNot->execute();
    $resultNot = $stmtNot->get_result();

    if ($resultNot && $resultNot->num_rows > 0) {
        while ($row = $resultNot->fetch_assoc()) {
            $notifications[] = $row;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>

    <link rel="stylesheet" href="../customer/styles/customerDashboard.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/calenderScript.js" defer></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    </head>
<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>
        
        <div class="main-content">

            <div id="header"></div>

            <section class="content">
                <div class="main">
                    <div class="card-grid">
                        <div class="card">
                            <h3>Total Orders</h3>
                            <p><?php echo $totalorders ?></p>
                            <button class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/customer/orderHistory.php`" >View Orders</button>
                        </div>
                        <div class="card">
                            <h3>Recent Order Payment</h3>
                            <p><strong>Total :</strong> <?php echo $lastOrderIdTotalAmount ?></p>
                            <p><strong>Paid :</strong> <?php echo $paidAmount ?></p>
                            <p><strong>Balance : </strong> <?php echo $balance ?></p>
                        </div>
                    </div>
                    <h2>Upcoming Events</h2>
                    <div class="upcoming-events">
                        <div class="event-card" id="measurement-event" <?php if ($measurementDate): ?> data-date="<?= $measurementDate ?>" <?php endif; ?>>
                            <div class="event-icon">
                                <i class="fas fa-ruler"></i>
                            </div>
                            <div>
                                <h4>Measurement Appointment</h4>
                                <?php if ($measurementDate): ?>
                                    <p>Scheduled for <?= date('M j, Y', strtotime($measurementDate)) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="event-card" id="delivery-event" <?php if ($driverDate): ?> data-date="<?= $driverDate ?>" <?php endif; ?>>
                            <div class="event-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div>
                                <h4>Delivery Scheduled</h4>
                                <?php if ($driverDate): ?>
                                    <p>Expected on <?= date('M j, Y', strtotime($driverDate)) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="recent-order">
                        <h2>Recent Order Details</h2>
                        <?php if (!empty($orderItems)): ?>
                        <table class="order-details-table">                      
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['itemId']) ?></td>
                                    <td><?= htmlspecialchars($item['description']) ?></td>
                                    <td><?= htmlspecialchars($item['type'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($item['qty']) ?></td>
                                    <td>Rs <?= number_format($item['unitPrice'], 2) ?></td>
                                    <td><?= htmlspecialchars($item['status']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                            <p>No order items available.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="right">
                    <!-- <h1>Calender</h1> -->
                    <div class="right-top">
                        <div class="wrapper">
                            <header>
                                <p class="current-date"></p>
                                <div class="icons">
                                <span id="prev" class="material-symbols-rounded"><i class="fa-solid fa-chevron-left"></i></span>
                                <span id="next" class="material-symbols-rounded"><i class="fa-solid fa-chevron-right"></i></span>
                                </div>
                            </header>
                            <div class="calendar">
                                <ul class="weeks">
                                  <li>Sun</li>
                                  <li>Mon</li>
                                  <li>Tue</li>
                                  <li>Wed</li>
                                  <li>Thu</li>
                                  <li>Fri</li>
                                  <li>Sat</li>
                                </ul>
                                <ul class="days"></ul>
                            </div>
                        </div>

                        
                    </div>
                    <!-- <div class="right-bottom">
                        <div class="heading">
                            <h2>Notifications</h2>
                            
                        </div>
                        
                        <div class="notification-card">
                            <h6>From : </h6>
                            <p>heading </p>
                        </div>
                        <div class="notification-card">
                            <h6>From : </h6>
                            <p>heading </p>
                        </div>
                        <button class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/customer/orderWishlist.html`">See more</button>
                    </div> -->
                    <div class="right-bottom">
                        <div class="heading">
                            <h2>Notifications</h2>                          
                        </div>

                        <?php if (!empty($notifications)): ?>
                            <?php foreach ($notifications as $note): ?>
                                <div class="notification-card">
                                    <h6>From: <?= htmlspecialchars($note['fromWhom']) ?></h6>
                                    <p><?= htmlspecialchars($note['message']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="notification-card">
                                <p>No new notifications</p>
                            </div>
                        <?php endif; ?>

                        <button class="button outline" onclick="window.location.href='http://localhost/Timberly/public/customer/notification.php'">
                            See more
                        </button>
                    </div>

                </div>

            </section>
        </div>
    </div>

</body>
</html>
