<?php
$keyword = $_GET["search"] ?? "";
$page      = max(1, (int)($_GET['page'] ?? 1));
$limit     = 6;
$offset    = ($page - 1) * $limit;


$order = $orderController->getAllOrdersPagination($keyword, $limit, $offset);

$totalRows = $orderController->getAllCountOrder($keyword);

$totalPages = max(1, ceil($totalRows / $limit));

echo "<h1>Đơn hàng</h1>";
foreach ($order as $item) {
    var_dump($item);
    echo "<br>";
}
echo "<h1>chi tiết đơn hàng</h1>";

var_dump($orderItemController->getOrderItemById(16));


echo "<h1>Tổng số trang</h1>";

var_dump($totalPages);
