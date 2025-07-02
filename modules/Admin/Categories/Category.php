<?php

$keyword = $_GET['search'] ?? '';



$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;



$totalCategories = $category->countCategories();
$totalPages = ceil($totalCategories / $limit);
$listCategories = $category->getFilterCategories($limit, $offset, $keyword);



?>

<h1 class="h3">Danh sách loại sản phẩm</h1>

<!-- Nút mở modal thêm danh mục -->
<button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
    <i class="fas fa-plus-circle me-1"></i> Thêm loại sản phẩm
</button>
<form class="d-flex justify-content-end mb-3 position-relative" method="GET" action="Admin.php" style="max-width: 350px; width: 100%;">
    <input type="hidden" name="page" value="modules/Admin/Categories/Category.php">
    <button class="btn position-absolute top-50 start-0 translate-middle-y ms-2" type="submit" style="z-index: 10; border: none; background: transparent;">
        <i class="bi bi-search text-muted"></i>
    </button>
    <input type="search"
        name="search"
        value="<?= htmlspecialchars($keyword) ?>"
        class="form-control ps-5 rounded-pill"
        placeholder="Tìm loại sản phẩm...">
</form>


<!-- Nhúng các modal -->
<?php require_once 'modules/Admin/Categories/AddCategory.php'; ?>
<?php require_once 'modules/Admin/Categories/UpdateCategory.php'; ?>
<?php require_once 'modules/Admin/Categories/DeleteCategory.php'; ?>

<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-lg custom-table mx-auto" style="width: auto;">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Biểu tượng</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
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
                                <i class="fas fa-edit"></i>
                                Sửa
                            </button>

                            <!-- Nút xóa -->
                            <button type="button" class="btn btn-sm btn-danger delete-category-btn"
                                data-id="<?= $item['id'] ?>" data-name="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>">
                                <i class="fas fa-trash-alt"></i> Xóa
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

