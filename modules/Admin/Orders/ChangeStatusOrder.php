
<?php
// require_once '../../../models/Order.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $orderModel = new Order(); // hoặc OrderModel
        // Giả sử trạng thái "2" là "Đã xác nhận"
        $orderModel->updateStatus($id, 2);
    }
    header("Location: Admin.php?page=modules/Admin/Orders/Order.php");
    exit;
}
?>
<!-- MODAL CHUYỂN TRẠNG THÁI -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="Admin.php?page=modules/Admin/Orders/ChangeStatus.php">
            <input type="hidden" name="id" id="change-status-id">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="changeStatusModalLabel">Chuyển trạng thái đơn hàng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn chuyển trạng thái đơn hàng này sang <strong>"Đã xác nhận"</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-warning">Chuyển</button>
                </div>
            </div>
        </form>
    </div>
</div>

