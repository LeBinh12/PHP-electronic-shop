<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sherah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../Style/Admin/Style.css">
</head>

<body>
    <?php include_once __DIR__ . '/../Navbar/Navbar.php'; ?>
    <!-- Navbar nên đặt ngoài admin-container -->

    <div class="admin-container">
        <?php include_once __DIR__ . '/../Sidebar/Sidebar.php'; ?>

        <div class="content">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];

                // Đảm bảo chỉ truy cập file hợp lệ
                $allowedPages = [
                    'products' => '/../Products/Product.php',
                    'add_product' => '/../Products/AddProduct.php',
                    'update_product' => '/../Products/UpdateProduct.php',
                    'delete_product' => '/../Products/DeleteProduct.php',
                    'categories' => '/../Categories/Category.php',
                    'suppliers' => '/../Suppliers/Supplier.php'
                ];

                if (array_key_exists($page, $allowedPages)) {
                    include_once __DIR__ . $allowedPages[$page];
                } else {
                    echo "<div class='alert alert-danger'>Không tìm thấy trang phù hợp!</div>";
                }
            } else {
                echo "<h3 class='text-primary'>🎉 Chào mừng đến trang Admin!</h3>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>