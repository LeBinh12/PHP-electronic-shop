// document.addEventListener('DOMContentLoaded', function() {
//     const modal = document.getElementById('editItemModal');
//     if (modal) {
//         modal.addEventListener('hidden.bs.modal', function() {
//             const backdrop = document.querySelector('.modal-backdrop');
//             if (backdrop) {
//                 backdrop.remove();
//             }
//         });
//     }
// });
  document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('editSupplierModal');
    editModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      document.getElementById('editSupplierId').value = button.getAttribute('data-id');
      document.getElementById('editSupplierName').value = button.getAttribute('data-name');
      document.getElementById('editSupplierContact').value = button.getAttribute('data-contact');
      document.getElementById('editSupplierPhone').value = button.getAttribute('data-phone');
      document.getElementById('editSupplierEmail').value = button.getAttribute('data-email');
      document.getElementById('editSupplierAddress').value = button.getAttribute('data-address');
      document.getElementById('editSupplierPreview').src = button.getAttribute('data-image') || 'path/to/no-image.png';
    });

    const deleteModal = document.getElementById('deleteSupplierModal');
    deleteModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      document.getElementById('deleteSupplierId').value = button.getAttribute('data-id');
      document.getElementById('deleteSupplierName').innerText = button.getAttribute('data-name');
    });

    // Xử lý backdrop nếu modal đóng thủ công
    document.querySelectorAll('.modal').forEach(modalEl => {
      modalEl.addEventListener('hidden.bs.modal', () => {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
      });
    });
  });