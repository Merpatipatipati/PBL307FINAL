document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("editModal");
    const closeBtn = modal?.querySelector(".close2");
    
    const productNameInput = document.getElementById("productName");
    const categoryInput = document.getElementById("category");
    const priceInput = document.getElementById("price");
    const statusInput = document.getElementById("status");
    const stockInput = document.getElementById("stock");
  
    // Validasi elemen modal dan form
    if (!modal || !closeBtn || !productNameInput || !categoryInput || !priceInput || !statusInput || !stockInput) {
      console.error("Required modal or input elements not found.");
      return;
    }
  
    /**
     * Fungsi untuk membuka modal dan mengisi data produk
     */
    const openModal = (button) => {
      const row = button.closest("tr");
      if (!row) {
        console.error("Row not found for the clicked button.");
        return;
      }
  
      const cells = row.querySelectorAll("td");
      if (cells.length < 6) {
        console.error("Insufficient cells in the selected row.");
        return;
      }
  
      // Ambil data dari sel tabel
      const productName = cells[1]?.textContent.trim();
      const category = cells[2]?.textContent.trim();
      const price = cells[3]?.textContent.replace(/[^\d.-]/g, "").trim();
      const status = cells[4]?.textContent.trim();
      const stock = cells[5]?.textContent.trim();
  
      // Update modal input fields
      modal.querySelector("h2").textContent = "Edit Product";
      productNameInput.value = productName || "";
      categoryInput.value = category || "";
      priceInput.value = price || "";
      statusInput.value = status || "";
      stockInput.value = stock || "";
  
      // Tampilkan modal dengan transisi
      modal.style.display = "block";
      modal.classList.add("show"); // Tambahkan kelas untuk efek animasi (CSS opsional)
    };
  
    /**
     * Event Delegation untuk tombol edit
     */
    document.body.addEventListener("click", (event) => {
      if (event.target.classList.contains("edit-btn")) {
        openModal(event.target);
      }
    });
  
    /**
     * Fungsi untuk menutup modal
     */
    const closeModal = () => {
      modal.classList.remove("show");
      setTimeout(() => {
        modal.style.display = "none";
      }, 300); // Waktu sesuai dengan transisi CSS
    };
  
    closeBtn.addEventListener("click", closeModal);
  
    // Tutup modal jika klik di luar area modal
    window.addEventListener("click", (event) => {
      if (event.target === modal) closeModal();
    });
  });
  