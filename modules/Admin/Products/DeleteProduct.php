<?php
// Xử lý xóa mềm
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<h3>Không tìm thấy sản phẩm!</h3>";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $productId = $_POST['delete_product_id'] ?? 0;
    if ($product->delete($productId)) {
        header("Location: Admin.php?page=modules/Admin/Products/Product.php");
        exit;
    } else {
        $deleteError = "Xóa sản phẩm thất bại.";
    }
}
?>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="delete_product" value="1">
                <input type="hidden" name="delete_product_id" id="deleteProductId">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteProductModalLabel">
                        <i class="fas fa-triangle-exclamation me-2"></i> Xác nhận xóa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="deleteProductName"></strong>?</p>
                    <?php if (!empty($deleteError)): ?>
                        <div class="alert alert-danger"><?= $deleteError ?></div>
                    <?php endif; ?>
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

<!-- JS đổ dữ liệu vào modal -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".delete-btn");

        deleteButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                document.getElementById("deleteProductId").value = this.dataset.id;
                document.getElementById("deleteProductName").textContent = this.dataset.name;
            });
        });
    });
</script>