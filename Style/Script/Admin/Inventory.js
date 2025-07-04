// Style/Script/Admin/Inventory.js
document.addEventListener("DOMContentLoaded", function () {
    // Xử lý nút SỬA
    const editButtons = document.querySelectorAll('button.btn-primary[data-bs-toggle="modal"][data-bs-target="#editItemModal"]');
    editButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const id = button.getAttribute("data-id");
            const productName = button.getAttribute("data-product-name");
            const stockQuantity = button.getAttribute("data-stock-quantity");

            console.log("SỬA:", { id, productName, stockQuantity }); // Debug

            const warehouseIdInput = document.getElementById("editItemWarehouseId");
            const productNameInput = document.getElementById("editItemProductName");
            const quantityInput = document.getElementById("editItemQuantity");

            if (warehouseIdInput && productNameInput && quantityInput) {
                warehouseIdInput.value = id || "";
                productNameInput.value = productName || "";
                quantityInput.value = stockQuantity || "0";
            } else {
                console.error("Thiếu element trong modal SỬA");
            }
        });
    }); 
    // Dọn backdrop khi đóng modal
    const modals = document.querySelectorAll('.modal');
    modals.forEach((modal) => {
        modal.addEventListener("hidden.bs.modal", function () {
            const backdrop = document.querySelector(".modal-backdrop");
            if (backdrop) {
                backdrop.remove();
            }
        });
    });
});
