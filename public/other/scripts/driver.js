let currentDeliveryId = null;

function handleDelivery(orderId) {
    if (!navigator.geolocation) {
        alert("Geolocation is not supported by your browser");
        return;
    }

    navigator.geolocation.getCurrentPosition(function (position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        const locationLink = `https://www.google.com/maps?q=${latitude},${longitude}`;

        // Set the currently active delivery
        currentDeliveryId = orderId;

        // Send location to backend
        fetch('startDelivery.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                orderId: orderId,
                location: locationLink
            })
        })
            .then(response => response.text())
            .then(text => {
                console.log("Raw backend response:", text);

                let data;
                try {
                    data = JSON.parse(text);
                } catch (err) {
                    console.error("Failed to parse JSON:", err);
                    alert("Error: Invalid JSON from backend");
                    return;
                }

                if (data.success) {
                    alert("Delivery started successfully. Notification sent to customer.");
                    const btn = document.getElementById(`delivery-btn-${orderId}`);
                    btn.disabled = true;
                    btn.innerText = "Delivery Started";
                } else {
                    alert("Failed to start delivery: " + data.message);
                    console.error("Backend response error:", data);
                }
            })
            .catch(error => {
                console.error("Error sending delivery start:", error);
                alert("Error starting delivery. See console for details.");
            });

    }, function (error) {
        alert("Unable to get your location");
        console.error("Geolocation error:", error);
    });
}

function showCustomerDetails(orderId) {
    if (!orderId) return;

    fetch(`getCustomerDetails.php?orderId=${orderId}`)
        .then(res => res.json())
        .then(response => {
            const modalContent = document.getElementById('customerDetailsContent');
            if (response.success) {
                const customer = response.data;
                modalContent.innerHTML = `
                    <p><strong>Name:</strong> ${customer.name}</p>
                    <p><strong>Address:</strong> ${customer.address}</p>
                    <p><strong>Email:</strong> ${customer.email}</p>
                    <p><strong>Phone:</strong> ${customer.phone}</p>
                `;
            } else {
                modalContent.innerHTML = `<p>${response.message}</p>`;
            }
            document.getElementById('customerModal').style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching customer details:', error);
            alert('Failed to fetch customer details.');
        });
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function verifyOTP() {
    const otp = document.getElementById('otp').value;

    if (otp.length === 6) {
        alert("Delivery completed successfully!");

        const deliveryItem = document.getElementById(`delivery-btn-${currentDeliveryId}`).closest('.delivery-item');
        if (deliveryItem) {
            deliveryItem.remove();
        }

        currentDeliveryId = null;
        closeModal('otpModal');
        document.getElementById('otp').value = '';
    } else {
        alert("Please enter a valid 6-digit OTP");
    }
}

// Close modals when clicking outside
window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        closeModal(event.target.id);
    }
};
