<?php

$listProduct = $product->getAll();

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
                        <td><?= htmlspecialchars($item['image_url']) ?></td>
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
                            <a href="Admin.php?page=modules/Admin/Products/DeleteProduct.php&id=<?= $item['id'] ?>"
                                class="btn btn-sm btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>