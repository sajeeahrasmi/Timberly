// Existing showSection function
function showSection(sectionId) {
  // Hide all sections
  const sections = document.querySelectorAll('.section');
  sections.forEach(section => section.classList.remove('active'));

  // Show the selected section
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

  // New functions for top bar interactions
  document.querySelector('.notification-btn').addEventListener('click', function() {
    showSection('supplier-notification-section');
    // Implement notification functionality here
  });

  document.querySelector('.profile-btn').addEventListener('click', function() {
    alert('Profile clicked!');
    // Implement profile dropdown or navigation here
  });
});

// Function to fetch orders and populate the table
function fetchOrders() {
  fetch('../../api/mockOrders.php')
    .then(response => response.json())
    .then(data => {
      const tbody = document.getElementById('orders-tbody');
      
      // Filter the orders to only include "Pending" orders
      const pendingOrders = data.filter(order => order.status === 'Pending');

      // Clear existing rows before adding new ones
      tbody.innerHTML = '';

      // Loop through each pending order and create a row
      pendingOrders.forEach(order => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${order.customer_id}</td>
          <td>${order.customer_name}</td>
          <td>${order.order_id}</td>
          <td>${order.order_details}</td>
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

// Fetch orders on page load
window.onload = fetchOrders;
