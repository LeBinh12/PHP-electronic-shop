<?php
$keyword = $_GET['search'] ?? '';

$limit = 8;
$totalUsers = $userController->countUser($keyword);

$totalPages = ceil($totalUsers / $limit);

$page = $_GET['number'] ?? 1;
$page = max(1, min($page, $totalPages));

$offset = ($page - 1) * $limit;
$customers = $userController->getPagination($limit, $offset, $keyword);


?>

<h1 class="h3">Danh sách khách hàng</h1>

<!-- Form tìm kiếm -->
<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Customers/Customer.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm khách hàng...">
        </form>
    </div>

    <?php
    require_once 'modules/Admin/Customers/UpdateCustomer.php';
    require_once 'modules/Admin/Customers/DeleteCustomer.php';
    require_once 'modules/Admin/Customers/ReportCustomer.php';
    require_once 'modules/Admin/Customers/DetailCustomer.php';
    require_once 'modules/Admin/Customers/DeleteCustomerReport.php';
    require_once 'modules/Admin/Customers/UpdatePassword.php';

    ?>

    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 20px; text-align: center">ID</th>
                            <th style="width: 150px">Họ tên</th>
                            <th style="width: 30px">Điện thoại</th>
                            <th style="width: 120px">Email</th>
                            <th style="width: 120px">Trạng thái</th>
                            <th class="text-center" style="width: 250px">Chức năng</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php foreach ($customers as $cus): ?>
                        <tr>
                            <td class="text-center"><?= $cus['id'] ?></td>
                            <td><?= htmlspecialchars($cus['FullName']) ?></td>
                            <td><?= htmlspecialchars($cus['Phone']) ?></td>
                            <td><?= htmlspecialchars($cus['Email']) ?></td>
                            <td>
                                <?php
                                $reportByUserId = $userReportController->getByUserId($cus['id']);

                                if ($reportByUserId && strtotime($reportByUserId['banned_until']) > time()) {
                                    echo "<span class='text-danger'>Bị cấm đến " . date('d/m/Y', strtotime($reportByUserId['banned_until'])) . "</span>";
                                } else {
                                    echo "<span class='text-success'>Đang hoạt động</span>";
                                }

                                ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap gap-1 justify-content-center">

                                    <!-- Chi tiết -->
                                    <button class="btn btn-sm btn-info text-white d-inline-flex align-items-center gap-1 px-2 py-1 btn-detail-customer"
                                        data-id="<?= $cus['id'] ?>"
                                        data-fullname="<?= htmlspecialchars($cus['FullName']) ?>"
                                        data-phone="<?= htmlspecialchars($cus['Phone']) ?>"
                                        data-email="<?= htmlspecialchars($cus['Email']) ?>"
                                        data-address="<?= htmlspecialchars($cus['Address']) ?>"
                                        data-created="<?= htmlspecialchars($cus['CreatedAt']) ?>"
                                        data-status="<?= ($reportByUserId && strtotime($reportByUserId['banned_until']) > time()) ? 'Bị cấm đến ' . date('d/m/Y', strtotime($reportByUserId['banned_until'])) : 'Đang hoạt động' ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailCustomerModal">
                                        <i class="fas fa-info-circle"></i> Chi tiết
                                    </button>
                                    <?php
                                    if (hasPermission('modules/Admin/Customers/ReportCustomer.php')) {

                                    ?>

                                        <!-- Báo cáo -->
                                        <button class="btn btn-sm btn-warning text-dark d-inline-flex align-items-center gap-1 px-2 py-1 btn-report-customer"
                                            data-id="<?= $cus['id'] ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reportCustomerModal">
                                            <i class="fas fa-chart-bar"></i> Báo cáo
                                        </button>
                                    <?php
                                    }
                                    if (hasPermission('modules/Admin/Customers/UpdateCustomer.php')) {

                                    ?>


                                        <!-- Sửa -->
                                        <button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1"
                                            data-id="<?= $cus['id'] ?>"
                                            data-fullname="<?= htmlspecialchars($cus['FullName']) ?>"
                                            data-phone="<?= htmlspecialchars($cus['Phone']) ?>"
                                            data-email="<?= htmlspecialchars($cus['Email']) ?>"
                                            data-address="<?= htmlspecialchars($cus['Address']) ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCustomerModal">
                                            <i class="fas fa-edit"></i> Sửa
                                        </button>
                                    <?php
                                    }
                                    if (hasPermission('modules/Admin/Customers/DeleteCustomer.php')) {

                                    ?>


                                        <!-- Nút Xóa -->
                                        <button
                                            class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete-customer"
                                            data-id="<?= $cus['id'] ?>"
                                            data-name="<?= htmlspecialchars($cus['FullName']) ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteCustomerModal">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    <?php
                                    }
                                    if (hasPermission('modules/Admin/Customers/DeleteCustomerReport.php')) {

                                    ?>

                                        <button
                                            class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete-customer"
                                            data-id="<?= $cus['id'] ?>"
                                            data-name="<?= htmlspecialchars($cus['FullName']) ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteCustomerReportModal">
                                            <i class="fas fa-trash-alt"></i> Gỡ báo cáo
                                        </button>
                                    <?php
                                    }
                                    if (hasPermission('modules/Admin/Customers/UpdatePassword.php')) {

                                    ?>
                                        <!-- Đổi mật khẩu -->
                                        <button class="btn btn-sm btn-dark d-inline-flex align-items-center gap-1 px-2 py-1 btn-update-password"
                                            data-id="<?= $cus['id'] ?>" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">
                                            <i class="fas fa-key"></i> Đổi mật khẩu
                                        </button>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Phân trang -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link"
                        href="Admin.php?page=modules/Admin/Customers/Customer.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor ?>
        </ul>
    </nav>