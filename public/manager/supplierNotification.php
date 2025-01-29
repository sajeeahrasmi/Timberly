<?php
// Authentication check MUST be the first thing in the file
require_once '../../api/auth.php';

// Rest of your existing PHP code follows...
?>
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
 /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f2f5;
    color: #333;
    line-height: 1.6;
    padding: 30px;
    max-width: 100%;
    overflow-x: hidden;
}

h1 {
    color: #895D47;
    text-align: center; /* Centered title */
    border-bottom: 3px solid #895D47;
    padding-bottom: 15px;
    margin-bottom: 40px;
}

/* Supplier and Product Lists */
.list-container {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    padding: 30px;
    margin-bottom: 40px;
    width: 100%; /* Set width to 100% */
    border: 3px solid #895D47;
}

.list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 12px;
    border-bottom: 1px solid #e0e0e0;
}

.list-item:last-child {
    border-bottom: none;
}

.list-item span {
    font-weight: bold;
    font-size: 18px;
}

/* Buttons */
button {
    background-color: #895D47;
    color: white;
    border: 2px solid #895D47;
    padding: 12px 24px;
    border-radius: 30px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s, border-color 0.3s, color 0.3s;
    font-size: 16px;
    margin: 8px;
}

button:hover {
    background-color: white;
    color: #895D47;
    border-color: #895D47;
    transform: translateY(-2px);
}

/* Button Styles for Modal */
button[name="approve_supplier"], 
button[name="approve_product"] {
    background-color: #28a745;
    border-color: #28a745;
}

button[name="approve_supplier"]:hover, 
button[name="approve_product"]:hover {
    background-color: #218838;
    border-color: #218838;
    color: #fff;
}

button[name="reject_supplier"], 
button[name="reject_product"] {
    background-color: #e74c3c;
    border-color: #e74c3c;
}

button[name="reject_supplier"]:hover, 
button[name="reject_product"]:hover {
    background-color: #c0392b;
    border-color: #c0392b;
    color: #fff;
}

/* Modal Styles */
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
    background-color: #fff;
    color: #333;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 750px;
    max-height: 550px;
    overflow-y: auto;
    position: relative;
    border: 3px solid #895D47;
    transition: transform 0.3s ease, opacity 0.3s ease;
    transform: scale(0.9); /* Initial scale effect */
}

.modal.active .modal-content {
    transform: scale(1); /* Animate modal into view */
}

.modal h3 {
    margin-top: 0;
    margin-bottom: 20px;
    color: #895D47;
    font-size: 24px;
    font-weight: 700;
    text-align: center;
}

/* Close Button */
.close {
    color: #aaa;
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 32px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s;
}

.close:hover,
.close:focus {
    color: #000;
}

/* Product Image */
#productDetails img {
    width: 100%;
    max-width: 300px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
}

/* Form Styles */
form {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 30px;
}

form button {
    background-color: #895D47;
    color: white;
    border: 2px solid #895D47;
    padding: 12px 30px;
    border-radius: 30px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s, border-color 0.3s;
    width: 48%; /* Ensure the buttons are side by side */
}

form button:hover {
    background-color: white;
    color: #895D47;
    border-color: #895D47;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-content {
        width: 90%;
        padding: 20px;
    }

    form {
        flex-direction: column;
        align-items: center;
    }

    form button {
        width: 100%;
        margin-bottom: 12px;
    }
}


/* Close Button */
.close {
    color: #aaa;
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 32px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s;
}

.close:hover,
.close:focus {
    color: #000;
}

/* Form Styles */


.supplier-name {
    font-size: 20px;
    font-weight: bold;
    color: black;
    margin: 18px 0;
   
}

/* Responsive Design */
@media (max-width: 768px) {
    .list-container {
        padding: 20px;
    }

    .list-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .modal-content {
        width: 90%;
        padding: 25px;
    }

   
}

</style>

