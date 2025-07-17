<?php




$keyword = $_GET['search'] ?? '';
$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalEmployees = $employeeController->countEmployees($keyword);
$totalPages = ceil($totalEmployees / $limit);

$employeeList = $employeeController->getPagination($keyword, $limit, $offset);
?>


<div class="product-container">

    <div class="d-flex justify-content-between mb-3">
        <form method="GET" action="Admin.php" class="search-form ms-auto">
            <input type="hidden" name="page" value="modules/Admin/Employees/Employee.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search" name="search" value="<?= htmlspecialchars($keyword) ?>" class="form-control search-input" placeholder="Tìm nhân viên...">
        </form>
    </div>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
        <i class="fas fa-plus-circle me-1"></i> Thêm nhân viên
    </button>

    <table class="table table-bordered custom-table">
        <thead class="table-dark">
            <tr>
                <th style="width: 60px">ID</th>
                <th>Tên nhân viên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Vị trí</th>
                <th>Địa chỉ</th>
                <th style="width: 160px">Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeList as $emp) { ?>
                <tr>
                    <td class="text-center"><?= $emp['id'] ?></td>
                    <td><?= htmlspecialchars($emp['name']) ?></td>
                    <td><?= htmlspecialchars($emp['email']) ?></td>
                    <td><?= htmlspecialchars($emp['phone']) ?></td>
                    <td><?= htmlspecialchars($emp['position']) ?></td>
                    <td><?= htmlspecialchars($emp['address']) ?></td>
                    <td class="text-center">
                        <div class="d-flex gap-2 justify-content-center">
                            <!-- Nút sửa -->
                            <button class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editEmployeeModal"
                                data-id="<?= $emp['id'] ?>"
                                data-name="<?= htmlspecialchars($emp['name']) ?>"
                                data-email="<?= htmlspecialchars($emp['email']) ?>"
                                data-phone="<?= htmlspecialchars($emp['phone']) ?>"
                                data-position="<?= htmlspecialchars($emp['position']) ?>"
                                data-address="<?= htmlspecialchars($emp['address']) ?>"
                                data-roles='<?= json_encode($employeeController->getRoleIds($emp['id'])) ?>'
                                data-menus='<?= json_encode($employeeController->getMenuIds($emp['id'])) ?>'>
                                <i class="fas fa-edit me-1"></i>Sửa
                            </button>

                            <!-- Nút xóa -->
                            <button type="button" class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteEmployeeModal"
                                data-id="<?= $emp['id'] ?>"
                                data-name="<?= htmlspecialchars($emp['name']) ?>">
                                <i class="fas fa-trash-alt me-1"></i>Xóa
                            </button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Employees/Employee.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>

</div>

<?php
require_once './modules/Admin/Employees/AddEmployee.php';
require_once './modules/Admin/Employees/DeleteEmployee.php';
require_once './modules/Admin/Employees/UpdateEmployee.php';

?>