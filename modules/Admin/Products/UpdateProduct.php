<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Tên sản phẩm</label>
        <input type="text" name="nameProduct" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Giá</label>
        <input type="number" name="priceProduct" class="form-control"
            required>
    </div>
    <div class="mb-3">
        <label class="form-label">Giảm giá (%)</label>
        <input type="number" name="discountProduct"
            class="form-control" step="0.01" min="0" max="100">
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="descriptionProduct"
            class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">URL Ảnh (hoặc để trống nếu upload)</label>
        <input type="url" name="image_url"
            class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Ảnh (upload mới)</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <div class="mb-3">
        <label class="form-label">Loại</label>
        <select name="category_id" class="form-select">
            <?php
            // $categoriesStmt = $pdo->query("SELECT id, name FROM categories");
            // $categories = $categoriesStmt->fetchAll();
            // foreach ($categories as $cat) {
            //     $selected = $cat['id'] == $product['category_id'] ? 'selected' : '';
            //     echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
            // }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Nhà cung cấp</label>
        <select name="supplier_id" class="form-select">
            <?php
            // $suppliersStmt = $pdo->query("SELECT id, name FROM suppliers");
            // $suppliers = $suppliersStmt->fetchAll();
            // foreach ($suppliers as $sup) {
            //     $selected = $sup['id'] == $product['supplier_id'] ? 'selected' : '';
            //     echo "<option value='{$sup['id']}' $selected>{$sup['name']}</option>";
            // }
            ?>
        </select>
    </div>
    <button type="submit" name="updateProduct" class="btn btn-primary">Cập nhật</button>
    <a href="../Products/ListProduct.php" class="btn btn-secondary">Quay lại</a>
</form>