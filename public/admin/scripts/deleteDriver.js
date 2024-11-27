function deleteDriver(driverId) {
    if (confirm("Are you sure you want to delete this driver?")) {
        console.log("Sending POST request to delete driver...");
        fetch("../../api/deleteDriver.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",  // Make sure the server knows how to process the data
            },
            body: new URLSearchParams({
                driver_id: driverId  // Send driver_id as form data
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Driver deleted successfully.");
                window.location.href = "./drivers.php"; // Redirect to drivers list
            } else {
                alert("Error deleting driver: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while deleting the driver.");
        });
    }
}
