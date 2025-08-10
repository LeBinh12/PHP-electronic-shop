<?php
$keyword = $_GET["search"] ?? "";
$page    = max(1, ($_GET['pageNumber'] ?? 1));
$limit   = 6;
$offset  = ($page - 1) * $limit;
$status_id = $_GET['status_id'] ?? null;
if ($status_id === '0') {
    $status_id = null;
}


$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
$employeeId = $isAdmin ? null : ($employeeData->id ?? null);
$branch_id = $isAdmin ? null : ($employeeData->branch_id ?? null);

// Lấy dữ liệu từ controller
$listDeletedOrders = $orderController->getOrderWithStatusPagination($status_id, $limit, $offset, $keyword, $branch_id, $employeeId, $isAdmin, 1);
$totalRows = $orderController->getCountOrderWithStatus($status_id, $keyword, $employeeId, $branch_id, $isAdmin, 1);
$totalPages = max(1, ceil($totalRows / $limit));

?>

<?php require_once 'RestoreOrder.php'; ?>
<?php require_once 'DeleteOrder.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap p-3 rounded shadow-sm bg-light border">
        <h4 class="mb-0 fw-bold text-danger d-flex align-items-center">
            <i class="fas fa-trash-alt me-2"></i> Thùng rác - Đơn hàng đã xóa
        </h4>
        <span class="badge bg-danger px-3 py-2 fs-6">
            <?= $totalRows ?> mục đã xóa
        </span>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Người đặt</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Nhân viên phụ trách</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedOrders as $order): ?>
                    <tr>
                        <td><?= $order['code'] ?></td>
                        <td><?= htmlspecialchars($order['FullName']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($order['create_at'])) ?></td>
                        <td><span class="badge bg-danger"><?= ucfirst($order['status_name']) ?></span></td>
                        <td><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
                        <td>
                            <?= $order['employee_id'] ? "Đã có người nhận" : 'không có nhân viên phụ trách' ?>
                        </td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreOrderModal"
                                    data-id="<?= $order['order_id'] ?>"
                                    data-name="Đơn hàng #<?= $order['code'] ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteOrderModal"
                                    data-id="<?= $order['order_id'] ?>"
                                    data-name="Đơn hàng #<?= $order['code'] ?>">
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
            document.getElementById('restoreOrderId').value = button.getAttribute('data-id');
            document.getElementById('restoreOrderName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteOrderId').value = button.getAttribute('data-id');
            document.getElementById('deleteOrderName').textContent = button.getAttribute('data-name');
        });
    });
</script>