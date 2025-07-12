<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once './controllers/ProductController.php';
require_once './controllers/SupplierController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';
require_once './controllers/OrderController.php';
require_once './controllers/OrderItemController.php';
require_once './controllers/InventoryController.php';
require_once './controllers/PaymentController.php';
require_once './controllers/StatusController.php';


require 'vendor/autoload.php';

$product = new ProductController();
$supplier = new SupplierController();
$category = new CategoryController();
$imageController = new ImageController();
$userController = new UserController();
$orderController = new OrderController();
$orderItemController = new OrderItemController();
$inventoryController = new InventoryController();
$paymentController = new PaymentController();
$statusController = new StatusController();

$cart = $_SESSION['cart'] ?? [];
$userData = $userController->getCurrentUser();


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>GEARVN Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="./Style/Users/Header.css">
    <link rel="stylesheet" href="./Style/Users/Detail.css">
    <link rel="stylesheet" href="./Style/Users/Sidebar.css">
    <link rel="stylesheet" href="./Style/Users/Cart.css">
    <link rel="stylesheet" href="./Style/Users/Chat.css">
    <link rel="stylesheet" href="./Style/Users/Supplier.css">
    <link rel="stylesheet" href="./Style/Users/Product.css">
    <link rel="stylesheet" href="./Style/Users/CheckOrder.css">
    <link rel="stylesheet" href="./Style/Users/HomePage.css">
    <style>
        .chat-box {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background: white;
            z-index: 9998;
        }

        .hidden {
            display: none !important;
        }
        .chat-toggle-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #e0f0ff;
            /* Màu nền mặc định - cho Admin */
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s;
        }

        #chat-toggle-ai {
            background-color: #e6f9ec;
        }

        .chat-toggle-btn:hover {
            transform: scale(1.1);
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        require './modules/Users/Layout/Header.php';
        if (isset($_GET['subpage'])) {
            require $_GET['subpage'];
        } else {
            require './modules/Users/page/HomePage.php';
        }
        require './modules/Users/Layout/Supplier.php';

        require './modules/Users/Layout/Footer.php';
        ?>
    </div>

    <!-- Chat Toggle Buttons -->
    <div id="chat-toggle-wrapper" style="position: fixed; bottom: 20px; right: 20px; display: flex; gap: 10px; z-index: 9999;">
        <div id="chat-toggle-admin" class="chat-toggle-btn" title="Chat với Admin">
            <i class="bi bi-chat-dots-fill fs-3 text-primary"></i>
        </div>
        <div id="chat-toggle-ai" class="chat-toggle-btn" title="Chat với AI">
            <i class="bi bi-robot fs-3 text-success"></i>
        </div>
    </div>

    <!-- Chat -->
    <div id="chat-form" class="chat-box hidden">
        <div class="p-2 bg-primary text-white d-flex justify-content-between align-items-center">
            <p class="m-0">Hỗ trợ trực tuyến</p>
            <i id="chat-close" class="bi bi-x-lg" style="cursor: pointer;"></i>
        </div>
        <div id="chat-content" class="p-2" style="background: #f8f9fa; max-height: 500px; overflow-y: auto;">
            <div class="d-flex align-items-start mb-2">
                <img src="https://tse4.mm.bing.net/th?id=OIP.kQyrx9VbuWXWxCVxoreXOgHaHN&pid=Api&P=0&h=220" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                <div>
                    <strong>Admin</strong>
                    <div class="p-2 bg-light border rounded">
                        Xin chào, bạn cần hỗ trợ gì không?
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 border-top d-flex align-items-center">
            <input type="text" class="form-control me-2" placeholder="Nhập tin nhắn..." id="chat-input">
            <button id="send-message" class="btn btn-primary">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>

    <?php
    require_once './chatBox.php';
    ?>

    <script>
        const chatForm = document.getElementById("chat-form");
        const aiChatForm = document.getElementById("ai-chat-form");

        document.getElementById("chat-toggle-admin").addEventListener("click", () => {
            chatForm.classList.toggle("hidden");
            aiChatForm.classList.add("hidden");
        });

        document.getElementById("chat-toggle-ai").addEventListener("click", () => {
            aiChatForm.classList.toggle("hidden");
            chatForm.classList.add("hidden");
        });

        document.getElementById("chat-close").addEventListener("click", () => {
            chatForm.classList.add("hidden");
        });

        document.getElementById("ai-chat-close").addEventListener("click", () => {
            aiChatForm.classList.add("hidden");
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./Style/Script/User/Chat.js"></script>
    <script src="./Style/Script/User/Detail.js"></script>
    <script src="./Style/Script/User/CheckOrder.js"></script>
    <script src="./Style/Script/User/HomePage.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

</body>

</html>