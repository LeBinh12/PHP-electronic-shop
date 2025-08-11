<?php
// Dữ liệu giả lập menu đã bị xóa
$keyword = $_GET['search'] ?? '';

$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalMenu = $menuController->countMenu($keyword, 1);

$totalPages = ceil($totalMenu / $limit);

$listDeletedMenus = $menuController->getPagination($keyword, $limit, $offset,  1);

?>

<?php require_once 'RestoreMenu.php'; ?>
<?php require_once 'DeleteMenu.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap p-3 rounded shadow-sm bg-light border">
        <h4 class="mb-0 fw-bold text-danger d-flex align-items-center">
            <i class="fas fa-trash-alt me-2"></i> Thùng rác - Chức năng đã xóa
        </h4>
        <span class="badge bg-danger px-3 py-2 fs-6">
            <?= $totalMenu ?> mục đã xóa
        </span>
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
                        <td><?= htmlspecialchars($menu['menu_name']) ?></td>
                        <td><?= htmlspecialchars($menu['menu_url']) ?></td>
                        <td><?= $menu['created_at'] ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreMenuModal"
                                    data-id="<?= $menu['id'] ?>"
                                    data-name="<?= htmlspecialchars($menu['menu_name']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteMenuModal"
                                    data-id="<?= $menu['id'] ?>"
                                    data-name="<?= htmlspecialchars($menu['menu_name']) ?>">
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