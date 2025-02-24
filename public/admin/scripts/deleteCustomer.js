function deleteCustomer(customerId) {
    if (confirm("Are you sure you want to delete this customer?")) {
        console.log("Sending POST request to delete customer...");
        fetch("../../api/deleteCustomer.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",  // Make sure the server knows how to process the data
            },
            body: new URLSearchParams({
                customer_id: customerId  // Send customer_id as form data
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Customer deleted successfully.");
                window.location.href = "./customers.php"; // Redirect to customers list
            } else {
                alert("Error deleting customer: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while deleting the customer.");
        });
    }
}
