<?php

session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$query = "SELECT COUNT(orderId) as totalorders FROM orders WHERE userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalorders = $row['totalorders'] ?? '';


$queryLastOrder = "SELECT orderId, totalAmount, category FROM orders WHERE userId = ? ORDER BY orderId DESC LIMIT 1";
$stmtOrder = $conn->prepare($queryLastOrder);
$stmtOrder->bind_param("i", $userId);
$stmtOrder->execute();
$resultOrder = $stmtOrder->get_result();
$order = $resultOrder->fetch_assoc();

$orderId = $order['orderId'] ?? 0;
$totalAmount = $order['totalAmount']?? 0;
$category = $order['category']?? 0;

$queryPaid = "SELECT SUM(amount) AS paidAmount FROM payment WHERE orderId = ?";
$stmt = $conn->prepare($queryPaid);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$resultPaid = $stmt->get_result();
$paidData = $resultPaid->fetch_assoc();
$paidAmount = $paidData['paidAmount'] ?? 0;

$balance = $totalAmount - $paidAmount;
 
$querym = "SELECT m.*  FROM orders o JOIN measurement m ON o.orderId = m.orderId WHERE o.userId = ? AND m.date IS NOT NULL ORDER BY m.date DESC LIMIT 1";
$stmtm = $conn->prepare($querym);
$stmtm->bind_param("i", $userId);
$stmtm->execute();
$resultm = $stmtm->get_result();
$latestMeasurement = $resultm->fetch_assoc();
// $dateMeasurement = $latestMeasurement['date'] ?? null;
$dateMeasurement = null;
if ($resultm && $resultm->num_rows > 0) {
    $latestMeasurement = $resultm->fetch_assoc();
    $dateMeasurement = $latestMeasurement['date'] ?? null;
}

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

$orderItems = [];

if ($category === 'Furniture') {
    $query4 = "SELECT f.description, o.itemId, o.qty, o.unitPrice, o.status, o.type
              FROM orderfurniture o 
              JOIN furnitures f ON o.itemId = f.furnitureId 
              WHERE o.orderId = ?";
    $stmt4 = $conn->prepare($query4);
    $stmt4->bind_param("i", $orderId);
    $stmt4->execute();
    $orderItems = $stmt4->get_result();

} elseif ($category === 'Lumber') {
    $query4 = "SELECT l.type, CONCAT(l.length, 'm x ', l.width, 'mm x ', l.thickness, 'mm') AS description, l.unitPrice, o.itemId, o.qty, o.status
              FROM orderlumber o 
              JOIN lumber l ON o.itemId = l.lumberId 
              WHERE o.orderId = ?";
    $stmt4 = $conn->prepare($query4);
    $stmt4->bind_param("i", $orderId);
    $stmt4->execute();
    $orderItems = $stmt4->get_result();

} elseif ($category === 'CustomisedFurniture') {
    $query4 = "SELECT o.itemId, o.category as description, o.qty,  o.unitPrice , o.status, o.type
              FROM ordercustomizedfurniture o 
              WHERE o.orderId = ?";
    $stmt4 = $conn->prepare($query4);
    $stmt4->bind_param("i", $orderId);
    $stmt4->execute();
    $orderItems = $stmt4->get_result();

} else {
    $orderItems = null;
}

