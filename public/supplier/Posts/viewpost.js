document.addEventListener("DOMContentLoaded", () => {
    const viewButtons = document.querySelectorAll(".fa-eye");
    const popup = document.getElementById("view-post-popup");
    const closePopupButton = popup.querySelector("[data-close-popup]");

    // Function to show the popup
    const showPopup = (postDetails) => {
        document.getElementById("view-post-id").textContent = postDetails.id;
        document.getElementById("view-post-category").textContent = postDetails.category;
        document.getElementById("view-post-type").textContent = postDetails.type;
        document.getElementById("view-post-items").textContent = postDetails.items;
        document.getElementById("view-post-date").textContent = postDetails.date;
        document.getElementById("view-post-status").textContent = postDetails.postStatus;
        document.getElementById("view-post-payment-status").textContent = postDetails.paymentStatus;

        popup.style.display = "block";
    };

    // Function to hide the popup
    const hidePopup = () => {
        popup.style.display = "none";
    };

    // Attach event listeners to view buttons
    viewButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
            const postDetails = {
                id: button.closest("tr").children[0].textContent,
                category: button.closest("tr").children[1].textContent,
                type: button.closest("tr").children[2].textContent,
                items: button.closest("tr").children[3].textContent,
                date: button.closest("tr").children[4].textContent,
                postStatus: button.closest("tr").children[5].textContent,
                paymentStatus: button.closest("tr").children[6].textContent,
            };
            showPopup(postDetails);
        });
    });

    // Attach event listener to close button
    closePopupButton.addEventListener("click", hidePopup);

    // Optional: Close the popup when clicking outside of it
    popup.addEventListener("click", (event) => {
        if (event.target === popup) {
            hidePopup();
        }
    });
});
