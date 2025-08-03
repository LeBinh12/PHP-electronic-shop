<?php
// Dữ liệu ảo khách hàng đã xóa
$listDeletedCustomers = [
    ['id' => 101, 'name' => 'Nguyễn Văn A', 'phone' => '0901234567', 'email' => 'a@gmail.com', 'status' => 'Bị khóa'],
    ['id' => 102, 'name' => 'Trần Thị B', 'phone' => '0909876543', 'email' => 'b@gmail.com', 'status' => 'Bị xóa'],
    ['id' => 103, 'name' => 'Lê Văn C', 'phone' => '0911222333', 'email' => 'c@gmail.com', 'status' => 'Bị khóa'],
];
?>

<?php require_once 'RestoreCustomer.php'; ?>
<?php require_once 'DeleteCustomer.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <h4 class="mb-0 text-danger"><i class="fas fa-user-slash me-2"></i>Khách hàng đã xóa</h4>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedCustomers as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['phone']) ?></td>
                        <td><?= htmlspecialchars($item['email']) ?></td>
                        <td><?= $item['status'] ?></td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreCustomerModal"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteCustomerModal"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name']) ?>">
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
            document.getElementById('restoreCustomerId').value = button.getAttribute('data-id');
            document.getElementById('restoreCustomerName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteCustomerId').value = button.getAttribute('data-id');
            document.getElementById('deleteCustomerName').textContent = button.getAttribute('data-name');
        });
    });
</script>
