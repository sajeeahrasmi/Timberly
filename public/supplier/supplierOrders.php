<?php include '../../api/fetchApprovedOrders.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Supplier Orders</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/supplierOrders.css">
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<div class="body-container">
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <div class="orders-content">
        <h1>Supplier Order Section</h1>

        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Post Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id']) ?></td>
                                <td><?= htmlspecialchars($order['category']) ?></td>
                                <td><?= htmlspecialchars($order['type']) ?></td>
                                <td><?= htmlspecialchars($order['quantity']) ?></td>
                                <td><?= htmlspecialchars($order['unitprice']) ?></td>
                                <td><?= htmlspecialchars($order['totalprice']) ?></td>
                                <td><?= date("d/m/Y", strtotime($order['postdate'])) ?></td>
                                <td class="po"><?= ($order['status'] = 'Approved') ? 'Approved' : 'Pending' ?></td>
                                <td>
                                <span class="view-btn"
                                    data-id="<?= htmlspecialchars($order['id']) ?>"
                                    data-category="<?= htmlspecialchars($order['category']) ?>"
                                    data-type="<?= htmlspecialchars($order['type']) ?>"
                                    data-quantity="<?= htmlspecialchars($order['quantity']) ?>"
                                    data-unitprice="<?= htmlspecialchars($order['unitprice']) ?>"
                                    data-totalprice="<?= htmlspecialchars($order['totalprice']) ?>"
                                    data-date="<?= date("d/m/Y", strtotime($order['postdate'])) ?>"
                                    data-status="<?= $order['status'] == 'Approved' ? 'Approved' : 'Pending' ?>"
                                    style="cursor:pointer">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align:center;">No approved orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>


<div id="orderModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h3>Order Details</h3>
    <div id="modalDetails"></div>
  </div>
</div>


</body>

<script>
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const modal = document.getElementById('orderModal');
        const details = document.getElementById('modalDetails');

        // Populate modal details
        details.innerHTML = `
            <p><strong>Post ID:</strong> ${btn.dataset.id}</p>
            <p><strong>Category:</strong> ${btn.dataset.category}</p>
            <p><strong>Type:</strong> ${btn.dataset.type}</p>
            <p><strong>No. of Items:</strong> ${btn.dataset.quantity}</p>
            <p><strong>Date:</strong> ${btn.dataset.date}</p>
            <p><strong>Status:</strong> ${btn.dataset.status}</p>
        `;

        modal.style.display = 'flex'; // Show modal
    });
});

// Close button
document.querySelector('.close-btn').addEventListener('click', () => {
    document.getElementById('orderModal').style.display = 'none';
});

// Optional: Close modal when clicking outside content
window.addEventListener('click', (e) => {
    const modal = document.getElementById('orderModal');
    if (e.target === modal) modal.style.display = 'none';
});
</script>
</html>
