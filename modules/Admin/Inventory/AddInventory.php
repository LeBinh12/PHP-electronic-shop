<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $id = $_POST['id'] ?? '';
    // $id = 22;
    $stockQuantity = $_POST['stock_quantity'] ?? 0;
    $quantityOld = $inventoryController->getById($id);
    $totalQuantity = $quantityOld['stock_quantity'] + $stockQuantity;
    $data = [
        'stock_quantity' => $totalQuantity,
        'last_update' => date('Y-m-d H:i:s')
    ];
    $result = $inventoryController->edit($id, $data);
    if ($result['success']) {
        echo "<script>
            alert('Thêm sản phẩm kho thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Inventory/Inventory.php';
        </script>";
        exit;
    } else {
        $errorMessage = $result['message'];
    }
}

?>

<div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addInventoryModalLabel">
                         Thêm nhà kho hàng mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
            <form method="POST">
                <input type="hidden" name="add_item" value="1">
                <div class="modal-body pt-0">
                    <div class="mb-3">
                        <label class="form-label">Mã kho</label>
                        <input type="text" name="id" id="addItemWarehouseId" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" id="addItemProductName" class="form-control" readonly>
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Số lượng hiện tại</label>
                        <input type="number" id="quantity" name="stock_quantity" class="form-control"readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng thêm vào</label>
                        <input type="number" name="stock_quantity" class="form-control" required min="1" placeholder="Nhập số lượng">
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-plus-circle me-1"></i> Thêm vào kho
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>