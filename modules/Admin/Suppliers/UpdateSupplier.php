<?php
// Xử lý cập nhật nhà cung cấp

require_once  './././config/cloudinary.php';

use Cloudinary\Api\Upload\UploadApi;

$id = $_POST['supplier_id'] ?? null;

$oldSupplier = $supplier->getById($id);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_supplier'])) {
    $imageUrl = $oldSupplier['image_url'] ?? '';

    if (isset($_FILES['image_supplier']) && $_FILES['image_supplier']['error'] === UPLOAD_ERR_OK) {
        try {
            $uploadResult = (new UploadApi())->upload(
                $_FILES['image_supplier']['tmp_name'],
                ['folder' => 'suppliers']
            );
            $imageUrl = $uploadResult['secure_url'] ?? $imageUrl;
        } catch (Exception $e) {
            $errorMessageUpdate = 'Lỗi upload ảnh: ' . $e->getMessage();
        }
    }

    $data = [
        'name' => $_POST['name'] ?? '',
        'contact_person' => $_POST['contact_person'] ?? '',
        'Phone' => $_POST['phone'] ?? '',
        'Email' => $_POST['email'] ?? '',
        'Address' => $_POST['address'] ?? '',
        'image_url' => $imageUrl
    ];

    $result = $supplier->edit($id, $data);
    if ($result['success']) {
        echo "<script>
            alert('Cập nhật nhà cung cấp thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Suppliers/Supplier.php';
        </script>";
        exit;
    } else {
        $errorMessageUpdate = $result['message'];
    }
}
?>

<!-- Modal sửa nhà cung cấp -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="update_supplier" value="1">
                <input type="hidden" name="supplier_id" id="editSupplierId">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editSupplierModalLabel">
                        <i class="fas fa-pen-to-square me-2"></i> Cập nhật nhà cung cấp
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <?php if (!empty($errorMessageUpdate)) : ?>
                        <div class="alert alert-danger"><?= $errorMessageUpdate ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Tên nhà cung cấp</label>
                        <input type="text" name="name" id="editSupplierName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Người liên hệ</label>
                        <input type="text" name="contact_person" id="editSupplierContact" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Điện thoại</label>
                        <input type="text" name="phone" id="editSupplierPhone" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="editSupplierEmail" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" id="editSupplierAddress" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh hiện tại</label><br>
                        <img id="editSupplierPreview" src="" class="img-thumbnail mb-2" style="max-width: 200px">
                        <input type="file" name="image_supplier" class="form-control" accept="image/*">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                         Cập nhật
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script mở modal sửa -->
<!-- <script>
    function openEditSupplierModal(id, name, contact, phone, email, address, imageUrl) {
        document.getElementById('editSupplierId').value = id;
        document.getElementById('editSupplierName').value = name;
        document.getElementById('editSupplierContact').value = contact;
        document.getElementById('editSupplierPhone').value = phone;
        document.getElementById('editSupplierEmail').value = email;
        document.getElementById('editSupplierAddress').value = address;
        document.getElementById('editSupplierPreview').src = imageUrl || 'path/to/no-image.png';

        const modal = new bootstrap.Modal(document.getElementById('editSupplierModal'));
        modal.show();
    }
</script> -->