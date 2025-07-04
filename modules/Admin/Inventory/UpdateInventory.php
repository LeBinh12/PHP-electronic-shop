<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_item'])) {
    $id = $_POST['id'] ?? null;
    $stockQuantity = $_POST['stock_quantity'] ?? 0;

    $data = [
        'stock_quantity' => $stockQuantity,
        'last_update' => date('Y-m-d H:i:s')
    ];

    $result = $inventory->edit($id, $data);
    if ($result['success']) {
        echo "<script>
            alert('Cập nhật sản phẩm kho thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Inventory/Inventory.php';
        </script>";
        exit;
    } else {
        $errorMessageUpdate = $result['message'];
    }
}
?>
<div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-primary fw-bold w-100 text-center">Cập nhật sản phẩm kho</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="update_item" value="1">
                <input type="hidden" name="id" id="editItemWarehouseId">
                <div class="modal-body pt-0">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" id="editItemProductName" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="stock_quantity" id="editItemQuantity" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-1"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
