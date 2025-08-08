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

    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <!-- Nút thêm nhân viên -->
        <?php
        if (hasPermission('modules/Admin/Employees/AddEmployee.php')) {

        ?>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                <i class="bi bi-plus-circle me-2"></i> Thêm nhân viên
            </button>
        <?php
        }
        ?>

        <!-- Form tìm kiếm nhân viên -->
        <form class="search-form" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Employees/Employee.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm nhân viên...">
        </form>
    </div>

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
                            <?php
                            if (hasPermission('modules/Admin/Employees/UpdateEmployee.php')) {

                            ?>
                                <!-- Nút sửa -->
                                <button class="btn btn-primary btn-sm d-flex align-items-center justify-content-center"
                                    style="padding: 2px 8px; font-size: 16px;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editEmployeeModal"
                                    data-id="<?= $emp['id'] ?>"
                                    data-name="<?= htmlspecialchars($emp['name']) ?>"
                                    data-email="<?= htmlspecialchars($emp['email']) ?>"
                                    data-phone="<?= htmlspecialchars($emp['phone']) ?>"
                                    data-position="<?= htmlspecialchars($emp['position']) ?>"
                                    data-address="<?= htmlspecialchars($emp['address']) ?>"
                                    data-roles='<?= json_encode($employeeController->getRoleIds($emp['id'])) ?>'
                                    data-menus='<?= json_encode($employeeController->getMenuIds($emp['id'])) ?>'
                                    data-branch='<?= htmlspecialchars($emp['branch_id']) ?>'>
                                    <i class="fas fa-edit me-1"></i>Sửa
                                </button>
                            <?php
                            }
                            if (hasPermission('modules/Admin/Employees/DeleteEmployee.php')) {

                            ?>
                                <!-- Nút xóa -->
                                <button type="button"
                                    class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                    style="padding: 2px 8px; font-size: 16px; "
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteEmployeeModal"
                                    data-id="<?= $emp['id'] ?>"
                                    data-name="<?= htmlspecialchars($emp['name']) ?>">
                                    <i class="fas fa-trash-alt me-1"></i>Xóa
                                </button>
                            <?php
                            }
                            ?>
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


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lắng nghe submit form trong các modal employee
        document.querySelectorAll(
            "#addEmployeeModal form, \
         #editEmployeeModal form, \
         #deleteEmployeeModal form"
        ).forEach(form => {
            form.addEventListener("submit", function() {
                Loading(true);
            });
        });

        // Lắng nghe click nút submit trong các modal employee
        document.querySelectorAll(
            "#addEmployeeModal button[type=submit], \
         #editEmployeeModal button[type=submit], \
         #deleteEmployeeModal button[type=submit]"
        ).forEach(btn => {
            btn.addEventListener("click", function() {
                Loading(true);
            });
        });

        // Lắng nghe submit form tìm kiếm
        const searchForm = document.querySelector(".search-form");
        if (searchForm) {
            searchForm.addEventListener("submit", function() {
                Loading(true);
            });
        }

        // Lắng nghe click phân trang
        document.querySelectorAll(".pagination .page-link").forEach(link => {
            link.addEventListener("click", function() {
                Loading(true);
            });
        });
    });
</script>