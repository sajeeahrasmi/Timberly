function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    const selectedTab = document.getElementById(tabId);
    if (selectedTab) {
        selectedTab.style.display = 'block';
        document.querySelector(`.tab-btn[data-tab="${tabId}"]`).classList.add('active');
    }
}

document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const tabId = btn.getAttribute('data-tab');
        history.replaceState(null, null, `#${tabId}`);
        showTab(tabId);
    });
});

const initialTab = window.location.hash.substring(1);
showTab(initialTab === 'timber' || initialTab === 'lumber' ? initialTab : 'lumber');

function confirmDelete(id, type) {
  if (confirm("Are you sure you want to delete this post?")) {
    window.location.href = `displayPost.php?delete=true&id=${id}&type=${type}`;
  }
}

function confirmUpdate(id, category) {
  if (confirm("Are you sure you want to update this post?")) {
    window.location.href = `updatePost.php?id=${id}&category=${category}`;
  }
}
