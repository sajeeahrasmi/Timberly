
function showSection(sectionId) {
  
  const sections = document.querySelectorAll('.section');
  sections.forEach(section => section.classList.remove('active'));

  
  const selectedSection = document.getElementById(sectionId);
  if (selectedSection) {
    selectedSection.classList.add('active');
  }
}

document.addEventListener('DOMContentLoaded', () => {

  showSection('dashboard-section');

  
 
  
  document.querySelector('.notification-btn').addEventListener('click', function() {
    showSection('supplier-notification-section');
   
  });

  
    
 
});
function fetchAlerts() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../../api/alerts.php", true);

  // When the request is complete
  xhr.onload = function() {
      if (xhr.status === 200) {
          var alerts = JSON.parse(xhr.responseText);

          // If there are new alerts, show the default browser alert
          if (alerts.length > 0) {
              var alertss = alerts[0];  // Get the most recent alert
              console.log(alertss.alert_message)
              // Show the alert using a browser alert
              alert('Low Stock Alert: ' + alertss.alert_message + '-ID ' + alertss.material_id +  '- Material: ' + alertss.material_type);
          }
      }
  };

  xhr.send();
}

// Fetch alerts immediately when the page loads
fetchAlerts();

// Optionally, fetch alerts every 10 seconds
setInterval(fetchAlerts, 10000); 

function fetchOrders() {
  fetch('../../api/mockOrders.php') // Adjust path if necessary
    .then(response => response.json())
    .then(data => {
      const tbody = document.getElementById('orders-tbody');
      tbody.innerHTML = ''; // Clear previous entries

      // Group items by orderId
      const orders = {};

      // Filter data to show only pending items (orderStatus or itemStatus as needed)
      const pendingOrders = data.filter(item => item.itemStatus === 'Pending'); // Change 'itemStatus' to 'orderStatus' if necessary

      pendingOrders.forEach(item => {
        if (!orders[item.orderId]) {
          orders[item.orderId] = {
            orderId: item.orderId,
            customerName: item.customerName,
            customerId: item.customerId,
            totalAmount: item.totalAmount,
            orderStatus: item.orderStatus,
            items: [] // Initialize items array for the order
          };
        }

        // Add item to the corresponding order
        orders[item.orderId].items.push({
          itemId: item.itemId,
          qty: item.qty,
          itemStatus: item.itemStatus,
          type: item.type
        });
      });

      // Display the orders with their items
      Object.values(orders).forEach(order => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
          <td>${order.customerId}</td>
          <td>${order.customerName}</td>
          <td>${order.orderId}</td>
          <td>
            ${order.items.map(item => `Item ID: ${item.itemId}<br>Qty: ${item.qty}<br>Type: ${item.type}`).join('<br><br>')}
          </td>
          <td>Rs.${order.totalAmount}</td>
          <td>${order.orderStatus}</td>
          <td>
            <button class="accept-btn" onclick="updateOrderStatus(${order.orderId}, 'Not_Approved')">Accept</button>
            <button class="reject-btn" onclick="updateOrderStatus(${order.orderId}, 'Pending')">Reject</button>
          </td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch(error => console.error('Error fetching orders:', error));
}

function updateOrderStatus(orderId, newStatus) {
  fetch('../../api/updateOrder.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ orderId, newStatus })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          alert(`Order ${orderId} updated to ${newStatus}`);
          
          location.reload();
          // Refresh orders table
      } else {
          alert(`Error: ${data.message}`);
      }
  })
  .catch(error => console.error('Error updating order status:', error));
}



window.onload = fetchOrders;


// Open and close modal functionality
// Open modal when profile button is clicked
// Function to toggle the profile popup visibility


function openProfileModal() {
  document.getElementById('profile-modal').style.display = 'flex';
}

// Close profile modal
function closeProfileModal() {
  document.getElementById('profile-modal').style.display = 'none';
}
window.onclick = function(event) {
  const modal = document.getElementById('profile-modal');
  if (event.target === modal) {
      closeProfileModal();
  }
};


// Handle form submission
document.getElementById('profile-form').addEventListener('submit', function (e) {
  e.preventDefault();

  const newPassword = document.getElementById('new-password').value;
  const confirmPassword = document.getElementById('confirm-password').value;

  if (newPassword !== confirmPassword) {
      alert("New password and confirm password do not match.");
  } else {
      alert("Password changed successfully!");
  }
  closeProfileModal();
});


