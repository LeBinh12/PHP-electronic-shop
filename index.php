<?php
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './models/Category.php';
require_once  './models/Product.php';


$category = new Category();
$category->createTable();
$categoryId = $category->insert(['name' => 'Laptop']);

$product = new Product();
$product->createTable();
$productId = $product->insert([
    'name' => 'Macbook Pro',
    'price' => 2500,
    'category_id' => $categoryId
]);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Dữ liệu khi thêm categories <?php $category ?></h1>
    <h1>Dữ liệu khi thêm products <?php $product ?></h1>

</body>

</html>