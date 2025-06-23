<?php

// $listProduct = $product->getAll();
$id_category = null;
$id_supplier = null;
$keyword = null;

$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalProducts = $product->countProducts($id_category, $id_supplier, $keyword);
$totalPages = ceil($totalProducts / $limit);

$listProduct = $product->getFilterProducts($id_category, $id_supplier, $keyword, $limit, $offset);



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $productId = $_POST['delete_product_id'] ?? 0;
    if ($product->delete($productId)) {
        header("Location: Admin.php?page=modules/Admin/Products/Product.php");
        exit;
    } else {
        $deleteError = "Xóa sản phẩm thất bại.";
    }
}

?>

<h1 class="h3">Danh sách sản phẩm</h1>
<a href="Admin.php?page=modules/Admin/Products/AddProduct.php" class="btn btn-success mb-3">Thêm sản phẩm</a>
<div class="d-flex justify-content-center">
    <div class="table-container">
        <table class="table table-bordered table-hover table-lg custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Giảm giá</th>
                    <th>Ảnh</th>
                    <th>Loại</th>
                    <th>Nhà cung cấp</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listProduct as $item) {
                ?>
                    <tr>
                        <td style="color:black"><?php echo $item["id"] ?></td>
                        <td><?php echo htmlspecialchars($item['name']) ?></td>
                        <td><?php echo number_format($item['price'], 0) ?></td>
                        <td><?= $item['discount'] ?>%</td>
                        <td>
                            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Ảnh sản phẩm" width="80" height="80" style="object-fit:cover;">
                        </td>
                        <td>
                            <?php
                            $categoryItem = $category->getById($item["category_id"]);
                            echo $categoryItem['name'];
                            ?>
                        </td>
                        <td>
                            <?php
                            $supplierItem = $supplier->getById($item["supplier_id"]);
                            echo $supplierItem['name'];
                            ?>
                        </td>
                        <td class="action-buttons">
                            <a href="Admin.php?page=modules/Admin/Products/UpdateProduct.php&id=<?= $item['id'] ?>"
                                class="btn btn-sm btn-primary">Sửa</a>
                            <button type="button"
                                class="btn btn-sm btn-danger delete-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteProductModal"
                                data-id="<?= $item['id'] ?>"
                                data-name="<?= htmlspecialchars($item['name']) ?>">
                                Xóa
                            </button>

                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="Admin.php?page=modules/Admin/Products/Product.php&category=<?= $id_category ?>&supplier=<?= $id_supplier ?>&search=<?= $keyword ?>&number=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>



<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="delete_product" value="1">
                <input type="hidden" name="delete_product_id" id="deleteProductId">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteProductModalLabel">
                        <i class="fas fa-triangle-exclamation me-2"></i> Xác nhận xóa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="deleteProductName"></strong>?</p>
                    <?php if (!empty($deleteError)): ?>
                        <div class="alert alert-danger"><?= $deleteError ?></div>
                    <?php endif; ?>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" name="btnDelete">
                        <i class="fas fa-trash-alt me-1"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".delete-btn");

        deleteButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                document.getElementById("deleteProductId").value = this.dataset.id;
                document.getElementById("deleteProductName").textContent = this.dataset.name;
            });
        });
    });
</script>