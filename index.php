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
    <title>GEARVN Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <?php
        require './modules/Users/Layout/Header.php';
        require './modules/Users/Layout/Main.php';
        // include("Layout/Footer.php");
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>