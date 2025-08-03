<?php
// Dữ liệu giả lập các quyền đã bị xóa
$listDeletedRoles = [
    ['id' => 601, 'name' => 'Admin hệ thống'],
    ['id' => 602, 'name' => 'Nhân viên bán hàng'],
    ['id' => 603, 'name' => 'Chăm sóc khách hàng'],
];
?>

<?php require_once 'RestoreRole.php'; ?>
<?php require_once 'DeleteRole.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <h4 class="mb-0 text-danger"><i class="fas fa-user-shield me-2"></i>Quyền đã xóa</h4>
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
                        <td><?= htmlspecialchars($role['name']) ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#restoreRoleModal"
                                        data-id="<?= $role['id'] ?>"
                                        data-name="<?= htmlspecialchars($role['name']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteRoleModal"
                                        data-id="<?= $role['id'] ?>"
                                        data-name="<?= htmlspecialchars($role['name']) ?>">
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