document.addEventListener("DOMContentLoaded", function () {
  const editModal = document.getElementById("editRoleModal");
  editModal.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute("data-id");
    const name = button.getAttribute("data-name");

    document.getElementById("editRoleId").value = id;
    document.getElementById("editRoleName").value = name;
  });
});

document
  .querySelector("#addRoleModal form")
  .addEventListener("submit", function (e) {
    const checked = this.querySelectorAll('input[name="menu_ids[]"]:checked');
    if (checked.length === 0) {
      alert("Vui lòng chọn ít nhất 1 chức năng cho quyền!");
      e.preventDefault();
    }
  });
