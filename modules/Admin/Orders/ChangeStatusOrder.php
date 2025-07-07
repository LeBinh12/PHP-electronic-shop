<?php
// require_once '../../../models/Order.php';
// $orderModel = new Order();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ChangeStatus'])) {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $order = $orderController->getById($id);

        if ($order) {
            $currentStatus = (int)$order['status_id'];
            $maxStatus = 5;

            $nextStatus = ($currentStatus < $maxStatus) ? $currentStatus + 1 : 1;

            $orderController->edit($id, ["status_id" => $nextStatus]);
        }
    }

    echo "<script>
            alert('Chuyển đổi trạng thái thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Orders/Order.php';
        </script>";
    exit;
}


?>

<!-- MODAL CHUYỂN TRẠNG THÁI -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <input type="hidden" name="id" id="change-status-id">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="changeStatusModalLabel">Xác nhận chuyển trạng thái</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn chuyển trạng thái đơn hàng sang <strong>trạng thái kế tiếp</strong> không?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="ChangeStatus">Đồng ý</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>