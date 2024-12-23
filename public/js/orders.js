document.addEventListener("DOMContentLoaded", () => {
  const editBtns = document.querySelectorAll(".edit-btn");
  const modal = document.getElementById("editModal");
  const closeBtn = document.querySelector(".close");

  const customerNameInput = document.getElementById("customerName");
  const productInput = document.getElementById("product");
  const statusInput = document.getElementById("status");
  const totalInput = document.getElementById("total");
  const orderDateInput = document.getElementById("orderDate");

  editBtns.forEach(btn => {
    btn.addEventListener("click", (event) => {
      const row = event.target.closest("tr");
      const cells = row.querySelectorAll("td");

      // Extract values from each cell based on column order
      const orderId = cells[0].textContent.trim();
      const customerName = cells[1].textContent.trim();
      const product = cells[2].textContent.trim();
      const status = cells[3].textContent.trim();
      const total = cells[4].textContent.trim();  // Remove $ sign if present
      const orderDate = cells[5].textContent.trim();

      // Update modal form with extracted data
      modal.querySelector("h2").textContent = `Edit Order ${orderId}`;
      customerNameInput.value = customerName;
      productInput.value = product;
      statusInput.value = status;
      totalInput.value = total;
      orderDateInput.value = new Date(orderDate).toISOString().split('T')[0]; // Format date for input

      // Show the modal
      modal.style.display = "block";
    });
  });

  closeBtn.onclick = () => {
    modal.style.display = "none";
  };

  window.onclick = event => {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
});
