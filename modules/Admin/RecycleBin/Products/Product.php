<?php
require_once 'RestoreProduct.php';
require_once 'DeleteProduct.php';

// Dữ liệu ảo
$id_category = null;
$id_supplier = null;
$keyword = $_GET['search'] ?? '';


$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalProducts = $product->countProducts($id_category, $id_supplier, $keyword, [], 1);
$totalPages = ceil($totalProducts / $limit);

$listProduct = $product->getFilterProducts($id_category, $id_supplier, $keyword, $limit, $offset, [], 1);

?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <h4 class="mb-0 text-danger">
            <i class="fas fa-box-open me-2"></i>Thùng rác - Sản phẩm đã xóa
        </h4>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th style="width: 80px">ID</th>
                    <th style="width: 100px">Hình ảnh</th>
                    <th style="width: 260px">Tên sản phẩm</th>
                    <th style="width: 100px">Giá</th>
                    <th style="width: 100px">Giảm giá</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listProduct as $item): ?>
                    <tr>
                        <td><?= $item["id"] ?></td>
                        <td><img src="<?= $item['image_url'] ?>" alt="Ảnh" style="width: 100px; height: 80px;"></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 0) ?>₫</td>
                        <td><?= $item['discount'] ?>%</td>
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreProductModal"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name']) ?>">
                                    <i class="fas fa-undo me-1"></i> Khôi phục
                                </button>

                                <button type="button" class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteProductModal"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name']) ?>">
                                    <i class="fas fa-trash-alt me-1"></i> Xóa vĩnh viễn
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/RecycleBin/Products/Product.php&category=<?= $id_category ?>&supplier=<?= $id_supplier ?>&search=<?= $keyword ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

<script>
    // Set data vào modal khi click khôi phục hoặc xóa
    document.querySelectorAll('.btn-success').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('restoreProductId').value = btn.getAttribute('data-id');
            document.getElementById('restoreProductName').textContent = btn.getAttribute('data-name');
        });
    });
</script>