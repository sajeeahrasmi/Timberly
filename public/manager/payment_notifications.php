
<?php 
include '../../api/getPdetails.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Notifications</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        color: #333;
        padding: 40px;
    }

    h1 {
        color: #895D47;
        text-align: center;
        font-size: 32px;
        border-bottom: 4px solid #895D47;
        padding-bottom: 12px;
        margin-bottom: 40px;
    }

    .back-button {
        margin-bottom: 30px;
        display: inline-block;
        background-color:#895D47;
        color: white;
        padding: 12px 26px;
        border-radius: 25px;
        text-decoration: none;
        border: 2px solid#895D47;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        background-color: white;
        color: #895D47;
    }

    .mark-read-button{
        margin-top: 10px;
        display: inline-block;
        background-color:#895D47;
        color: white;
        padding: 12px 26px;
        border-radius: 25px;
        text-decoration: none;
        border: 2px solid#895D47;
        font-weight: bold;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .mark-read-button:hover {
        background-color: white;
        color: #895D47;
    }

    table {
    width: 100%;
    border-collapse: collapse; /* Important: makes borders touch */
    background-color: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}


    thead {
        background-color: #895D47;
        color: white;
    }

    .page-container {
        max-width: 1500px;
        margin: auto;
        padding: 40px;
        border: 2px solid #895D47;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
    }
    table, th, td {
        border: 1px solid brown;
    border-collapse: collapse;
}

th, td {
    padding: 18px 24px;
    text-align: left;
    border: 1px solid #895D47; /* Border for each cell */
}


    th, td {
        padding: 18px 24px;
        text-align: left;
    }

    tbody tr:nth-child(even) {
        background-color: #f4f4f4;
    }

    tbody tr:hover {
        background-color: rgba(90, 88, 87, 0.4);
        transition: background-color 0.3s ease;
    }

    th:first-child {
        border-top-left-radius: 12px;
    }

    th:last-child {
        border-top-right-radius: 12px;
    }

    td {
        font-size: 15px;
    }

    @media (max-width: 768px) {
        th, td {
            padding: 12px;
            font-size: 14px;
        }
    }
</style>
</head>
<body>
<div class="page-container">
    <h1>Payment Notifications</h1>
    <a class="back-button" href="admin.php">Back</a>

    <table>
        <thead>
            <tr>
                <th>OrderId</th>
                <th>Amount (Rs.)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody >
        <?php echo $tableRows; ?>
        </tbody>
    </table>
</div>

<script>
function markAsRead(orderId) {
    fetch('../../api/markAsRead.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'orderId=' + orderId
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        // Optionally remove or disable the button
        location.reload(); // Refresh to reflect the change
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>


</body>
</html>
