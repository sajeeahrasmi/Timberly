<!-- Flash Message Container -->
<div id="flash-message" class="flash-message"></div>

<!-- Confirmation Dialog -->
<div id="confirm-dialog" class="confirm-dialog">
  <p id="confirm-message"></p>
  <div class="confirm-buttons">
    <button onclick="handleConfirm(true)">Yes</button>
    <button onclick="handleConfirm(false)">No</button>
  </div>
</div>

<style>
.flash-message {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 20px 30px;
  border-radius: 12px;
  font-size: 18px;
  font-family: 'Segoe UI', sans-serif;
  color: #fff;
  z-index: 9999;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease, transform 0.3s ease;
  backdrop-filter: blur(8px);
  text-align: center;
  max-width: 90%;
  width: fit-content;
}

.flash-success {
  background-color: #28a745;
  box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
}

.flash-error {
  background-color: #dc3545;
  box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.flash-message.show {
  opacity: 1;
  pointer-events: auto;
  animation: fadeInScale 0.4s ease;
}

@keyframes fadeInScale {
  from {
    transform: translate(-50%, -50%) scale(0.9);
    opacity: 0;
  }
  to {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
  }
}

.confirm-dialog {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 25px 35px;
  border-radius: 12px;
  z-index: 10000;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  text-align: center;
  display: none;
  font-family: 'Segoe UI', sans-serif;
}

.confirm-buttons {
  margin-top: 20px;
}

.confirm-buttons button {
  margin: 0 10px;
  padding: 8px 18px;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
}

.confirm-buttons button:first-child {
  background-color: #dc3545;
  color: #fff;
}

.confirm-buttons button:last-child {
  background-color: #6c757d;
  color: #fff;
}
</style>

<script>
function showFlashMessage(message, type = 'success') {
  const flash = document.getElementById('flash-message');
  flash.textContent = decodeURIComponent(message.replace(/\+/g, ' '));
  flash.className = 'flash-message show ' + (type === 'success' ? 'flash-success' : 'flash-error');

  setTimeout(() => {
    flash.classList.remove('show');
  }, 3000);
}

// Automatically show flash message from URL
const urlParams = new URLSearchParams(window.location.search);
const message = urlParams.get('message');
const type = urlParams.get('type') || 'success';
if (message) showFlashMessage(message, type);


// Confirmation Handling
let confirmCallback = null;
function showConfirmation(message, callback) {
  document.getElementById('confirm-message').textContent = message;
  document.getElementById('confirm-dialog').style.display = 'block';
  confirmCallback = callback;
}

function handleConfirm(choice) {
  document.getElementById('confirm-dialog').style.display = 'none';
  if (confirmCallback) confirmCallback(choice);
}
</script>
