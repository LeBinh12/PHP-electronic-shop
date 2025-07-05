<?php
// require_once '../../../models/Order.php';
// $orderModel = new Order();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $order = $orderModel->getOrderById($id);

        if ($order) {
            $currentStatus = (int)$order['status_id'];
            $maxStatus = 6;

            // Nếu chưa tới trạng thái cuối thì +1, ngược lại quay về 1
            $nextStatus = ($currentStatus < $maxStatus) ? $currentStatus + 1 : 1;

            $orderModel->updateStatus($id, $nextStatus);
        }
    }

    header("Location: ../../Admin.php?page=modules/Admin/Orders/Order.php");
    exit;
}


?>

<!-- MODAL CHUYỂN TRẠNG THÁI -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="modules/Admin/Orders/ChangeStatusOrder.php">
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
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>


