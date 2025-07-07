<?php
// Xử lý cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
    $id = $_POST['category_id'] ?? null;
    $name = $_POST['name'] ?? '';
    $status = $_POST['status'] ?? 1;
    $icon = $_POST['icon'] ?? '';

    $data = [
        'name' => $name,
        'status' => $status,
        'icon' => $icon
    ];

    $result = $category->edit($id, $data);
    if ($result['success']) {
        echo "<script>
            alert('Cập nhật nhà cung cấp thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Categories/Category.php';
        </script>";
        exit;
    } else {
        $errorMessageUpdate = $result['message'];
    }
}
?>

<!-- Modal sửa danh mục -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="update_category" value="1">
                <input type="hidden" name="category_id" id="editCategoryId">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editCategoryModalLabel">
                        <i class="fas fa-pen-to-square me-2"></i> Cập nhật loại sản phẩm
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input type="text" name="name" id="editCategoryName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Biểu tượng (icon)</label>
                        <input type="text" name="icon" id="editCategoryIcon" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" id="editCategoryStatus" class="form-select">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Cập nhật
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openEditCategoryModal(id, name, icon, status) {
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryIcon').value = icon;
        document.getElementById('editCategoryStatus').value = status;

        let modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        modal.show();
    }
</script>