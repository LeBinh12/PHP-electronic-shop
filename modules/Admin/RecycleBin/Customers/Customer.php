<?php
// Dữ liệu ảo khách hàng đã xóa
$keyword = $_GET['search'] ?? '';

$limit = 8;
$totalUsers = $userController->countUser($keyword, 1);

$totalPages = ceil($totalUsers / $limit);

$page = $_GET['number'] ?? 1;
$page = max(1, min($page, $totalPages));

$offset = ($page - 1) * $limit;
$listDeletedCustomers = $userController->getPagination($limit, $offset, $keyword, 1);

?>

<?php require_once 'RestoreCustomer.php'; ?>
<?php require_once 'DeleteCustomer.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <h4 class="mb-0 text-danger"><i class="fas fa-user-slash me-2"></i>Khách hàng đã xóa</h4>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedCustomers as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['FullName']) ?></td>
                        <td><?= htmlspecialchars($item['Phone']) ?></td>
                        <td><?= htmlspecialchars($item['Email']) ?></td>
                        <td> <?php
                                $reportByUserId = $userReportController->getByUserId($item['id']);

                                if ($reportByUserId && strtotime($reportByUserId['banned_until']) > time()) {
                                    echo "<span class='text-danger'>Bị cấm đến " . date('d/m/Y', strtotime($reportByUserId['banned_until'])) . "</span>";
                                } else {
                                    echo "<span class='text-success'>Đang bị xóa</span>";
                                }

                                ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreCustomerModal"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['FullName']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteCustomerModal"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['FullName']) ?>">
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
            document.getElementById('restoreCustomerId').value = button.getAttribute('data-id');
            document.getElementById('restoreCustomerName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteCustomerId').value = button.getAttribute('data-id');
            document.getElementById('deleteCustomerName').textContent = button.getAttribute('data-name');
        });
    });
</script>