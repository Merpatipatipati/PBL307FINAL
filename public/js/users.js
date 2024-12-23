document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const userIdInput = document.getElementById('user-id');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const statusInput = document.getElementById('status');
    const roleInput = document.getElementById('role');
  
    // Handle Edit Button Click
    editButtons.forEach(button => {
      button.addEventListener('click', function () {
        const userId = this.getAttribute('data-id');
        const row = this.closest('tr');
        const username = row.querySelector('.username').innerText.trim();
        const email = row.querySelector('.email').innerText.trim();
        const status = row.querySelector('.status').innerText.trim();
        const role = row.querySelector('.role').innerText.trim();
  
        // Populate Form
        userIdInput.value = userId;
        usernameInput.value = username;
        emailInput.value = email;
        statusInput.value = status;
        roleInput.value = role;
  
        // Update Action URL
        editForm.setAttribute('action', `/admin/users/${userId}`);
  
        // Open Modal
        editModal.style.display = 'block';
      });
    });
  
    // Close Modal
    document.querySelector('.close2').addEventListener('click', function () {
      editModal.style.display = 'none';
    });
  });