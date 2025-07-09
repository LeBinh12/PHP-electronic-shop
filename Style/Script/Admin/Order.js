document.addEventListener("DOMContentLoaded", function () {
  // Nút XÓA
  const deleteButtons = document.querySelectorAll(".delete-order-btn");

  deleteButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const id = this.dataset.id;
      const name = this.dataset.name;

      document.getElementById("deleteOrderId").value = id;
      document.getElementById("deleteOrderName").innerText = name;

      const modal = new bootstrap.Modal(document.getElementById("deleteOrderModal"));
      modal.show();
    });
  });

  // Nút CHUYỂN TRẠNG THÁI
  const changeStatusButtons = document.querySelectorAll(".change-status-btn");
  const inputChangeStatusId = document.getElementById("change-status-id");

  changeStatusButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const id = button.getAttribute("data-id");
      if (inputChangeStatusId) {
        inputChangeStatusId.value = id;
      }
    });
  });

  // Nút SỬA
  const updateButtons = document.querySelectorAll(".btn-update-order");
  const inputId = document.getElementById("update-order-id");
  const selectStatus = document.getElementById("order-status");

  updateButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const id = button.getAttribute("data-id");
      const status = button.getAttribute("data-status");

      if (inputId && selectStatus) {
        inputId.value = id;
        selectStatus.value = status;
      } else {
        console.warn("Không tìm thấy inputId hoặc selectStatus");
      }
    });
  });

  // SHOW MODAL CHI TIẾT ĐƠN HÀNG NGAY KHI TẢI
  const viewOrderModalEl = document.getElementById("viewOrderModal");
  if (viewOrderModalEl) {
    const viewOrderModal = new bootstrap.Modal(viewOrderModalEl);
    viewOrderModal.show();
  }
});

// TĂNG GIẢM SỐ LƯỢNG – đặt ngoài vì có thể được gọi từ các sự kiện onclick
function changeQuantity(orderId, productId, delta) {
  fetch(`?orderid=${orderId}&update_quantity=1&product_id=${productId}&delta=${delta}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById(`qty-${productId}`).textContent = data.newQuantity;
      } else {
        alert(data.message || "Không thể cập nhật số lượng");
      }
    });
}
