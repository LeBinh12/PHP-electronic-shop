<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $productId = $_POST['delete_product_id'] ?? 0;
    $result = $product->delete($productId);
    if ($result['success']) {
        echo "<script>
            alert('Xóa sản phẩm thành công!');
            window.location.href = '../../Admin.php?page=modules/Admin/Products/Product.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Xóa sản phẩm thất bại!');
            window.location.href = '../../Admin.php?page=modules/Admin/Products/Product.php';
        </script>";
        exit;
    }
}
