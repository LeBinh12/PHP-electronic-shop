<!-- Modal Khôi phục -->
<div class="modal fade" id="restoreProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Khôi phục sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="restore_product_id" id="restore-product-id">
                    <p>Bạn có chắc muốn khôi phục sản phẩm <strong id="restore-product-name"></strong> không?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="restore_product" class="btn btn-success">Khôi phục</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const restoreModal = document.getElementById('restoreProductModal');
    restoreModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        document.getElementById('restore-product-id').value = id;
        document.getElementById('restore-product-name').textContent = name;
    });
});
</script>
