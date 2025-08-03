<?php
// Dữ liệu giả lập nhà cung cấp đã xóa
$listDeletedSuppliers = [
    [
        'id' => 701,
        'name' => 'Công ty TNHH Thiết bị ABC',
        'contact' => 'Nguyễn Văn A',
        'phone' => '0912345678',
        'email' => 'abc@suppliers.vn',
        'image' => 'https://via.placeholder.com/60',
        'address' => '123 Lê Lợi, Quận 1, TP.HCM',
    ],
    [
        'id' => 702,
        'name' => 'Thiết bị Minh Long',
        'contact' => 'Trần Thị B',
        'phone' => '0933667788',
        'email' => 'minhlong@sup.vn',
        'image' => 'https://via.placeholder.com/60',
        'address' => '45 Nguyễn Trãi, Quận 5, TP.HCM',
    ],
];
?>

<?php require_once 'RestoreSupplier.php'; ?>
<?php require_once 'DeleteSupplier.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <h4 class="mb-0 text-danger"><i class="fas fa-truck me-2"></i>Nhà cung cấp đã xóa</h4>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Người liên hệ</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Ảnh</th>
                    <th>Địa chỉ</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedSuppliers as $supplier): ?>
                    <tr>
                        <td><?= $supplier['id'] ?></td>
                        <td><?= htmlspecialchars($supplier['name']) ?></td>
                        <td><?= htmlspecialchars($supplier['contact']) ?></td>
                        <td><?= $supplier['phone'] ?></td>
                        <td><?= $supplier['email'] ?></td>
                        <td><img src="<?= $supplier['image'] ?>" width="60"></td>
                        <td><?= $supplier['address'] ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#restoreSupplierModal"
                                        data-id="<?= $supplier['id'] ?>"
                                        data-name="<?= htmlspecialchars($supplier['name']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteSupplierModal"
                                        data-id="<?= $supplier['id'] ?>"
                                        data-name="<?= htmlspecialchars($supplier['name']) ?>">
                                    <i class="fas fa-trash-alt me-1"></i> Xóa
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const restoreButtons = document.querySelectorAll('.restore-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');

    restoreButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('restoreSupplierId').value = button.getAttribute('data-id');
            document.getElementById('restoreSupplierName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteSupplierId').value = button.getAttribute('data-id');
            document.getElementById('deleteSupplierName').textContent = button.getAttribute('data-name');
        });
    });
</script>
