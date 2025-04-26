<?php
    include '../../api/auth.php';
    include '../../api/getOrderDetailsByAdmin.php';
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly Ltd</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/orderDetails.css">
    <link rel="stylesheet" href="./styles/components/header.css">
    <link rel="stylesheet" href="./styles/components/sidebar.css">
</head>
<body>
    <div class="dashboard-container">
            <div style="position: fixed">
                <?php include "./components/sidebar.php" ?> 
            </div>
            <div class="main-content" style="margin-left: 300px">
                <?php include "./components/header.php" ?>
                <p class="page-type-banner">order</p>
                <div class="order-header">
                    <h2><?php echo htmlspecialchars($order['order_id']); ?></h2>
                </div>
                <p class="order-stats"><?php echo htmlspecialchars($order['date']); ?> | <?php echo htmlspecialchars($order['itemQty']); ?> <?php if ($order['itemQty'] == 1) {echo "item";} else {echo "items";}?> | <span class="advance-paid"><?php echo htmlspecialchars($order['orderStatus']); ?></span></p>

                <div class="first-order-body">
                    <div class="items-section">
                        <h3 style="display: inline-block; margin-top: 10px">Items</h3>
                        <table>
                            <?php $subtotal = 0; ?>
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><a href="#"><?php echo htmlspecialchars($item['itemId']); ?></a></td>
                                    <td style="text-align: left">
                                        <?php
                                            if (!empty($item['description'])) {
                                                echo htmlspecialchars($item['description']);
                                            } else {
                                                echo htmlspecialchars($item['type']);
                                            }
                                        ?>
                                    </td>
                                    <?php $unitPrice = number_format($item['unitPrice'],2) ?>
                                    <td style="text-align: right"><?php echo htmlspecialchars($unitPrice); ?></td>
                                    <td>*<?php echo htmlspecialchars($item['qty']); ?></td>
                                    <?php $price = $item['unitPrice'] * $item['qty'];
                                    $subtotal += $price;
                                    $price = number_format($price,2); ?>
                                    <td style="text-align: right"><?php echo htmlspecialchars($price); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <?php $total = $subtotal + 1300;
                                $subtotal = number_format($subtotal,2)?>
                                <td colspan="4" class="subtotal">Subtotal</td>
                                <td style="text-align: right"><?php echo htmlspecialchars($subtotal); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="delivery">Delivery charges</td>
                                <td style="text-align: right">1,300.00</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="total" style="font-weight: 600">Total(Rs)</td>
                                <?php $tot = $total;
                                $total = number_format($total,2);?>
                                <td style="text-align: right; font-weight: bold;"><?php echo htmlspecialchars($total); ?></td>
                            </tr>
                        </table>
                    </div>
                
                    <div style="display: inline">
                        <div class="customer-section">
                            <h3 style="display: inline-block; margin-top: 0px">Customer</h3>
                            <div class="customer-info">
                                <img src="./images/user-pic.jpg" alt="custmr-img">
                                <div>
                                    <p style="margin-bottom: 5px"><?php echo htmlspecialchars($order['customerName']); ?></p>
                                    <a href="mailto:<?php echo htmlspecialchars($order['email']); ?>"><?php echo htmlspecialchars($order['email']); ?></a>
                                    <p style="color: #707070; font-size: 12px; margin-bottom: 0px"><?php echo htmlspecialchars($order['userId']); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="delivery-address-section">
                            <h3 style="display: inline-block; margin-top: 0px">Delivery address</h3>
                            <p style="color: #707070; margin-top: 0; margin-bottom:0px; margin-left: 5px; font-size: small;"><?php echo htmlspecialchars($order['address']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="second-order-body"></div>
                <div class="transactions-section">
                    <h3 style="display: inline-block; margin-top: 10px">Transactions</h3>
                    <table class="transaction-table">
                        <?php $paymentsTotal = 0; ?>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td>
                                    <div class="transaction-row">
                                        <span class="date"><?php echo htmlspecialchars($payment['date']) ?></span>
                                        <?php $paymentTotal += $payment['amount'] ?>
                                        <span class="amount">Rs <?php echo number_format($payment['amount'], 2) ?></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <?php if ($paymentTotal==0) {
                                echo '<td colspan="2" class="no-transaction">No transactions have made yet</td>';
                            }?>
                        </tr>
                    </table>
                </div>
                <div class="balance-section">
                    <h3 style="margin-top: 8px">Balance</h3>
                    <table class="balance-table">
                        <tr>
                            <td>Order Total</td>
                            <td>Rs <?php echo htmlspecialchars($total); ?></td>
                        </tr>
                        <tr>
                            <td>Paid by the customer</td>
                            <?php $remainingBalance = $tot - $paymentTotal;
                            $paymentTotal = number_format($paymentTotal , 2)?>
                            <td>- Rs <?php echo htmlspecialchars($paymentTotal); ?></td>
                        </tr>
                        <tr style="border-top: 1px #e2d0c7 solid">
                            <td style="font-weight: 600">Remaining balance</td>
                            <?php $remainingBalance = number_format($remainingBalance , 2); ?>
                            <td style="font-weight: 600">Rs <?php echo htmlspecialchars($remainingBalance); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
