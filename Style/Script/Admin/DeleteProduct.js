
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".delete-btn");
        deleteButtons.forEach(btn => {
            btn.addEventListener("click", function () {
                document.getElementById("deleteProductId").value = this.dataset.id;
                document.getElementById("deleteProductName").textContent = this.dataset.name;
            });
        });
    });

