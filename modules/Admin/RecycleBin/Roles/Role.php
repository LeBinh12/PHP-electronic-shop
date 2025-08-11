<?php
$keyword = $_GET['search'] ?? '';
$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalRole = $roleController->countRole($keyword, 1);
$totalPages = ceil($totalRole / $limit);

$listDeletedRoles = $roleController->getPagination($keyword, $limit, $offset, 1);

$totalRolesIsDeleted = $roleController->countIsDeleted();

?>

<?php require_once 'RestoreRole.php'; ?>
<?php require_once 'DeleteRole.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap p-3 rounded shadow-sm bg-light border">
        <h4 class="mb-0 fw-bold text-danger d-flex align-items-center">
            <i class="fas fa-trash-alt me-2"></i> Thùng rác - Quyền đã xóa
        </h4>
        <span class="badge bg-danger px-3 py-2 fs-6">
            <?= $totalRolesIsDeleted ?> mục đã xóa
        </span>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên quyền</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedRoles as $role): ?>
                    <tr>
                        <td><?= $role['id'] ?></td>
                        <td><?= htmlspecialchars($role['role_name']) ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreRoleModal"
                                    data-id="<?= $role['id'] ?>"
                                    data-name="<?= htmlspecialchars($role['role_name']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteRoleModal"
                                    data-id="<?= $role['id'] ?>"
                                    data-name="<?= htmlspecialchars($role['role_name']) ?>">
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
            document.getElementById('restoreRoleId').value = button.getAttribute('data-id');
            document.getElementById('restoreRoleName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteRoleId').value = button.getAttribute('data-id');
            document.getElementById('deleteRoleName').textContent = button.getAttribute('data-name');
        });
    });
</script>