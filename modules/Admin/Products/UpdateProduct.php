<?php
require_once __DIR__ . '/../../../config/database.php';
$pdo = Database::getInstance();

$id = $_GET['id'] ?? null;
$message = '';
$successMessage = '';

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND isDeleted = 0");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        $message = "Không tìm thấy sản phẩm";
    }
}

if (isset($_POST['updateProduct'])) {
    $name = $_POST['nameProduct'] ?? '';
    $price = $_POST['priceProduct'] ?? 0;
    $discount = $_POST['discountProduct'] ?? 0;
    $description = $_POST['descriptionProduct'] ?? '';
    $category_id = $_POST['category_id'] ?? 1;
    $supplier_id = $_POST['supplier_id'] ?? 1;
    $image_url = $_POST['image_url'] ?? $product['image_url'] ?? '';

    // Handle image upload if provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image_url = 'uploads/' . $fileName;
        } else {
            $message = "Lỗi khi tải ảnh lên";
        }
    }

    if (empty($message)) {
        $update = $pdo->prepare("UPDATE products SET name = ?, price = ?, discount = ?, description = ?, image_url = ?, category_id = ?, supplier_id = ? WHERE id = ?");
        $update->execute([$name, $price, $discount, $description, $image_url, $category_id, $supplier_id, $id]);
        header("Location: Main.php?page=products");
exit;
        $product = array_merge($product, ['name' => $name, 'price' => $price, 'discount' => $discount, 'description' => $description, 'image_url' => $image_url, 'category_id' => $category_id, 'supplier_id' => $supplier_id]); // Cập nhật lại product để hiển thị
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cập nhật Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../Style/Admin/Style.css">
</head>

<body>
    <?php include_once __DIR__ . '/../Navbar/Navbar.php'; ?>

    <div class="admin-container">
        <?php include_once __DIR__ . '/../Sidebar/Sidebar.php'; ?>

        <div class="content">
            <h1 class="h3">Cập nhật Sản Phẩm</h1>
            <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success mt-3"><?= htmlspecialchars($successMessage) ?></div>
            <?php endif; ?>
            <?php if (!empty($message)): ?>
            <div class="alert alert-danger mt-3"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <?php if (!empty($product)): ?>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="nameProduct" value="<?= htmlspecialchars($product['name']) ?>"
                        class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="priceProduct" value="<?= (int)$product['price'] ?>" class="form-control"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Giảm giá (%)</label>
                    <input type="number" name="discountProduct" value="<?= (float)$product['discount'] ?>"
                        class="form-control" step="0.01" min="0" max="100">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="descriptionProduct"
                        class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">URL Ảnh (hoặc để trống nếu upload)</label>
                    <input type="url" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>"
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
                        $categoriesStmt = $pdo->query("SELECT id, name FROM categories");
                        $categories = $categoriesStmt->fetchAll();
                        foreach ($categories as $cat) {
                            $selected = $cat['id'] == $product['category_id'] ? 'selected' : '';
                            echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nhà cung cấp</label>
                    <select name="supplier_id" class="form-select">
                        <?php
                        $suppliersStmt = $pdo->query("SELECT id, name FROM suppliers");
                        $suppliers = $suppliersStmt->fetchAll();
                        foreach ($suppliers as $sup) {
                            $selected = $sup['id'] == $product['supplier_id'] ? 'selected' : '';
                            echo "<option value='{$sup['id']}' $selected>{$sup['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="updateProduct" class="btn btn-primary">Cập nhật</button>
                <a href="../Products/ListProduct.php" class="btn btn-secondary">Quay lại</a>
            </form>
            <?php else: ?>
            <p>Không có sản phẩm để cập nhật.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>