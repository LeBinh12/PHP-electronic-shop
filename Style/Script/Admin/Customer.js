document.addEventListener("DOMContentLoaded", function () {
  const editButtons = document.querySelectorAll(
    '[data-bs-target="#editCustomerModal"]'
  );
  const form = document.getElementById("editCustomerForm");
  const phoneInput = document.getElementById("edit-phone");
  const emailInput = document.getElementById("edit-email");
  const phoneError = document.getElementById("phoneError");
  const emailError = document.getElementById("emailError");
  const saveButton = document.getElementById("saveCustomerBtn");

  // Đổ dữ liệu vào modal
  editButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      document.getElementById("edit-customer-id").value = btn.dataset.id;
      document.getElementById("edit-fullname").value = btn.dataset.fullname;
      document.getElementById("edit-address").value = btn.dataset.address;
      phoneInput.value = btn.dataset.phone;
      emailInput.value = btn.dataset.email;
      phoneError.textContent = "";
      emailError.textContent = "";
    });
  });

  // Chỉ cho nhập số điện thoại (tối đa 10)
  phoneInput.addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, "");
    if (this.value.length > 10) {
      this.value = this.value.slice(0, 10);
      phoneError.textContent = "Không được quá 10 số.";
    } else {
      phoneError.textContent = "";
    }
  });

  // Validate khi lưu
  saveButton.addEventListener("click", function () {
    const phone = phoneInput.value.trim();
    const email = emailInput.value.trim();
    let valid = true;

    if (!/^[0-9]{10}$/.test(phone)) {
      phoneError.textContent = "Số điện thoại phải đúng 10 số.";
      valid = false;
    } else {
      phoneError.textContent = "";
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      emailError.textContent = "Email không hợp lệ.";
      valid = false;
    } else {
      emailError.textContent = "";
    }

    if (valid) form.submit();
  });

  // Xử lý report
  const reportButtons = document.querySelectorAll(".btn-report-customer");
  const inputReportUserId = document.getElementById("report-user-id");

  reportButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      inputReportUserId.value = btn.dataset.id;
    });
  });
  // Xử lý xóa khách hàng
     const deleteCustomerModal = document.getElementById('deleteCustomerModal');
  deleteCustomerModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const customerId = button.getAttribute('data-id');
    const customerName = button.getAttribute('data-name');

    deleteCustomerModal.querySelector('#deleteCustomerId').value = customerId;
    deleteCustomerModal.querySelector('#deleteCustomerName').textContent = customerName;
    deleteCustomerModal.querySelector('#deleteCustomerReason').value = '';
  });
});
