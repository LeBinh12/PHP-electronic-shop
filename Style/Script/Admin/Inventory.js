document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(
    'button.btn-primary[data-bs-toggle="modal"]'
  );
  if (buttons.length === 0) {
    console.error(
      'No buttons with class btn-primary[data-bs-toggle="modal"] found'
    );
    return;
  }

  buttons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      const id = button.getAttribute("data-id");
      const productName = button.getAttribute("data-product-name");
      const stockQuantity = button.getAttribute("data-stock-quantity");

      console.log("Button data 123:", { id, productName, stockQuantity });

      const warehouseIdInput = document.getElementById("editItemWarehouseId");
      const productNameInput = document.getElementById("editItemProductName");
      const quantityInput = document.getElementById("editItemQuantity");
      const modal = document.getElementById("editItemModal");

      if (warehouseIdInput && productNameInput && quantityInput && modal) {
        warehouseIdInput.value = id || "";
        productNameInput.value = productName || "";
        quantityInput.value = stockQuantity || "0";
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
        // Thêm xử lý đóng modal
        modal
          .querySelector(".btn-close")
          .addEventListener("click", function () {
            modalInstance.hide();
          });
      } else {
        console.error("Missing modal elements:", {
          warehouseIdInput,
          productNameInput,
          quantityInput,
          modal,
        });
      }
    });
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("editItemModal");
  if (modal) {
    modal.addEventListener("hidden.bs.modal", function () {
      const backdrop = document.querySelector(".modal-backdrop");
      if (backdrop) {
        backdrop.remove();
      }
    });
  }
});