$queryNot = "SELECT * FROM customernotification WHERE userId = ? AND view = 'no' LIMIT 2";
$stmtNot = $conn->prepare($queryNot);
$stmtNot->bind_param("i", $userId);
$stmtNot->execute();
$resultNot = $stmtNot->get_result();
$notifications = [];
while ($row = $resultNot->fetch_assoc()) {
    $notifications[] = $row;
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
                            <button class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/customer/orderHistory.html`" >View Orders</button>
                        </div>
                        <div class="card">
                            <h3>Recent Order Payment</h3>
                            <p><strong>Total :</strong><?php echo $totalAmount ?></p>
                            <p><strong>Paid :</strong><?php echo $paidAmount ?></p>
                            <p><strong>Balance : </strong><?php echo $balance ?></p>
                        </div>
                    </div>
                    <h2>Upcoming Events</h2>
                    <div class="upcoming-events">
                        <div class="event-card" id="measurement-event">
                            <div class="event-icon">
                                <i class="fas fa-ruler"></i>
                            </div>
                            <div>
                                <h4>Measurement Appointment</h4>
                                <!-- <p>Scheduled for <span id="mDate"><?php echo $dateMeasurement ?></span></p> -->
                                 <p>Scheduled for <span id="mDate"><?php echo date("Y-m-d", strtotime($dateMeasurement)); ?></span></p>
                            </div>
                        </div>
                        <div class="event-card" id="delivery-event">
                            <div class="event-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div>
                                <h4>Delivery Scheduled</h4>
                                <!-- <p>Expected on <span id="dDate"><?php echo $driverDate ?></span></p> -->
                                 <p>Expected on <span id="mDate"><?php echo date("Y-m-d", strtotime($driverDate)); ?></span></p>                               
                            </div>
                        </div>
                    </div>



                    
                     <div class="recent-order">
                        <h2>Recent Order Details</h2>
                        <!-- <table class="order-details-table">
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
                                <?php while ($row = $orderItems->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['itemId']) ?></td>
                                        <td><?= htmlspecialchars($row['description']) ?></td>
                                        <td><?= htmlspecialchars($row['type']) ?></td>
                                        <td><?= htmlspecialchars($row['qty']) ?></td>
                                        <td>Rs <?= htmlspecialchars($row['unitPrice']) ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table> -->
                        <?php if ($orderItems->num_rows > 0): ?>
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
                                    <?php while ($row = $orderItems->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['itemId']) ?></td>
                                            <td><?= htmlspecialchars($row['description']) ?></td>
                                            <td><?= htmlspecialchars($row['type']) ?></td>
                                            <td><?= htmlspecialchars($row['qty']) ?></td>
                                            <td>Rs <?= htmlspecialchars($row['unitPrice']) ?></td>
                                            <td><?= htmlspecialchars($row['status']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
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
                        <!-- <div class="wrapper">
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
                        </div> -->
                        <div class="wrapper">
  <header>
    <p class="current-date"></p>
    <div class="icons">
      <span id="prev">&lt;</span>
      <span id="next">&gt;</span>
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
                    <div class="right-bottom">
                        <div class="heading">
                            <h2>Notifications</h2>                          
                        </div>                       
                        <?php foreach ($notifications as $note): ?>
                        <div class="notification-card">
                            <h6>From: <?= htmlspecialchars($note['fromWhom']) ?></h6>
                            <p><?= htmlspecialchars($note['message']) ?></p>
                        </div>
                    <?php endforeach; ?>
                        <button class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/customer/notification.php`">See more</button>
                    </div>
                </div>

            </section>
        </div>
    </div>

  
     <div id="measurement-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Measurement Appointment Details</h2>
            <p>Date: December 15, 2024</p>
            <p>Time: 10:00 AM</p>
            <p>Technician: Mr. John Doe</p>
            <p>Contact: 077-1234567</p>
        </div>
    </div>

    <div id="delivery-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Delivery Schedule</h2>
            <p>Expected Date: December 28, 2024</p>
            <p>Estimated Time: 2:00 PM</p>
            <p>Delivery Person: Mr. Nimal Silva</p>
            <p>Contact: 071-9876543</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Event Modal Functionality
            const measurementEvent = document.getElementById('measurement-event');
            const deliveryEvent = document.getElementById('delivery-event');
            const measurementModal = document.getElementById('measurement-modal');
            const deliveryModal = document.getElementById('delivery-modal');
            const closeModals = document.querySelectorAll('.close-modal');

            measurementEvent.addEventListener('click', () => {
                measurementModal.style.display = 'block';
            });

            deliveryEvent.addEventListener('click', () => {
                deliveryModal.style.display = 'block';
            });

            closeModals.forEach(closeBtn => {
                closeBtn.addEventListener('click', () => {
                    measurementModal.style.display = 'none';
                    deliveryModal.style.display = 'none';
                });
            });

            // Close modals when clicking outside
            window.addEventListener('click', (event) => {
                if (event.target === measurementModal) {
                    measurementModal.style.display = 'none';
                }
                if (event.target === deliveryModal) {
                    deliveryModal.style.display = 'none';
                }
            });
        });
    </script>


</body>
</html>
