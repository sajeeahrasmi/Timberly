
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
        (item.productType === 'Furniture' && item.furnitureStatus === 'Pending') ||
        (item.productType === 'Customized_Furniture' && item.customStatus === 'Pending')
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
            furnitureItems: [], // Initialize furniture items array
            customItems: [] // Initialize customized furniture items array
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
        } else if (item.productType === 'Customized_Furniture') {
          orders[item.orderId].customItems.push({
            itemId: item.customItemId,
            qty: item.customQty,
            itemStatus: item.customStatus,
            description: item.customDescription,
            woodType: item.customWoodType,
            size: `${item.customLength} x ${item.customWidth}`,
            frame: item.customFrame,
            unitPrice: item.customUnitPrice,
            image: item.customImage
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
            <b>Unit Price: ${item.unitPrice || 'To be decided'}</b><br>
          </div>`
        ).join('');

        // Create HTML for customized furniture items
        const customItemsHTML = order.customItems.map(item => 
          `<div class="item-details customized-furniture">
            <strong>Customized Furniture:</strong><br>
            Item ID: ${item.itemId}<br>
            Description: ${item.description || 'N/A'}<br>
            Wood Type: ${item.woodType}<br>
            Size: ${item.size}<br>
            Frame: ${item.frame}<br>
            Qty: ${item.qty}<br>
            <b>Unit Price: ${item.unitPrice || 'To be decided'}</b><br>
            
            
          </div>`
        ).join('');

        // Combine all items (Lumber, Furniture, Customized Furniture)
        const itemsHTML = lumberItemsHTML + furnitureItemsHTML + customItemsHTML;

        row.innerHTML = `
          <td>${order.customerId}</td>
          <td>${order.customerName}</td>
          <td>${order.orderId}</td>
          <td>${itemsHTML || 'No pending items found'}</td>
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
/*

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
};*/
/*
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
});*/

function checkPaymentStatus() {
  fetch('../../api/check_new_payments.php')
    .then(response => response.json())
    .then(data => {
      const paymentLink = document.getElementById('payment-link');
      
      // If there are unpaid payments, glow the link
      if (data.unpaidPayments > 0) {
        paymentLink.classList.add('glow');
      } else {
        paymentLink.classList.remove('glow');
      }
    })
    .catch(error => {
      console.error('Error fetching payment status:', error);
    });
}

// Poll every 5 seconds
setInterval(checkPaymentStatus, 2000);


document.addEventListener("DOMContentLoaded", function () {
  fetch('../../api/fetchRevenue.php')
    .then(response => response.json())
    .then(data => {
      const revenue = data.revenue || 0;
      const revenueElement = document.querySelector(".metric-value");
      revenueElement.textContent = `Rs.${parseFloat(revenue).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
    })
    .catch(error => {
      console.error("Error fetching revenue:", error);
    });
});

document.addEventListener("DOMContentLoaded", function () {
  fetch('../../api/fOrdersCount.php') // adjust path as needed
    .then(response => response.json())
    .then(data => {
      console.log("Order count data:", data);

      const orderCount = data.order_count || 0;
      const orderCountElement = document.querySelectorAll(".metric-card")[1] // or a more specific selector
        .querySelector(".metric-value");

      if (orderCountElement) {
        orderCountElement.textContent = orderCount;
      } else {
        console.error("Order count element not found.");
      }
    })
    .catch(error => {
      console.error("Error fetching order count:", error);
    });
});

document.addEventListener("DOMContentLoaded", function () {
  fetch('../../api/fFurnitureCount.php')
    .then(response => response.json())
    .then(data => {
      console.log("Furniture count data:", data);
      const count = data.furniture_count || 0;
      const furnitureElement = document.querySelector("#furniture-count");
      if (furnitureElement) {
        furnitureElement.textContent = count;
      }
    })
    .catch(error => {
      console.error("Error fetching furniture count:", error);
    });
});

function checkNotifications() {
  fetch('../../api/check_notifi.php')
      .then(res => res.json())
      .then(data => {
          const icon = document.getElementById('notificationIcon');
          if (data.hasPending) {
              icon.classList.add('glow');
          } else {
              icon.classList.remove('glow');
          }
      });
}

// Run on load
checkNotifications();

// Optional: run every 30 seconds
setInterval(checkNotifications, 2000);


function checkDateChanged() {
 
  if (localStorage.getItem('dateChangedAlerted')) {
      return; 
  }

  fetch('../../api/checkDateChanged.php') 
      .then(response => response.json())
      .then(data => {
          if (data.dateChanged === 'yes') {
              alert('The date has been updated for orderId: ' + data.orderId);
              
              localStorage.setItem('dateChangedAlerted', 'true');
          }
      })
      .catch(error => console.error('Error:', error));
}
checkDateChanged();

// Check for changes every 1 seconds
//setInterval(checkDateChanged, 1000);