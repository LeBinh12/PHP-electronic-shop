<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $productId = $_POST['delete_product_id'] ?? 0;
    $result = $product->delete($productId);
    if ($result['success']) {
        echo "<script>
            alert('Xóa sản phẩm thành công!');
            window.location.href = '../../Admin.php?page=modules/Admin/Products/Product.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Xóa sản phẩm thất bại!');
            window.location.href = '../../Admin.php?page=modules/Admin/Products/Product.php';
        </script>";
        exit;
    }
}
?>

<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">

                <input type="hidden" name="delete_product" value="1">
                <input type="hidden" name="delete_product_id" id="deleteProductId">

                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title d-flex align-items-center" id="deleteProductModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Xác nhận xóa
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="deleteProductName"></strong>?</p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash me-1"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>