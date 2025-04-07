
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

      // Filter data to show only pending items
      const pendingOrders = data.filter(item => 
        (item.productType === 'Lumber' && item.lumberStatus === 'Pending') || 
        (item.productType === 'Furniture' && item.furnitureStatus === 'Pending')
      );

      pendingOrders.forEach(item => {
        if (!orders[item.orderId]) {
          orders[item.orderId] = {
            orderId: item.orderId,
            customerName: item.customerName,
            customerId: item.customerId,
            totalAmount: item.totalAmount,
            orderStatus: item.orderStatus,
            date: item.date,
            lumberItems: [], // Initialize lumber items array
            furnitureItems: [] // Initialize furniture items array
          };
        }

        // Add the item to the appropriate array based on productType
        if (item.productType === 'Lumber') {
          orders[item.orderId].lumberItems.push({
            itemId: item.lumberId,
            qty: item.lumberQty,
            itemStatus: item.lumberStatus,
            type: item.lumberType
          });
        } else if (item.productType === 'Furniture') {
          orders[item.orderId].furnitureItems.push({
            itemId: item.furnitureId,
            qty: item.furnitureQty,
            itemStatus: item.furnitureStatus,
            type: item.furnitureWoodType,
            size: item.furnitureSize,
            category: item.furnitureCategory,
            description: item.furnitureDescription
          });
        }
      });

      // Display the orders with their items
      Object.values(orders).forEach(order => {
        const row = document.createElement('tr');
        
        // Create HTML for lumber items
        const lumberItemsHTML = order.lumberItems.map(item => 
          `<div class="item-details lumber">
            <strong>Lumber:</strong><br>
            Item ID: ${item.itemId}<br>
            Qty: ${item.qty}<br>
            Type: ${item.type}<br>
            Status: ${item.itemStatus}
          </div>`
        ).join('');

        // Create HTML for furniture items
        const furnitureItemsHTML = order.furnitureItems.map(item => 
          `<div class="item-details furniture">
            <strong>Furniture:</strong><br>
            Item ID: ${item.itemId}<br>
            Category: ${item.category || 'N/A'}<br>
            Description: ${item.description || 'N/A'}<br>
            Wood Type: ${item.type}<br>
            Size: ${item.size}<br>
            Qty: ${item.qty}<br>
            
          </div>`
        ).join('');

        // Combine both types of items
        const itemsHTML = lumberItemsHTML + furnitureItemsHTML;
        
        row.innerHTML = `
          <td>${order.customerId}</td>
          <td>${order.customerName}</td>
          <td>${order.orderId}</td>
          
          <td>
            ${itemsHTML || 'No pending items found'}
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

document.getElementById('profile-form').addEventListener('submit', function (e) {
  e.preventDefault();

  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const newPassword = document.getElementById('new-password').value;
  const confirmPassword = document.getElementById('confirm-password').value;

  if (newPassword !== confirmPassword) {
      alert("New password and confirm password do not match.");
      return;
  }

  // Create FormData object to send data via POST
  const formData = new FormData();
  formData.append('name', name);
  formData.append('email', email);
  formData.append('new_password', newPassword);
  console.log(name , email , newPassword);

  // Send data to the backend using Fetch API
  fetch('../../api/update_profile.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.userId) {
      console.log('User ID:', data.userId);
    }
    if (data.success) {
      alert(data.success);
      closeProfileModal(); // Close modal after successful update
    } else {
      alert(data.error); // Show error if any
    }
  })
  .catch(error => console.error('Error updating profile:', error));
});

