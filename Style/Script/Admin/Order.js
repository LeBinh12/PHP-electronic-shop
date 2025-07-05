
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

document.addEventListener("DOMContentLoaded", function () {
    const changeStatusButtons = document.querySelectorAll('.change-status-btn');
    const inputId = document.getElementById('change-status-id');

    changeStatusButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            inputId.value = id;
        });
    });
});


});
