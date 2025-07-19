<?php
$keyword = $_GET['search'] ?? '';


$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalInventory = $inventoryController->countInventory($keyword);
$totalPages = ceil($totalInventory / $limit);

$listItems = $inventoryController->getProductPagination($keyword, $limit, $offset);

// var_dump($listItems); exit; 
?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Inventory/Inventory.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm sản phẩm trong kho...">
        </form>
    </div>

    <?php require_once 'modules/Admin/Inventory/AddInventory.php'; ?>
    <?php require_once 'modules/Admin/Inventory/UpdateInventory.php'; ?>

    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 100px; text-align:center">ID</th>
                        <th>Tên Sản Phẩm</th>
                        <th style="width: 150px">Số Lượng</th>
                        <th style="width: 250px">Lần Cập Nhật Gần Nhất</th>
                        <th class="text-center" style="width: 200px">Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listItems as $item) { ?>
                        <tr>
                            <td class="text-center" style="color:black"><?= htmlspecialchars($item["id"]) ?></td>
                            <td class="text-center"><?= htmlspecialchars($item['product_name'] ?? 'N/A') ?></td>
                            <td class="text-center"><?= number_format($item['stock_quantity'], 0) ?></td>
                            <td><?= htmlspecialchars($item['last_update'] ?? 'N/A') ?></td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-2">
                                    <button
                                        class="btn btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addItemModal"
                                        data-id="<?= htmlspecialchars($item['id']) ?>"
                                        data-product-name="<?= htmlspecialchars($item['product_name']) ?>"
                                        data-stock-quantity="<?= htmlspecialchars($item['stock_quantity']) ?>">
                                        <i class="fas fa-plus-circle"></i> Thêm
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary px-3 py-1"
                                        data-id="<?= htmlspecialchars($item['id']) ?>"
                                        data-product-name="<?= htmlspecialchars($item['product_name']) ?>"
                                        data-stock-quantity="<?= htmlspecialchars($item['stock_quantity']) ?>"
                                        data-bs-toggle="modal" data-bs-target="#editItemModal">
                                        <i class="fas fa-edit me-1"></i><small>Sửa</small>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Phân trang -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Inventory/Inventory.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor ?>
        </ul>
    </nav>
</div>