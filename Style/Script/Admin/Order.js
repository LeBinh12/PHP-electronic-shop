document.addEventListener("DOMContentLoaded", function () {
    // Nút XÓA
    const deleteButtons = document.querySelectorAll(".delete-order-btn");
    const inputDeleteId = document.getElementById("delete-order-id");

    deleteButtons.forEach(button => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("data-id");
            if (inputDeleteId) {
                inputDeleteId.value = id;
            }
        });
    });

    // Nút CHUYỂN TRẠNG THÁI
    const changeStatusButtons = document.querySelectorAll(".change-status-btn");
    const inputChangeStatusId = document.getElementById("change-status-id");

    changeStatusButtons.forEach(button => {
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

    updateButtons.forEach(button => {
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
});
