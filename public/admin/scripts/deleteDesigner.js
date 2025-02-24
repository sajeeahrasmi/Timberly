function deleteDesigner(designerId) {
    if (confirm("Are you sure you want to delete this designer?")) {
        console.log("Sending POST request to delete designer...");
        fetch("../../api/deleteDesigner.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",  // Make sure the server knows how to process the data
            },
            body: new URLSearchParams({
                designer_id: designerId  // Send designer_id as form data
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Designer deleted successfully.");
                window.location.href = "./designers.php"; // Redirect to designers list
            } else {
                alert("Error deleting designer: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while deleting the designer.");
        });
    }
}
