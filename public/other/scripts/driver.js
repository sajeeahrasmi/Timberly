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

        currentDeliveryId = orderId;
        console.log("Current Delivery ID:", currentDeliveryId);
        console.log("Location Link:", locationLink);
        

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
                btn.disabled = false;
                btn.innerText = "End Delivery";
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-success');
                btn.innerHTML = `<i class="fas fa-check"></i> End Delivery`;

                // On End Delivery click
                btn.onclick = function () {
                    fetch('generateAndSendOTP.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ orderId: orderId })
                    })
                    .then(res => res.text())
                    .then(text => {
                        console.log("Raw OTP response:", text);
                
                        // let data;
                        // try {
                        //     data = JSON.parse(text);
                        // } catch (err) {
                        //     console.error("OTP JSON parse error:", err);
                        //     alert("Something went wrong while sending OTP.");
                        //     return;
                        // }
                
                        if (data.success) {
                            alert("OTP sent to customer.");
                            document.getElementById('otpModal').style.display = 'block';
                        } else {
                            alert("Failed to send OTP: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error generating OTP:", error);
                        alert("Something went wrong while sending OTP.");
                    });
                };
                

                // Add View Route button
                const viewRouteBtn = document.createElement('button');
                viewRouteBtn.textContent = 'View Route';
                viewRouteBtn.classList.add('button', 'outline', 'view-route-btn');
                viewRouteBtn.onclick = function () {
                    openMapWindow(orderId);
                };
                btn.parentNode.appendChild(viewRouteBtn);
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

function openMapWindow(orderId) {
    fetch(`getDeliveryMapData.php?orderId=${orderId}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const deliveryLocation = encodeURIComponent(data.deliveryLocation);
                const startingLocation = encodeURIComponent("Colombo");
                const mapUrl = `https://www.google.com/maps/dir/?api=1&origin=${startingLocation}&destination=${deliveryLocation}&travelmode=driving`;
                //open the map in  the same 
                window.open(mapUrl, "_blank", "width=800,height=600");
            } else {
                alert("Failed to get delivery location: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error getting delivery location:", error);
            alert("Error loading map");
        });
}

function verifyOTP() {
    const otpInput = document.getElementById('otp');
    const otp = otpInput.value.trim();

    if (otp.length === 6 && currentDeliveryId) {
        fetch('verifyOTP.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                orderId: currentDeliveryId,
                otp: otp
            })
        })
        .then(async res => {
            // If server returns HTML or empty response, this will catch it
            const contentType = res.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Invalid JSON response from server');
            }

            const data = await res.json();

            if (data.success) {
                alert("Delivery completed successfully!");

                const deliveryItem = document.getElementById(`delivery-btn-${currentDeliveryId}`).closest('.delivery-item');
                if (deliveryItem) deliveryItem.remove();

                currentDeliveryId = null;
                closeModal('otpModal');
                otpInput.value = '';
            } else {
                alert("OTP verification failed: " + data.message);
            }
        })
        .catch(err => {
            console.error("OTP verify error:", err);
            alert("Something went wrong during OTP verification. Please try again.");
        });

    } else {
        alert("Please enter a valid 6-digit OTP");
    }
}

function toggleAvailability() {
    const statusInput = document.getElementById('driverAvailable');
    const currentStatus = statusInput.value;

    fetch('./updateAvailability.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ currentStatus: currentStatus })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            statusInput.value = data.newStatus;
            updateAvailabilityButton(data.newStatus);
        } else {
            alert("Failed to update availability");
        }
    })
    .catch(err => {
        console.error("Error updating availability:", err);
    });
}

function updateAvailabilityButton(status) {
    const btn = document.getElementById('availabilityBtn');
    const hidden = document.getElementById('driverAvailable');
    hidden.value = status;

    if (status === 'YES') {
        btn.innerText = "Available ✅";
        btn.classList.remove("solid");
        btn.classList.add("outline");
    } else {
        btn.innerText = "Not Available ❌";
        btn.classList.remove("outline");
        btn.classList.add("solid");
    }
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}



