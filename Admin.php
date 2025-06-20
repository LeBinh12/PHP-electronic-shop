<?php
session_start();
require_once './controllers/ProductController.php';
require_once './controllers/SupplierController.php';
require_once './controllers/CategoryController.php';

$product = new ProductController();
$supplier = new SupplierController();
$category = new CategoryController();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sherah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Style/Admin/style.css">
</head>

<body>
    <?php require  './modules/Admin/Navbar/Navbar.php'; ?>
    <!-- Navbar nên đặt ngoài admin-container -->

    <div class="admin-container">
        <?php require  './modules/Admin/Sidebar/Sidebar.php'; ?>

        <div class="content">
            <?php
            if (isset($_GET['page'])) {
                require $_GET['page'];
            } else {
                echo "<h3 class='text-primary'>🎉 Chào mừng đến trang Admin!</h3>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>