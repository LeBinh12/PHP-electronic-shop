<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = $_POST['name'] ?? '';
    $status = $_POST['status'] ?? 1;
    $icon = $_POST['icon'] ?? '';

    $data = [
        'name' => $name,
        'status' => $status,
        'icon' => $icon,
        'isDeleted' => 0
    ];

    $result = $category->add($data);
    if ($result['success']) {
        echo "<script>
            alert('Thêm loại sản phẩm thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Categories/Category.php';
        </script>";
        exit;
    } else {
        $errorMessage = $result['message'];
    }
}


$listCategory = $category->getAll();
?>

<!-- Modal thêm danh mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="add_category" value="1">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCategoryModalLabel">
                        <i class="fas fa-layer-group me-2"></i> Thêm loại sản phẩm mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <?php if (!empty($errorMessage)) : ?>
                        <div class="alert alert-danger"><?= $errorMessage ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Biểu tượng (icon)</label>
                        <input type="text" name="icon" class="form-control" placeholder="fa-solid fa-star">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Thêm
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>