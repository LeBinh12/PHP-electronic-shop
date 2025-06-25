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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./Style/Users/Header.css">
    <link rel="stylesheet" href="./Style/Users/Detail.css">
    <link rel="stylesheet" href="./Style/Users/Sidebar.css">
    <link rel="stylesheet" href="./Style/Users/Cart.css">
    <link rel="stylesheet" href="./Style/Users/Chat.css">
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


    <!-- Chat -->
    <div id="chat-toggle">
        <i class="bi bi-chat-dots-fill fs-3"></i>
    </div>
    <div id="chat-form" class="hidden">
        <div class="p-2 bg-primary text-white d-flex justify-content-between align-items-center">
            <p class="m-0">Hỗ trợ trực tuyến</p>
            <i id="chat-close" class="bi bi-x-lg" style="cursor: pointer;"></i>
        </div>
        <div id="chat-content" class="flex-grow-1 overflow-auto p-2" style="background: #f8f9fa;">
            <div class="d-flex align-items-start mb-2">
                <img src="https://tse4.mm.bing.net/th?id=OIP.kQyrx9VbuWXWxCVxoreXOgHaHN&pid=Api&P=0&h=220" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                <div>
                    <strong>Admin</strong>
                    <div class="p-2 bg-light border rounded" style="max-width: 70%; word-break: break-word;">
                        Xin chào, bạn cần hỗ trợ gì không?
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mb-2">
                <div class="p-2 bg-primary text-white border rounded" style="max-width: 70%; word-break: break-word;">
                    Mình muốn hỏi thông tin sản phẩm.
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
    <!-- <script>
        const chatToggle = document.getElementById('chat-toggle');
        const chatForm = document.getElementById('chat-form');
        const chatClose = document.getElementById('chat-close');

        chatToggle.addEventListener('click', () => {
            chatForm.style.display = chatForm.style.display === 'none' ? 'block' : 'none';
        });

        chatClose.addEventListener('click', () => {
            chatForm.style.display = 'none';
        });
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./Style/Script/User/Chat.js"></script>

</body>

</html>