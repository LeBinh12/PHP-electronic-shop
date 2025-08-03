<?php
$deletedBranches = [
    [
        'id' => 1,
        'name' => 'Chi nhánh Hà Nội',
        'address' => '123 Trần Duy Hưng',
        'phone' => '0987654321',
        'email' => 'hanoi@branch.vn',
        'created_at' => '2024-01-15'
    ],
    [
        'id' => 2,
        'name' => 'Chi nhánh Đà Nẵng',
        'address' => '456 Nguyễn Văn Linh',
        'phone' => '0911222333',
        'email' => 'danang@branch.vn',
        'created_at' => '2024-02-10'
    ]
];
require_once 'RestoreBranch.php';
require_once 'DeleteBranch.php';
?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <h4 class="mb-0 text-danger">
            <i class="bi bi-building-gear me-2"></i>Thùng rác - Chi nhánh
        </h4>
    </div>
</div>


<div class="table-container">
    <table class="table table-bordered table-hover custom-table">
        <thead class="table-dark">
            <tr>
                <th>Mã</th>
                <th>Tên chi nhánh</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Ngày tạo</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deletedBranches as $branch) : ?>
                <tr>
                    <td><?= $branch['id'] ?></td>
                    <td><?= htmlspecialchars($branch['name']) ?></td>
                    <td><?= htmlspecialchars($branch['address']) ?></td>
                    <td><?= $branch['phone'] ?></td>
                    <td><?= $branch['email'] ?></td>
                    <td><?= $branch['created_at'] ?></td>
                    <td>
                        <button class="btn btn-sm btn-success restore-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#restoreBranchModal"
                            data-id="<?= $branch['id'] ?>"
                            data-name="<?= htmlspecialchars($branch['name']) ?>">
                            <i class="fas fa-undo-alt me-1"></i> Khôi phục
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteBranchModal"
                            data-id="<?= $branch['id'] ?>"
                            data-name="<?= htmlspecialchars($branch['name']) ?>">
                            <i class="fas fa-trash-alt me-1"></i> Xóa
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>

<script>
    document.querySelectorAll('.restore-btn').forEach(btn => {
        btn.onclick = () => {
            document.getElementById('restoreBranchId').value = btn.getAttribute('data-id');
            document.getElementById('restoreBranchName').textContent = btn.getAttribute('data-name');
        };
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.onclick = () => {
            document.getElementById('deleteBranchId').value = btn.getAttribute('data-id');
            document.getElementById('deleteBranchName').textContent = btn.getAttribute('data-name');
        };
    });
</script>