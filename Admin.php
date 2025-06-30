<?php
session_start();
require_once './controllers/ProductController.php';
require_once './controllers/SupplierController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/ImageController.php';
require_once './controllers/InventoryController.php';

require 'vendor/autoload.php';

$product = new ProductController();
$supplier = new SupplierController();
$category = new CategoryController();
$imageController = new ImageController();
$inventoryController = new InventoryController();

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
    <link rel="stylesheet" href="./Style/Admin/Sidebar.css">
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
                require './modules/Admin/Dashboard/index.php';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/oeu3yhycyrj0lqa722zpeyqh5xj7r8imoh31ctunafgvtgmz/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="./Script/Admin/Sidebar.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });

        function toggleDropdown(id, event) {
            event.preventDefault(); // ❗ Chặn hành vi mặc định của thẻ <a>
            const el = document.getElementById(id);
            el.classList.toggle('show');
        }
    </script>

</body>

</html>