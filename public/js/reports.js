// Fungsi untuk membuka modal dengan data laporan
function openModal(reportId, reportType) {
  // Memulai permintaan data laporan menggunakan fetch API
  fetch(`/admin/reports/${reportId}/${reportType}`, {
    method: 'GET',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Failed to load report details.');
      }
      return response.json();
    })
    .then(data => {
      // Menyuntikkan data ke modal
      const modalDetails = document.getElementById('modalDetails');
      modalDetails.innerHTML = `
        <p><strong>Reporter:</strong> ${data.reporter}</p>
        <p><strong>${reportType === 'product' ? 'Product Name' : 'Post Content'}:</strong> ${data.product_name || data.post_content}</p>
        <p><strong>${reportType === 'product' ? 'Seller' : 'Author'}:</strong> ${data.seller || data.author}</p>
        <p><strong>Reason:</strong> ${data.reason}</p>
        <p><strong>Admin Response:</strong> ${data.admin_response || 'No response yet.'}</p>
      `;
      // Menampilkan modal
      document.getElementById('responseModal').style.display = 'block';
      // Menyimpan ID laporan dan jenis laporan ke tombol submit
      const submitButton = document.getElementById('submitResponseButton');
      submitButton.dataset.id = reportId;
      submitButton.dataset.type = reportType;
    })
    .catch(error => {
      console.error('Error fetching report details:', error);
      alert('Failed to load report details. Please try again.');
    });
}

// Fungsi untuk menutup modal
function closeModal() {
  document.getElementById('responseModal').style.display = 'none';
}

// Fungsi untuk menyimpan tanggapan admin
function saveResponse() {
  const submitButton = document.getElementById('submitResponseButton');
  const reportId = submitButton.dataset.id;
  const reportType = submitButton.dataset.type;

  // Kirim permintaan POST untuk menyimpan tanggapan
  fetch(`/admin/reports/${reportId}/${reportType}/submit`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify({ status: 'Submitted' }), // Kirim hanya status
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Failed to submit response.');
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        alert('Response submitted successfully.');
        closeModal();
        // Memperbarui status di tabel
        const row = document.querySelector(`tr[data-id='${reportId}']`);
        if (row) {
          row.querySelector('td:nth-child(5)').innerText = 'Submitted'; // Update the status column to "Submitted"
        }
      } else {
        alert('Failed to submit response.');
      }
    })
    .catch(error => {
      console.error('Error submitting response:', error);
      alert('An error occurred while submitting the response.');
    });
}

// Menginisialisasi DataTables untuk tabel laporan produk dan postingan
$(document).ready(function () {
  $('#productReportsTable, #postReportsTable').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    lengthChange: false,
    autoWidth: false,
    responsive: true,
    language: {
      search: 'Filter:',
      info: 'Showing _START_ to _END_ of _TOTAL_ reports',
    },
  });

  // Menambahkan event listener untuk tombol close modal
  document.getElementById('closeModalButton').addEventListener('click', closeModal);
});
