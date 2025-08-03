<?php
require_once 'RestoreProduct.php';
require_once 'DeleteProduct.php';

// Dữ liệu ảo
$listDeletedProducts = [
    [
        'id' => 101,
        'name' => 'Giày thể thao nam',
        'image_url' => 'https://via.placeholder.com/100x80',
        'price' => 850000,
        'discount' => 10,
        'category' => 'Thời trang',
        'supplier' => 'Adidas',
    ],
    [
        'id' => 102,
        'name' => 'Balo du lịch',
        'image_url' => 'https://via.placeholder.com/100x80',
        'price' => 450000,
        'discount' => 5,
        'category' => 'Phụ kiện',
        'supplier' => 'North Face',
    ]
];
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
                    <th style="width: 160px">Loại</th>
                    <th style="width: 160px">Nhà cung cấp</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedProducts as $item): ?>
                    <tr>
                        <td><?= $item["id"] ?></td>
                        <td><img src="<?= $item['image_url'] ?>" alt="Ảnh" style="width: 100px; height: 80px;"></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 0) ?>₫</td>
                        <td><?= $item['discount'] ?>%</td>
                        <td><?= htmlspecialchars($item['category']) ?></td>
                        <td><?= htmlspecialchars($item['supplier']) ?></td>
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
</div>

<script>
    // Set data vào modal khi click khôi phục hoặc xóa
    document.querySelectorAll('.btn-success').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('restoreProductId').value = btn.getAttribute('data-id');
            document.getElementById('restoreProductName').textContent = btn.getAttribute('data-name');
        });
    });

    document.querySelectorAll('.btn-danger').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('deleteProductId').value = btn.getAttribute('data-id');
            document.getElementById('deleteProductName').textContent = btn.getAttribute('data-name');
        });
    });
</script>