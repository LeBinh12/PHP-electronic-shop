<?php
require_once __DIR__ . '/../../../config/database.php';
$pdo = Database::getInstance();

$id = $_GET['id'] ?? null;
$message = '';

if ($id) {
    // Lấy thông tin sản phẩm
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND isDeleted = 0");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        $message = "Không tìm thấy sản phẩm hoặc đã bị xóa.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['DeleteProduct'])) {
    if ($id) {
        $stmt = $pdo->prepare("UPDATE products SET isDeleted = 1 WHERE id = ?");
        if ($stmt->execute([$id])) {
            header("Location: Main.php?page=products");
            exit;
        } else {
            $message = "Xóa sản phẩm thất bại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xóa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h2>Xóa sản phẩm</h2>

    <?php if (!empty($message)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php elseif (!empty($product)): ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" class="form-control" value="<?= (int)$product['price'] ?>" disabled>
        </div>
        <button type="submit" name="DeleteProduct" class="btn btn-danger">Xác nhận xóa</button>
        <a href="Main.php?page=products" class="btn btn-secondary">Hủy</a>
    </form>
    <?php endif; ?>
</body>

</html>