<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $id = $_POST['delete_category_id'] ?? null;

    if ($id) {
        $result = $category->delete($id); // Xóa mềm: cập nhật isDeleted = 1
        if ($result['success']) {
            echo "<script>
            alert('Xóa loại sản phẩm thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Categories/Category.php';
        </script>";
            exit;
        } else {
            $deleteError = $result['message'];
        }
    }
}
?>
<!-- Modal xác nhận xóa danh mục -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="delete_category" value="1">
                <input type="hidden" name="delete_category_id" id="deleteCategoryId">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">
                        <i class="fas fa-trash-alt me-2"></i> Xác nhận xóa loại sản phẩm
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa loại sản phẩm <strong id="deleteCategoryName"></strong>?</p>
                    <?php if (!empty($deleteError)): ?>
                        <div class="alert alert-danger"><?= $deleteError ?></div>
                    <?php endif; ?>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-category-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;

                document.getElementById('deleteCategoryId').value = id;
                document.getElementById('deleteCategoryName').innerText = name;

                const modal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
                modal.show();
            });
        });
    });
</script>