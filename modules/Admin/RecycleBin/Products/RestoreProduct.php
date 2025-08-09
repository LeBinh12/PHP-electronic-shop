<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore_product'])) {
    $id = $_POST['restore_product_id'];

    $result = $product->restore($id);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/RecycleBin/Products/Product.php'</script>";
    exit;
}
?>

<div class="modal fade" id="restoreProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title"><i class="fas fa-undo me-2"></i> Xác nhận khôi phục</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" name="restore_product_id" id="restore-product-id">
                    <i class="fas fa-undo fa-3x text-success mb-3"></i>
                    <p>Bạn có chắc muốn khôi phục sản phẩm <strong id="restore-product-name"></strong> không?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" name="restore_product" class="btn btn-success">Khôi phục</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const restoreModal = document.getElementById('restoreProductModal');
        restoreModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            document.getElementById('restore-product-id').value = id;
            document.getElementById('restore-product-name').textContent = name;
        });
    });
</script>