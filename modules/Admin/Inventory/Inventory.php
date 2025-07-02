<?php
$keyword = $_GET['search'] ?? '';


$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalInventory = $inventoryController->countInventory($keyword);
$totalPages = ceil($totalInventory / $limit);

$listItems = $inventoryController->getProductPagination($keyword, $limit, $offset);


// $listItems = [
//     ['id' => 1,  'product_name' => 'Điện thoại iPhone 15 128GB',      'stock_quantity' => 35, 'last_update' => '2025-06-28 14:22:10'],
//     ['id' => 2,  'product_name' => 'Samsung Galaxy S24 Ultra 256GB',   'stock_quantity' => 12, 'last_update' => '2025-06-27 09:05:41'],
//     ['id' => 3,  'product_name' => 'Laptop ASUS ROG Zephyrus G16',     'stock_quantity' => 8,  'last_update' => '2025-06-26 16:30:00'],
//     ['id' => 4,  'product_name' => 'Tai nghe Sony WH‑1000XM6',         'stock_quantity' => 57, 'last_update' => '2025-06-25 11:15:09'],
//     ['id' => 5,  'product_name' => 'Chuột Logitech G Pro X Superlight', 'stock_quantity' => 40, 'last_update' => '2025-06-24 19:45:33'],
//     ['id' => 6,  'product_name' => 'Bàn phím Keychron K8 Pro',         'stock_quantity' => 25, 'last_update' => '2025-06-24 08:12:55'],
//     ['id' => 7,  'product_name' => 'Smart TV LG OLED C4 55"',          'stock_quantity' => 5,  'last_update' => '2025-06-23 13:27:18'],
//     ['id' => 8,  'product_name' => 'Máy ảnh Canon EOS R8',             'stock_quantity' => 9,  'last_update' => '2025-06-22 10:00:00'],
//     ['id' => 9,  'product_name' => 'Ổ cứng SSD Samsung 990 Pro 2TB',   'stock_quantity' => 60, 'last_update' => '2025-06-22 17:49:02'],
//     ['id' => 10, 'product_name' => 'Apple Watch Series 10 45mm',       'stock_quantity' => 18, 'last_update' => '2025-06-21 07:33:21'],
//     ['id' => 11, 'product_name' => 'Máy lọc không khí Xiaomi 4 Pro',   'stock_quantity' => 22, 'last_update' => '2025-06-20 15:10:45'],
//     ['id' => 12, 'product_name' => 'Router Wi‑Fi 6 TP‑Link AX5400',    'stock_quantity' => 31, 'last_update' => '2025-06-19 20:05:00'],
//     ['id' => 13, 'product_name' => 'Máy in HP LaserJet M211d',         'stock_quantity' => 14, 'last_update' => '2025-06-19 09:55:13'],
//     ['id' => 14, 'product_name' => 'Loa Bluetooth JBL Charge 6',       'stock_quantity' => 44, 'last_update' => '2025-06-18 18:22:09'],
//     ['id' => 15, 'product_name' => 'Camera an ninh EZVIZ C8W Pro',     'stock_quantity' => 27, 'last_update' => '2025-06-18 12:40:00'],
// ];

// if ($keyword !== '') {
//     $listItems = array_filter(
//         $listItems,
//         fn($item) => stripos($item['product_name'], $keyword) !== false
//     );
// }

// $limit = 10;
// $totalPages = max(1, ceil(count($listItems) / $limit));

// $page = isset($_GET['number']) ? (int) $_GET['number'] : 1;
// $page = max(1, min($page, $totalPages));

// $offset    = ($page - 1) * $limit;
// $listItems = array_slice($listItems, $offset, $limit);

?>

<h1 class="h3">Danh sách kho hàng</h1>

<form class="d-flex justify-content-end mb-3 position-relative" method="GET" action="Admin.php" style="max-width: 350px; width: 100%;">
    <input type="hidden" name="page" value="modules/Admin/Inventory/Inventory.php">
    <button class="btn position-absolute top-50 start-0 translate-middle-y ms-2" type="submit" style="z-index: 10; border: none; background: transparent;">
        <i class="bi bi-search text-muted"></i>
    </button>
    <input type="search"
        name="search"
        value="<?= htmlspecialchars($keyword) ?>"
        class="form-control ps-5 rounded-pill"
        placeholder="Tìm sản phẩm...">
</form>

<?php require_once 'modules/Admin/Inventory/AddInventory.php'; ?>
<?php require_once 'modules/Admin/Inventory/UpdateInventory.php'; ?>

<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th style="width: 50px; text-align:center">ID</th>
                    <th>Tên Sản Phẩm</th>
                    <th style="width: 100px">Số Lượng</th>
                    <th style="width: 200px">Lần Cập Nhật Gần Nhất</th>
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
                                <button type="button" class="btn btn-sm btn-success px-3 py-1"
                                    data-id="<?= $item["id"] ?>"
                                    data-product-name="<?= htmlspecialchars($item['product_name']) ?>"
                                    data-bs-toggle="modal" data-bs-target="#addItemModal">
                                    <i class="fas fa-plus-circle me-1"></i><small>Thêm</small>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary px-3 py-1" data-bs-toggle="modal" data-bs-target="#editItemModal"
                                    data-id="<?= htmlspecialchars($item['id']) ?>"
                                    data-product-name="<?= htmlspecialchars($item['product_name']) ?>"
                                    data-stock-quantity="<?= htmlspecialchars($item['stock_quantity']) ?>">
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