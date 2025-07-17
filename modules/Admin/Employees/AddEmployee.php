<?php
$roleWithMenu = $roleController->getRoleWithMenu();
if ($_SERVER['REQUEST_METHOD'] && isset($_POST['add_employee'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $roleIds = $_POST['role_ids'] ?? [];
    $menuIds = $_POST['menu_ids'] ?? [];
    $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'position' => $position,
        'address' => $address,
        'isDeleted' => 0
    ];
    $result = $employeeController->add($data, $roleIds, $menuIds);
    if ($result['success']) {
        echo "<script>
            alert('Thêm nhân viên mới thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Employees/Employee.php';
        </script>";
        exit;
    }
}
?>



<div class="modal fade" id="addEmployeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="Admin.php?page=modules/Admin/Employees/Employee.php">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Thêm nhân viên</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Thông tin nhân viên -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên nhân viên</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Chức vụ</label>
                            <input type="text" name="position" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                    </div>

                    <!-- Quyền và chức năng -->
                    <label class="form-label">Phân quyền & chức năng:</label>
                    <div class="border p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                        <?php
                        foreach ($roleWithMenu as $role) {
                        ?>
                            <div class="mb-2">
                                <div class="form-check mb-1">
                                    <input class="form-check-input role-checkbox" type="checkbox" name="role_ids[]" value=" <?= $role['role_id'] ?>" data-role-id="<?= $role['role_id'] ?>">
                                    <label class="form-check-label fw-bold"><?= htmlspecialchars($role['role_name']) ?></label>
                                </div>

                                <?php if (!empty($role['menus'])) {
                                    foreach ($role['menus'] as $menu) {
                                ?>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input menu-checkbox" type="checkbox" name="menu_ids[]" value="<?= $menu['menu_id'] ?>" data-role-id="<?= $role['role_id'] ?>">
                                            <label class="form-check-label"><?= htmlspecialchars($menu['menu_name']) ?></label>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" name="add_employee">Thêm</button>
                </div>
            </div>
        </form>
    </div>
</div>