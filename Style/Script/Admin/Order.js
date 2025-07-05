
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-order-btn");
    const inputDeleteId = document.getElementById("delete-order-id");

    deleteButtons.forEach(button => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("data-id");
            inputDeleteId.value = id;
        });
    });

    // Xử lý chuyển trạng thái
    const changeButtons = document.querySelectorAll(".change-status-btn");
    const inputStatusId = document.getElementById("change-status-id");

    changeButtons.forEach(button => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("data-id");
            inputStatusId.value = id;
        });
    });
});
