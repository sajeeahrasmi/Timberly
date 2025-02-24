function deleteSupplier(supplierId) {
    if (confirm("Are you sure you want to delete this supplier?")) {
        console.log("Sending POST request to delete supplier...");
        fetch("../../api/deleteSupplier.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",  // Make sure the server knows how to process the data
            },
            body: new URLSearchParams({
                supplier_id: supplierId  // Send supplier_id as form data
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Supplier deleted successfully.");
                window.location.href = "./suppliers.php"; // Redirect to suppliers list
            } else {
                alert("Error deleting supplier: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while deleting the supplier.");
        });
    }
}
