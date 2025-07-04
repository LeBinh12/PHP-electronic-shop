<?php

$keyword = $_GET['search'] ?? '';



$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;



$totalCategories = $category->countCategories();
$totalPages = ceil($totalCategories / $limit);
$listCategories = $category->getFilterCategories($limit, $offset, $keyword);



?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-circle me-2"></i> Thêm
        </button>
        <form class="search-form" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Categories/Category.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm loại sản phẩm...">
        </form>
    </div>


    <!-- Nhúng các modal -->
    <?php require_once 'modules/Admin/Categories/AddCategory.php'; ?>
    <?php require_once 'modules/Admin/Categories/UpdateCategory.php'; ?>
    <?php require_once 'modules/Admin/Categories/DeleteCategory.php'; ?>

    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 80px">ID</th>
                        <th style="width: 180px">Tên</th>
                        <th>Biểu tượng</th>
                        <th style="width: 160px">Trạng thái</th>
                        <th style="width: 160px">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listCategories as $item): ?>
                        <tr>
                            <td style="color:black"><?= $item["id"] ?></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><i class="<?= htmlspecialchars($item['icon']) ?>"></i> <?= $item['icon'] ?></td>
                            <td><?= $item['status'] ? 'Ẩn' : 'Hiển thị' ?></td>
                            <td class="action-buttons">
                                <!-- Nút sửa -->
                                <button type="button" class="btn btn-sm btn-primary" onclick="openEditCategoryModal(
                                <?= $item['id'] ?>,
                                '<?= addslashes($item['name']) ?>',
                                '<?= addslashes($item['icon']) ?>',
                                <?= $item['status'] ?>
                            )">
                                    <i class="fas fa-edit me-1"></i>
                                    Sửa
                                </button>

                                <!-- Nút xóa -->
                                <button type="button" class="btn btn-sm btn-danger delete-category-btn"
                                    data-id="<?= $item['id'] ?>" data-name="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>">
                                    <i class="fas fa-trash-alt me-1"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Categories/Category.php&search=<?= $keyword ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>