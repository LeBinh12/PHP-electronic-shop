<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once './controllers/ProductController.php';
require_once './controllers/SupplierController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/ImageController.php';
require_once './controllers/InventoryController.php';
require_once './controllers/OrderController.php';
require_once './controllers/OrderItemController.php';
require_once './controllers/UserController.php';
require_once './controllers/StatusController.php';
require_once './controllers/ChatController.php';
require_once './controllers/ReportController.php';
require_once './controllers/ReportController.php';
require_once './controllers/UserReportController.php';
require_once './controllers/MenuController.php';
require_once './controllers/RoleController.php';
require_once './controllers/EmployeeController.php';
require_once './controllers/BranchController.php';




require 'vendor/autoload.php';

$product = new ProductController();
$supplier = new SupplierController();
$category = new CategoryController();
$imageController = new ImageController();
$inventoryController = new InventoryController();
$orderController = new OrderController();
$orderItemController = new OrderItemController();
$userController = new UserController();
$statusController = new StatusController();
$chatController = new ChatController();
$reportController = new ReportController();
$userReportController = new UserReportController();
$menuController = new MenuController();
$roleController = new RoleController();
$employeeController = new EmployeeController();
$branchController = new BranchController();

$userList = $chatController->getAllChatUserIdsFromRedis();
$userId = $_GET['chat_user_id'] ?? null;
$showChatList = isset($_GET['show_chat_list']);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>BVCrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./Style/Admin/style.css">
    <link rel="stylesheet" href="./Style/Admin/Sidebar.css">
    <link rel="stylesheet" href="./Style/Admin/Navbar.css">
    <link rel="stylesheet" href="./Style/Admin/Inventory.css">
    <link rel="stylesheet" href="./Style/Admin/Chat.css">
    <link rel="stylesheet" href="./Style/Admin/Product.css">
    <link rel="stylesheet" href="./Style/Admin/AddProduct.css">
    <link rel="stylesheet" href="./Style/Admin/Customer.css">
</head>

<body>
    <?php
    // $chatController->sendMessage(13, 'admin', 'Bạn cần laptop gaming hay học tập?');
    // $history = $chatController->getChatHistory(13);
    // foreach ($history as $entry) {
    //     echo "[{$entry->time}] {$entry->from}: {$entry->message} <br>";
    // }
    require  './modules/Admin/Navbar/Navbar.php';
    ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="./Style/Script/Admin/Sidebar.js"></script>
    <script src="./Style/Script/Admin/Inventory.js" defer></script>
    <script src="./Style/Script/Admin/Customer.js"></script>




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
    <!-- Chat -->
    <div id="chat-toggle">
        <i class="bi bi-chat-dots-fill fs-3"></i>
    </div>
    <?php
    require_once './modules/Admin/Chat/AdminChat.php';
    ?>
    <script src="./Style/Script/User/Chat.js"></script>
    <script src="./Style/Script/User/Detail.js"></script>
    <script src="./Style/Script/Admin/AddInventory.js"></script>
    <script src="./Style/Script/Admin/DeleteProduct.js"></script>
    <script src="./Style/Script/Admin/AddProduct.js"></script>
    <script src="./Style/Script/Admin/UpdateProduct.js"></script>
    <script src="./Style/Script/Admin/Order.js"></script>
    <script src="./Style/Script/Admin/DeleteCategory.js"></script>
    <script src="./Style/Script/Admin/Supplier.js"></script>
    <script src="./Style/Script/Admin/Profile.js"></script>
    <script src="./Style/Script/Admin/Menu.js"></script>
    <script src="./Style/Script/Admin/Role.js"></script>
    <script src="./Style/Script/Admin/Employee.js"></script>
    <script src="./Style/Script/Admin/Shipping.js"></script>
    <script src="./Style/Script/Admin/Branch.js"></script>



    <script>
        <?php if (isset($_SESSION['success'])): ?>
            toastr.success("<?= $_SESSION['success'] ?>");
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            toastr.error("<?= $_SESSION['error'] ?>");
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>


</body>

</html>