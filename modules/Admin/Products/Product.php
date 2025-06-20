<?php
require_once __DIR__ . '/../../../config/database.php';
$pdo = Database::getInstance();

// Xử lý xóa mềm
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("UPDATE products SET isDeleted = 1 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ListProduct.php");
    exit;
}

// Lấy danh sách sản phẩm chưa xóa
$stmt = $pdo->query("SELECT * FROM products WHERE isDeleted = 0");
$products = $stmt->fetchAll();

// Lấy danh sách loại và nhà cung cấp
$categoriesStmt = $pdo->query("SELECT id, name FROM categories");
$categories = $categoriesStmt->fetchAll();

$suppliersStmt = $pdo->query("SELECT id, name FROM suppliers");
$suppliers = $suppliersStmt->fetchAll();

// Validate product names
$errors = [];
foreach ($products as $index => $p) {
    if (empty(trim($p['name']))) {
        $errors[$index] = "Tên sản phẩm không được để trống.";
    }
}
?>

<div class="content">
    <h1 class="h3">Danh sách sản phẩm</h1>
    <a href="Main.php?page=add_product" class="btn btn-success mb-3">Thêm sản phẩm</a>
    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover table-lg custom-table">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Giảm giá</th>
                        <th>Mô tả</th>
                        <th>Ảnh</th>
                        <th>Loại</th>
                        <th>Nhà cung cấp</th>
                        <th>Ngày tạo</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $index => $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['id']) ?></td>
                        <td>
                            <?= htmlspecialchars($p['name']) ?>
                            <?php if (isset($errors[$index])): ?>
                            <span style="color: red;"><?= $errors[$index] ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($p['price'], 0) ?> VND</td>
                        <td><?= $p['discount'] ?>%</td>
                        <td><?= htmlspecialchars($p['description']) ?></td>
                        <td>
                            <?php
                        $imageUrl = htmlspecialchars($p['image_url'] ?? '');
                        if (!empty($imageUrl)) {
                            // Kiểm tra nếu là URL (bắt đầu bằng http hoặc https)
                            if (preg_match('/^https?:\/\//', $imageUrl)) {
                                echo "<img src='$imageUrl' alt='Ảnh sản phẩm' class='product-image'>";
                            } else {
                                $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $imageUrl;
                                if (file_exists($fullPath)) {
                                    echo "<img src='/$imageUrl' alt='Ảnh sản phẩm' class='product-image'>";
                                } else {
                                    echo "<span style='color: red;'>Ảnh không tồn tại: $imageUrl (Full Path: $fullPath)</span>";
                                }
                            }
                        } else {
                            echo "<span style='color: red;'>Không có ảnh</span>";
                        }
                        ?>
                        </td>
                        <td>
                            <?php
                        $category = array_filter($categories, fn($cat) => $cat['id'] == $p['category_id']);
                        echo htmlspecialchars(current($category)['name'] ?? '');
                        ?>
                        </td>
                        <td>
                            <?php
                        $supplier = array_filter($suppliers, fn($sup) => $sup['id'] == $p['supplier_id']);
                        echo htmlspecialchars(current($supplier)['name'] ?? '');
                        ?>
                        </td>
                        <td><?= $p['created_at'] ?></td>
                        <td class="action-buttons">
                            <a href="Main.php?page=update_product&id=<?= $p['id'] ?>"
                                class="btn btn-sm btn-primary">Sửa</a>
                            <a href="Main.php?page=delete_product&id=<?= $p['id'] ?>"
                                class="btn btn-sm btn-danger">Xóa</a>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>