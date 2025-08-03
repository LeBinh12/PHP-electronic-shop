<?php
// Dữ liệu ảo danh mục đã bị xóa
$listDeletedCategories = [
    ['id' => 1, 'name' => 'Điện thoại', 'icon' => 'fas fa-mobile-alt', 'status' => 'Ẩn'],
    ['id' => 2, 'name' => 'Laptop', 'icon' => 'fas fa-laptop', 'status' => 'Hiện'],
    ['id' => 3, 'name' => 'Phụ kiện', 'icon' => 'fas fa-headphones', 'status' => 'Ẩn'],
];
?>

<?php require_once 'RestoreCategory.php'; ?>
<?php require_once 'DeleteCategory.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <h4 class="mb-0 text-danger"><i class="fas fa-trash-alt me-2"></i>Danh mục đã xóa</h4>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Biểu tượng</th>
                    <th>Trạng thái</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedCategories as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><i class="<?= $item['icon'] ?>"></i></td>
                        <td><?= $item['status'] ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreCategoryModal"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteCategoryModal"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name']) ?>">
                                    <i class="fas fa-trash-alt me-1"></i> Xóa
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    const restoreButtons = document.querySelectorAll('.restore-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');

    restoreButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('restoreCategoryId').value = button.getAttribute('data-id');
            document.getElementById('restoreCategoryName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteCategoryId').value = button.getAttribute('data-id');
            document.getElementById('deleteCategoryName').textContent = button.getAttribute('data-name');
        });
    });
</script>