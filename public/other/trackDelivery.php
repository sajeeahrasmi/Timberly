<?php
session_start();
if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.php';</script>";
    exit();
}

$orderId = $_GET['orderId'] ?? null;

if (!$orderId) {
    echo "Invalid order.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Delivery</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h2>Tracking Delivery for Order #<?php echo htmlspecialchars($orderId); ?></h2>
    <div id="map"></div>
    <button onclick="completeDelivery()">Complete Delivery</button>

    <script>
        let map, marker;

        function initMap() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const driverLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    // Show map
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: driverLocation,
                        zoom: 15
                    });

                    marker = new google.maps.Marker({
                        position: driverLocation,
                        map: map,
                        title: "Driver's Location"
                    });

                    // Send location to server
                    fetch('startDelivery.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            orderId: "<?php echo $orderId; ?>",
                            lat: driverLocation.lat,
                            lng: driverLocation.lng
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Delivery Started! Location shared with customer.');
                        } else {
                            alert('Failed to share location.');
                        }
                    });
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function completeDelivery() {
            const otp = prompt("Enter OTP to complete delivery:");
            if (!otp) return;

            fetch('verifyDelivery.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    orderId: "<?php echo $orderId; ?>",
                    otp: otp
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Delivery Completed Successfully!');
                    window.location.href = 'driver.php';
                } else {
                    alert(data.message || 'OTP verification failed.');
                }
            });
        }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
    </script>
</body>
</html>