</head>
<body>
    <h1>Supplier Notification</h1>
    <button class = "view-btn" onclick = "window.location.href = 'admin.php'">Back</button>
    <h2 style="text-align: center;">Pending Suppliers</h2>
    <div class="list-container">
        <?php foreach ($suppliers as $supplier): ?>
            <?php if ($supplier['status'] === 'Not Approved'): ?>
                <div class="list-item">
                    <span><?php echo $supplier['name']; ?></span>
                    
                    <button onclick="showSupplierDetails(<?php echo $supplier['userId']; ?>)">View Supplier</button>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

   


<h2 style="text-align: center;">Pending Products</h2>

<<div class="list-container">
    <?php foreach ($products as $product): ?>
        <?php if ($product['status'] === 'Not Approved'): ?>
            <div class="list-item">
                <span><?php echo $product['name']; ?></span>
                <button onclick="showProductDetails(<?php echo $product['id']; ?>)">View Product</button>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

    
    <div id="supplierModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('supplierModal')">&times;</span>
            <h3>Supplier Details</h3>
            <div id="supplierDetails"></div>
            <form method="POST">
                <input type="hidden" id="supplier_id" name="supplier_id">
                <button type="submit" onclick ="approveProduct()" name="approve_supplier">Approve</button>
                <button type="submit"  onclick ="rejectProduct()"  name="reject_supplier">Reject</button>
            </form>
        </div>
    </div>

    
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('productModal')">&times;</span>
            <h3>Product Details</h3>
            <div id="productDetails"></div>
            <form method="POST">
                <input type="hidden" id="product_id" name="product_id">
                <button type="submit" onclick ="approveProduct()"  name="approve_product">Approve</button>
                <button type="submit"  onclick ="rejectProduct()" name="reject_product">Reject</button>
            </form>
        </div>
    </div>

    <script>
        const suppliers = <?php echo json_encode($suppliers); ?>;
       function showSupplierDetails(supplierId) {
    console.log(supplierId); // Log supplierId for debugging
    const suppliers = <?php echo json_encode($suppliers); ?>; // JSON encode PHP array to JavaScript

    // Ensure you are comparing the correct data type (strings or numbers)
    const supplier = suppliers.find(s => s.userId == supplierId); // Use == to compare both string and number types
    if (supplier) {
    document.getElementById('supplierDetails').innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p><strong>Name:</strong> ${supplier.name}</p>
                <p><strong>Address:</strong> ${supplier.address}</p>
                <p><strong>Contact:</strong> ${supplier.phone}</p>
                <p><strong>Email:</strong> ${supplier.email}</p>
            </div>
            <img src="./images/download.png" alt="Mock Supplier Image" style="margin-right: 100px; margin-top: -20px; border: 5px solid #895D47 ;">
        </div>
    `;
    document.getElementById('supplier_id').value = supplier.id; // Set hidden input value
    document.getElementById('supplierModal').classList.add('active'); // Show modal
} else {
    alert('Supplier not found');
}
      }


        function showProductDetails(productId) {
            const products = <?php echo json_encode($products); ?>;
            const product = products.find(p => p.id === productId);
            document.getElementById('productDetails').innerHTML = `
                <p><strong>Name:</strong> ${product.name}</p>
                <p><strong>Details:</strong> ${product.details}</p>
               
                <p><strong>Supplier:</strong> ${product.supplier_id}</p>
                <p><strong>Supplier Address:</strong> ${product.supplier_address}</p> <!-- Added Supplier Address -->
        <p><strong>Unit Price:</strong> Rs.${product.unit_price.toFixed(2)}</p> <!-- Added Unit Price -->
                
                
                <img src="./images/log.jpeg" alt="${product.name}" ">
            `;
            document.getElementById('product_id').value = product.id;
            document.getElementById('productModal').classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }
        function approveProduct() {
        
        
        // You can handle product approval logic here
        alert('Approving ');
        
        // If you want to submit the form after approval (for example, send POST request):
        // document.getElementById('approvalForm').submit();

        closeModal('supplierModal'); // Close the modal after approval
    }

    function rejectProduct() {
        

        // You can handle product rejection logic here
        alert('Rejecting product');
        
        // Close the modal after rejection
        closeModal('supplierModal');
    }
    </script>
</body>
</html>
