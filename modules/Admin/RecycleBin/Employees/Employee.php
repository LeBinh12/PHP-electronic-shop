<?php
// Dữ liệu giả lập nhân viên đã bị xóa
$keyword = $_GET['search'] ?? '';
$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalEmployees = $employeeController->countEmployees($keyword, 1);
$totalPages = ceil($totalEmployees / $limit);

$listDeletedEmployees = $employeeController->getPagination($keyword, $limit, $offset, 1);
?>

<?php require_once 'RestoreEmployee.php'; ?>
<?php require_once 'DeleteEmployee.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap p-3 rounded shadow-sm bg-light border">
        <h4 class="mb-0 fw-bold text-danger d-flex align-items-center">
            <i class="fas fa-trash-alt me-2"></i> Thùng rác - Nhân viên đã xóa
        </h4>
        <span class="badge bg-danger px-3 py-2 fs-6">
            <?= $totalEmployees ?> mục đã xóa
        </span>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên nhân viên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Vị trí</th>
                    <th>Địa chỉ</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedEmployees as $emp): ?>
                    <tr>
                        <td><?= $emp['id'] ?></td>
                        <td><?= htmlspecialchars($emp['name']) ?></td>
                        <td><?= htmlspecialchars($emp['email']) ?></td>
                        <td><?= htmlspecialchars($emp['phone']) ?></td>
                        <td><?= htmlspecialchars($emp['position']) ?></td>
                        <td><?= htmlspecialchars($emp['address']) ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreEmployeeModal"
                                    data-id="<?= $emp['id'] ?>"
                                    data-name="<?= htmlspecialchars($emp['name']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteEmployeeModal"
                                    data-id="<?= $emp['id'] ?>"
                                    data-name="<?= htmlspecialchars($emp['name']) ?>">
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
            document.getElementById('restoreEmployeeId').value = button.getAttribute('data-id');
            document.getElementById('restoreEmployeeName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteEmployeeId').value = button.getAttribute('data-id');
            document.getElementById('deleteEmployeeName').textContent = button.getAttribute('data-name');
        });
    });
</script>