<?php
// Dữ liệu giả lập đơn hàng đã bị xóa
$listDeletedOrders = [
    [
        'id' => 501,
        'customer_name' => 'Nguyễn Văn A',
        'order_date' => '2025-07-10 14:23',
        'status' => 'đã hủy',
        'total_amount' => 1200000,
        'staff_name' => 'Trần Thị B'
    ],
    [
        'id' => 502,
        'customer_name' => 'Trần Thị C',
        'order_date' => '2025-07-12 10:05',
        'status' => 'đã hủy',
        'total_amount' => 950000,
        'staff_name' => 'Nguyễn Văn D'
    ],
];
?>

<?php require_once 'RestoreOrder.php'; ?>
<?php require_once 'DeleteOrder.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <h4 class="mb-0 text-danger"><i class="fas fa-box me-2"></i>Đơn hàng đã xóa</h4>
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
                        <td><?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                        <td><span class="badge bg-danger"><?= ucfirst($order['status']) ?></span></td>
                        <td><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
                        <td><?= htmlspecialchars($order['staff_name']) ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreOrderModal"
                                    data-id="<?= $order['id'] ?>"
                                    data-name="Đơn hàng #<?= $order['id'] ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteOrderModal"
                                    data-id="<?= $order['id'] ?>"
                                    data-name="Đơn hàng #<?= $order['id'] ?>">
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
