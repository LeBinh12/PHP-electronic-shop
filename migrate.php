<?php

require_once './models/Category.php';
require_once  './models/Product.php';
require_once  './models/Supplier.php';
require_once  './models/Payment.php';
require_once  './models/Shipping.php';
require_once  './models/User.php';
require_once  './models/Order.php';
require_once  './models/OrderItem.php';
require_once  './models/Inventory.php';
require_once  './models/Review.php';
require_once  './models/Admin.php';
require_once './controllers/ProductController.php';
require_once  './models/Banner.php';

$banner = new Banner();
$banner->createTable();

$user = new User();
$user->createTable();

$category = new Category();
$category->createTable();

$supplier = new Supplier();
$supplier->createTable();

$product = new Product();
$product->createTable();

$payment = new Payment();
$payment->createTable();

$shipping = new Shipping();
$shipping->createTable();

$order = new Order();
$order->createTable();

$order_item = new OrderItem();
$order_item->createTable();

$inventory = new Inventory();
$inventory->createTable();

$review = new Review();
$review->createTable();

$admin = new Admin();
$admin->createTable();





// $productController = new ProductController();
// // $categoryId = $category->insert(['name' => 'Laptop']);
// // $productId = $product->insert([
// //     'name' => 'Macbook Pro',
// //     'price' => 2500,
// //     'category_id' => $categoryId
// // ]);

// $products = $productController->getAll();
// if (count($products) > 0) {
//     foreach ($products as $item) {
//         echo $item['name'];
//     }
// }
echo " <h1>✅TẠO CƠ SỞ DỮ LIỆU THÀNH CÔNG!</h1>";
