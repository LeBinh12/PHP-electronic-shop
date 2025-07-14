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

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>BVCrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
    <div id="chat-form" class="hidden">
        <div class="p-2 bg-success text-white d-flex justify-content-between align-items-center">
            <p class="m-0">Hỗ trợ trực tuyến</p>
            <i id="chat-close" class="bi bi-x-lg" style="cursor: pointer;"></i>
        </div>
        <div id="chat-content" class="flex-grow-1 overflow-auto p-2" style="background: #f8f9fa;">
            <div class="d-flex align-items-start mb-2">
                <img src="https://tse4.mm.bing.net/th?id=OIP.kQyrx9VbuWXWxCVxoreXOgHaHN&pid=Api&P=0&h=220" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                <div>
                    <strong>User</strong>
                    <div class="p-2 bg-light border rounded" style="max-width: 70%; word-break: break-word;">
                        Mình muốn hỏi thông tin sản phẩm.
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mb-2">
                <div class="p-2 bg-success text-white border rounded" style="max-width: 70%; word-break: break-word;">
                    Xin chào, bạn cần hỗ trợ gì không?
                </div>
            </div>
        </div>
        <div class="p-2 border-top d-flex align-items-center">
            <input type="text" class="form-control me-2" placeholder="Nhập tin nhắn..." id="chat-input">
            <button id="send-message" class="btn btn-success">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>
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


</body>

</html>