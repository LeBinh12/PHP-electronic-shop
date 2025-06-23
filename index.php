<?php
session_start();
require_once './controllers/ProductController.php';
require_once './controllers/SupplierController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';

require 'vendor/autoload.php';

$product = new ProductController();
$supplier = new SupplierController();
$category = new CategoryController();
$imageController = new ImageController();
$userController = new UserController();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>GEARVN Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./Style/Users/Header.css">
    <link rel="stylesheet" href="./Style/Users/Detail.css">
    <link rel="stylesheet" href="./Style/Users/Sidebar.css">


</head>

<body>
    <div class="container">
        <?php
        require './modules/Users/Layout/Header.php';
        if (isset($_GET['subpage'])) {
            require $_GET['subpage'];
        } else {
            require './modules/Users/Layout/Main.php';
        }
        require './modules/Users/Layout/Footer.php';
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>