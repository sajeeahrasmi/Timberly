document.addEventListener("DOMContentLoaded", () => {
    fetch("../../../config/customer/customer.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to fetch customer data.");
            }
            return response.json();
        })
        .then(data => {
            // Populate the customer's name
            document.getElementById("customer-name").textContent = data.name;
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Session expired. Please log in again.");
            window.location.href = "../../login.html";
        });
});
