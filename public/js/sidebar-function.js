// Ambil elemen yang diperlukan
const toggle = document.querySelector(".toggle");
const sidebar = document.querySelector(".sidebar");
const home = document.querySelector(".home");

// Fungsionalitas toggle sidebar
toggle.addEventListener("click", () => {
  console.log("Sidebar toggle clicked");

  // Toggle kelas untuk membuka atau menutup sidebar
  const isClosed = sidebar.classList.toggle("close");

  // Update kelas di elemen home untuk menyesuaikan tata letak
  home.classList.toggle("sidebar-closed", isClosed);
  home.classList.toggle("sidebar-open", !isClosed);

  // Tambahan visual yang lebih smooth (opsional)
  if (!isClosed) {
    sidebar.classList.add("sidebar-open");
  } else {
    sidebar.classList.remove("sidebar-open");
  }
});
