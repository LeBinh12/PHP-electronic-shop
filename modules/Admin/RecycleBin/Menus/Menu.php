<?php
// Dữ liệu giả lập menu đã bị xóa
$listDeletedMenus = [
    ['id' => 301, 'name' => 'Quản lý người dùng', 'path' => '/admin/users', 'created_at' => '2024-01-05'],
    ['id' => 302, 'name' => 'Quản lý đơn hàng', 'path' => '/admin/orders', 'created_at' => '2024-03-15'],
    ['id' => 303, 'name' => 'Thống kê doanh thu', 'path' => '/admin/revenue', 'created_at' => '2024-06-01'],
];
?>

<?php require_once 'RestoreMenu.php'; ?>
<?php require_once 'DeleteMenu.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <h4 class="mb-0 text-danger"><i class="fas fa-bars me-2"></i>Chức năng đã xóa</h4>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên chức năng</th>
                    <th>Đường dẫn</th>
                    <th>Ngày tạo</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedMenus as $menu): ?>
                    <tr>
                        <td><?= $menu['id'] ?></td>
                        <td><?= htmlspecialchars($menu['name']) ?></td>
                        <td><?= htmlspecialchars($menu['path']) ?></td>
                        <td><?= $menu['created_at'] ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreMenuModal"
                                    data-id="<?= $menu['id'] ?>"
                                    data-name="<?= htmlspecialchars($menu['name']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteMenuModal"
                                    data-id="<?= $menu['id'] ?>"
                                    data-name="<?= htmlspecialchars($menu['name']) ?>">
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
            document.getElementById('restoreMenuId').value = button.getAttribute('data-id');
            document.getElementById('restoreMenuName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteMenuId').value = button.getAttribute('data-id');
            document.getElementById('deleteMenuName').textContent = button.getAttribute('data-name');
        });
    });
</script>
