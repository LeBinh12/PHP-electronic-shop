<?php

$keyword = $_GET['search'] ?? '';
$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalRole = $roleController->countRole($keyword);
$totalPages = ceil($totalRole / $limit);

$listItems = $roleController->getPagination($keyword, $limit, $offset);

?>

<div class="product-container">

    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <?php
        if (hasPermission('modules/Admin/Roles/AddRole.php')) {
        ?>
            <!-- Nút thêm quyền -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                <i class="bi bi-plus-circle me-2"></i> Thêm quyền
            </button>
        <?php
        }
        ?>

        <!-- Form tìm kiếm quyền -->
        <form class="search-form" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Roles/Role.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm kiếm quyền...">
        </form>
    </div>

    <table class="table table-bordered custom-table">
        <thead class="table-dark">
            <tr>
                <th style="width: 100px">ID</th>
                <th>Tên quyền</th>
                <th style="width: 200px">Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listItems as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['role_name']) ?></td>
                    <td class="text-center">
                        <div class="d-flex gap-2 justify-content-center">
                            <?php
                            if (hasPermission('modules/Admin/Roles/UpdateRole.php')) {

                            ?>
                                <a href="Admin.php?page=modules/Admin/Roles/Role.php&edit_id=<?= $item['id'] ?>" class="btn btn-primary btn-sm text-white">
                                    <i class="fas fa-edit me-1"></i> Sửa
                                </a>
                            <?php
                            }

                            if (hasPermission('modules/Admin/Role/DeleteRole.php')) {

                            ?>

                                <button class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteRoleModal"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['role_name']) ?>">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            <?php

                            } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Roles/Role.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

<?php
require_once './modules/Admin/Roles/DeleteRole.php';

require_once './modules/Admin/Roles/UpdateRole.php';

require_once './modules/Admin/Roles/AddRole.php';
?>