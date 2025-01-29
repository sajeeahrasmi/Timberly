
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

  
  document.querySelector('#orders-tbody').addEventListener('click', (event) => {
    if (event.target && event.target.classList.contains('accept-btn')) {
    
      alert('Order accepted!');
      
    } else if (event.target && event.target.classList.contains('reject-btn')) {
      
      alert('Order rejected!');
    
    }
  });

  
  document.querySelector('.notification-btn').addEventListener('click', function() {
    showSection('supplier-notification-section');
   
  });

  
    
 
});


function fetchOrders() {
  fetch('../../api/mockOrders.php')
    .then(response => response.json())
    .then(data => {
      const tbody = document.getElementById('orders-tbody');
      
      
      const pendingOrders = data.filter(order => order.status === 'Pending');

      
      tbody.innerHTML = '';

   
      pendingOrders.forEach(order => {
        const row = document.createElement('tr');
        const orderDetails = order.order_details.map(detail => 
          `Product ID: ${detail.product_id}, Quantity: ${detail.quantity}, Price: Rs.${detail.price}`).join('<br/>');

        row.innerHTML = `
          <td>${order.customer_id}</td>
          <td>${order.customer_name}</td>
          <td>${order.order_id}</td>
          <td>${orderDetails}</td> <!-- Order Details -->
          <td>Rs.${order.total}</td>
          <td>${order.status}</td>
          <td>
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
          </td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch(error => console.error('Error fetching orders:', error));
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