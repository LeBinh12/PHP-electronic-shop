document.addEventListener("DOMContentLoaded", function () {
  const editModal = document.getElementById("editBranchModal");
  editModal.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget;
    document.getElementById("edit-id").value = button.getAttribute("data-id");
    document.getElementById("edit-name").value =
      button.getAttribute("data-name");
    document.getElementById("edit-address").value =
      button.getAttribute("data-address");
    document.getElementById("edit-phone").value =
      button.getAttribute("data-phone");
    document.getElementById("edit-email").value =
      button.getAttribute("data-email");
  });
});
