<?php
    include '../../api/newSupplierandProducts.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Notification</title>
   
    <style>
    /* General Styles */
   /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f2f5;
    color: #333;
    line-height: 1.6;
    padding: 20px;
}

h1 {
    color: #895D47; /* Change title color */
    text-align: center;
    border-bottom: 2px solid #895D47; /* Change border color */
    padding-bottom: 10px;
    margin-bottom: 30px;
}

/* Supplier and Product Lists */
.list-container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 30px;
    max-width: 800px;
    margin: 0;
    border: 2px solid #895D47; /* Add border color */
}

.list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 10px;
    border-bottom: 1px solid #e0e0e0;
}

.list-item:last-child {
    border-bottom: none;
}

.list-item span {
    font-weight: bold;
    font-size: 16px;
}

/* Buttons */
button {
    background-color: #895D47; /* Set button color */
    color: white;
    border: 2px solid #895D47; /* Set border color */
    padding: 10px 20px;
    border-radius: 30px; /* Make buttons oval */
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s, border-color 0.3s, color 0.3s;
    font-size: 14px;
    margin: 5px;
}

button:hover {
    background-color: white;
    color: #895D47;
    border-color: #895D47; /* Change border color on hover */
    transform: translateY(-2px);
}

/* Button Styles for Modal */
button[name="approve_supplier"], 
button[name="approve_product"] {
    background-color: #28a745; /* Green background for approve */
    border-color: #28a745; /* Green border for approve */
}

button[name="approve_supplier"]:hover, 
button[name="approve_product"]:hover {
    background-color: #218838; /* Darker green on hover */
    border-color: #218838; /* Darker green border on hover */
    color : #ffff
}

button[name="reject_supplier"], 
button[name="reject_product"] {
    background-color: #e74c3c; /* Red background for reject */
    border-color: #e74c3c; /* Red border for reject */
}

button[name="reject_supplier"]:hover, 
button[name="reject_product"]:hover {
    background-color: #c0392b; /* Darker red on hover */
    border-color: #c0392b;
    color : #ffff /* Darker red border on hover */
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.7);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal.active {
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 1;
}

.modal-content {
    background-color: #ffffff;
    color: #333;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    width: 80%;
    max-width: 600px;
    max-height: 400px;
    overflow-y: auto;
    position: relative;
    border: 2px solid #895D47; /* Add border color */
}

.modal h3 {
    margin-top: 0;
    margin-bottom: 20px;
    color: #895D47; /* Change modal title color */
}

/* Close Button */
.close {
    color: #aaa;
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s;
}

.close:hover,
.close:focus {
    color: #000;
}

/* Form Styles */
form {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.supplier-name {
    font-size: 18px;
    font-weight: bold;
    color: black;
    margin: 15px 0;
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .list-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .list-item button {
        margin-top: 10px;
        width: 100%;
    }

    .modal-content {
        width: 95%;
        padding: 20px;
    }

    form {
        flex-direction: column;
    }

    form button {
        width: 100%;
        margin-bottom: 10px;
    }
}

</style>

</head>
<body>
    <h1>Supplier Notification</h1>
    <button class = "view-btn" onclick = "window.location.href = 'admin.php'">Back</button>
    <h2>Pending Suppliers</h2>
    <div class="list-container">
        <?php foreach ($suppliers as $supplier): ?>
            <?php if ($supplier['status'] === 'pending'): ?>
                <div class="list-item">
                    <span><?php echo $supplier['name']; ?></span>
                    <button onclick="showSupplierDetails(<?php echo $supplier['id']; ?>)">View Supplier</button>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <h2>Pending Products</h2>
    <div class="list-container">
        <?php foreach ($suppliers as $supplier): ?>
            <?php if ($supplier['status'] === 'pending'): ?>
                <h3 class="supplier-name"><?php echo $supplier['name']; ?></h3>
                <?php foreach ($products as $product): ?>
                    <?php if ($product['status'] === 'pending' && $product['supplier_id'] === $supplier['id']): ?>
                        <div class="list-item">
                            <span><?php echo $product['name']; ?></span>
                            <button onclick="showProductDetails(<?php echo $product['id']; ?>)">View Product</button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Supplier Details Modal -->
    <div id="supplierModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('supplierModal')">&times;</span>
            <h3>Supplier Details</h3>
            <div id="supplierDetails"></div>
            <form method="POST">
                <input type="hidden" id="supplier_id" name="supplier_id">
                <button type="submit" name="approve_supplier">Approve</button>
                <button type="submit" name="reject_supplier">Reject</button>
            </form>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('productModal')">&times;</span>
            <h3>Product Details</h3>
            <div id="productDetails"></div>
            <form method="POST">
                <input type="hidden" id="product_id" name="product_id">
                <button type="submit" name="approve_product">Approve</button>
                <button type="submit" name="reject_product">Reject</button>
            </form>
        </div>
    </div>

    <script>
        function showSupplierDetails(supplierId) {
            const suppliers = <?php echo json_encode($suppliers); ?>;
            const supplier = suppliers.find(s => s.id === supplierId);
            document.getElementById('supplierDetails').innerHTML = `
                <p><strong>Name:</strong> ${supplier.name}</p>
                <p><strong>Address:</strong> ${supplier.address}</p>
                <p><strong>Contact:</strong> ${supplier.contact}</p>
            `;
            document.getElementById('supplier_id').value = supplier.id;
            document.getElementById('supplierModal').classList.add('active');
        }

        function showProductDetails(productId) {
            const products = <?php echo json_encode($products); ?>;
            const product = products.find(p => p.id === productId);
            document.getElementById('productDetails').innerHTML = `
                <p><strong>Name:</strong> ${product.name}</p>
                <p><strong>Details:</strong> ${product.details}</p>
                <img src="${product.photo}" alt="${product.name}" style="width:100%; max-width: 300px;">
            `;
            document.getElementById('product_id').value = product.id;
            document.getElementById('productModal').classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }
    </script>
</body>
</html>
