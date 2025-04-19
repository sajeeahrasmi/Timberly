document.getElementById("filter").addEventListener("click", () => {
    const orderStatus = document.getElementById("order-status").value.toLowerCase();
    const category = document.getElementById("order-category").value.toLowerCase();
    const paymentStatus = document.getElementById("payment-status").value.toLowerCase();

    const table = document.getElementById("orderDetails");
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(row => {
        const statusCell = row.cells[4].textContent.toLowerCase(); // Column for Status
        const typeCell = row.cells[2].textContent.toLowerCase();
        const paymentCell = row.cells[6].textContent.toLowerCase(); // Column for Type

        const matchesStatus = orderStatus === "" || statusCell === orderStatus;
        const matchesType = category === "" || typeCell === category;
        const matchesPayment = paymentStatus === "" || paymentCell === paymentStatus;

        if (matchesStatus && matchesType && matchesPayment) {
            row.style.display = ""; // Show the row
        } else {
            row.style.display = "none"; // Hide the row
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    // Select all "View" buttons
    document.querySelectorAll("#view-button").forEach(button => {
        button.addEventListener("click", function () {
            // Get the row of the clicked button
            let row = this.closest("tr");

            // Extract Order ID and Category
            let orderId = row.cells[0].textContent.trim(); // Order ID (1st column)
            let category = row.cells[2].textContent.trim().toLowerCase(); // Category (3rd column)

            console.log("hsdjd")
            console.log(category);
            console.log(orderId);

            // Determine target page based on category
            let targetPage;
            if (category === "lumber") {
                targetPage = "orderRawMaterialDetails.php";
            } else if (category === "furniture") {
                targetPage = "orderFurnitureDetails.php";
            } else if (category === "customisedfurniture") {
                targetPage = "orderDoorDetails.php";
            } else {
                alert("Unknown category!"); // Error handling
                return;
            }

            // Redirect to the respective page with order ID
            window.location.href = `http://localhost/Timberly/public/customer/${targetPage}?order_id=${orderId}`;
        });
    });
});
