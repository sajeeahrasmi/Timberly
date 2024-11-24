let currentDeliveryId = null;


const customerData = {
    '12345': {
        name: "Amal Perera",
        address: "New Lane Road, Colombo",
        phone: "+94 74-567-8900"
    },
    '12346': {
        name: "Amal Perera",
        address: "New Lane Road, Colombo",
        phone: "+94 74-567-8900"
    }
};

function handleDelivery(orderId) {
    const btn = document.getElementById(`delivery-btn-${orderId}`);
    
    if (btn.textContent === 'Start Delivery') {
        // Start delivery
        currentDeliveryId = orderId;
        btn.textContent = 'End Delivery';
        btn.classList.remove('solid');
        btn.classList.add('outline');
    } else {
        // End delivery - show OTP modal
        showOtpModal(orderId);
    }
}

function showOtpModal(orderId) {
    document.getElementById('otpModal').style.display = 'block';
}

function showCustomerDetails(orderId) {
    const customer = customerData[orderId];
    const content = document.getElementById('customerDetailsContent');
    
    content.innerHTML = `
        <p><strong>Name:</strong> ${customer.name}</p>
        <p><strong>Address:</strong> ${customer.address}</p>
        <p><strong>Phone:</strong> ${customer.phone}</p>
    `;
    
    document.getElementById('customerModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function verifyOTP() {
    const otp = document.getElementById('otp').value;
    
    if (otp.length === 6) {
        alert("Delivery completed successfully!");
        
        // Remove the delivered order from the list
        const deliveryItem = document.getElementById(`delivery-btn-${currentDeliveryId}`).closest('.delivery-item');
        if (deliveryItem) {
            deliveryItem.remove();
        }
        
        // Reset current delivery
        currentDeliveryId = null;
        
        // Close modal and reset form
        closeModal('otpModal');
        document.getElementById('otp').value = '';
    } else {
        alert("Please enter a valid 6-digit OTP");
    }
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        closeModal(event.target.id);
    }
}