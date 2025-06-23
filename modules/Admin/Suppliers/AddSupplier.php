<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_supplier'])) {
    $name = $_POST['name'] ?? '';
    $contact_person = $_POST['contact_person'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    $data = [
        'name' => $name,
        'contact_person' => $contact_person,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'isDeleted' => 0
    ];

    $result = $supplier->add($data);
    if ($result['success']) {
        header(header: "Location: Admin.php?page=modules/Admin/Suppliers/Supplier.php");
        exit;
    } else {
        $errorMessage = $result['message'];
    }
}

$listSupplier = $supplier->getAll();
?>

<!-- Modal thêm nhà cung cấp -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="add_supplier" value="1">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addSupplierModalLabel">
                        <i class="fas fa-truck me-2"></i> Thêm nhà cung cấp mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <?php if (!empty($errorMessage)) : ?>
                        <div class="alert alert-danger"><?= $errorMessage ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Tên nhà cung cấp</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Người liên hệ</label>
                        <input type="text" name="contact_person" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <textarea name="address" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Thêm
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>