<?php
// Nếu gọi từ trang Product.php thì không cần require lại model nếu đã có sẵn
if (!isset($product)) {
    require_once '../../../models/Product.php';
    $product = new Product();
}

// Xử lý xóa mềm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $productId = $_POST['delete_product_id'] ?? 0;

    if ($product->delete($productId)) {
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

<!-- Modal xác nhận xóa sản phẩm -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="modules/Admin/Products/DeleteProduct.php">
                <input type="hidden" name="delete_product" value="1">
                <input type="hidden" name="delete_product_id" id="deleteProductId">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteProductModalLabel">
                        <i class="fas fa-triangle-exclamation me-2"></i> Xác nhận xóa sản phẩm
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="deleteProductName"></strong>?</p>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

