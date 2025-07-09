<?php
$keyword = $_GET['search'] ?? '';
$statusGetAll = $statusController->getAll();

$filterStatusId = $_POST['filter_status'] ?? '0';
$searchCode = $_POST['order_code'] ?? '';

$statusId  = $_GET['status_id']  ?? '';
$page      = max(1, (int)($_GET['page'] ?? 1));
$limit     = 2;
$offset    = ($page - 1) * $limit;


$userId = $userData->id;


if ($filterStatusId == 0) {
    $orders = $orderController->getOrderPagination(
        $userId,
        null,
        $limit,
        $offset,
        $keyword,
    );
} else {
    $orders = $orderController->getOrderPagination(
        $userId,
        $filterStatusId,
        $limit,
        $offset,
        $keyword,
    );
}
$totalRows = $orderController->getCountOrder(
    $userId,
    $filterStatusId,
    $keyword,
);
$totalPages = max(1, ceil($totalRows / $limit));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
    $id = $_POST['cancel_order'];

    $result = $orderController->edit($id, ["status_id" => 5]);

    if ($result['success']) {
        echo "<script>
            alert('Hủy đơn hàng thành công!');
            window.location.href = 'Index.php?subpage=modules/Users/page/CheckOrder.php';
        </script>";
    } else {
        echo "<script>
            alert('Hủy đơn hàng thất bại do hệ thông đang bảo trì!');
            window.location.href = 'Index.php?subpage=modules/Users/page/CheckOrder.php';
        </script>";
    }
}


// var_dump($statusGetAll);
// echo "<br>";
// var_dump($orders);


// foreach ($orders as $item) {
//     $order_item = $orderItemController->getOrderItemById($item["order_id"]);
//     var_dump($order_item);
// }
?>

<div class="order-page-container container my-4">
    <div class="order-layout">
        <div class="order-content">
            <div class="order-header">
                <h5>Đơn hàng đã mua</h5>
                <div class="search-filter">
                    <form method="post" class="order-search-form">
                        <div class="search-box">
                            <input type="text" name="order_code" placeholder="Nhập mã đơn hàng..." value="<?= $_POST['order_id'] ?? '' ?>">
                            <button type="submit" class="btn btn-primary">Tra cứu</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bộ lọc trạng thái -->
            <form method="post" class="status-filter-form mb-3">
                <input type="hidden" name="filter_status" id="filter_status" value="<?= htmlspecialchars($filterStatusId) ?>">
                <div class="order-status-filter">
                    <button type="button" class="status-btn <?= ($filterStatusId == 0) ? 'active' : '' ?>" onclick="filterStatus(0)">Tất cả</button>

                    <?php foreach ($statusGetAll as $status): ?>
                        <button type="button"
                            class="status-btn <?= ($filterStatusId == $status['id']) ? 'active' : '' ?>"
                            onclick="filterStatus(<?= $status['id'] ?>)">
                            <?= htmlspecialchars($status['name']) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </form>

            <?php
            $filter = $_POST['filter_status'] ?? 'Tất cả';
            $searchCode = $_POST['order_id'] ?? '';
            $filteredOrders = [];

            foreach ($orders as $order) {
                if (($filter === 'Tất cả' || $order['status_id'] === $filter) &&
                    ($searchCode === '' || stripos($order['order_id'], $searchCode) !== false)
                ) {
                    $filteredOrders[] = $order;
                }
            }
            ?>

            <?php if (count($orders) > 0) {
            ?>
                <?php foreach ($orders as $order) { ?>
                    <?php
                    $orderItems = $orderItemController->getOrderItemById($order["order_id"]);
                    ?>
                    <div class="order-item">
                        <div class="order-item-header">
                            <h6>Mã đơn: <?= htmlspecialchars($order['code']) ?> | Trạng thái: <?= htmlspecialchars($order['status_name']) ?></h6>
                            <strong>Tổng tiền: <?= number_format($order['total_amount'], 0, ',', '.') ?>₫</strong>
                        </div>

                        <div class="order-item-info-row">
                            <div class="shipping-info">
                                <h5>Thông tin nhận hàng:</h5>
                                <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['FullName']) ?></p>
                                <p><strong>SĐT:</strong> <?= htmlspecialchars($order['Phone']) ?></p>
                                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['Address']) ?></p>
                                <p><strong>Email:</strong> <?= htmlspecialchars($order['Email']) ?></p>
                            </div>

                            <div class="order-product-list">
                                <h5>Thông tin sản phẩm:</h5>
                                <?php foreach ($orderItems as $product) { ?>
                                    <div class="order-product">
                                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                        <div class="order-product-info">
                                            <h6><?= htmlspecialchars($product['name']) ?></h6>
                                            <div class="order-product-price"><?= number_format($product['price'], 0, ',', '.') ?>₫</div>
                                            <p>Số lượng: <?= $product['quantity'] ?></p>
                                        </div>
                                    </div>
                                <?php }; ?>
                            </div>
                        </div>

                        <?php if ($order['status_name'] === 'Chờ xử lý') { ?>
                            <form method="post" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn?')">
                                <input type="hidden" name="cancel_order" value="<?= htmlspecialchars($order['order_id']) ?>">
                                <button type="submit" class="cancel-btn">Hủy đơn hàng</button>
                            </form>
                        <?php } ?>
                    </div>
                <?php }
            } else { ?>
                <div class="empty-order">
                    <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="No order">
                    <h6>Rất tiếc, không tìm thấy đơn hàng nào phù hợp</h6>
                </div>
            <?php } ?>

            <?php if (count($orders) > 0 && $totalPages > 1) { ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?subpage=modules/Users/page/CheckOrder.php&search=<?= $keyword ?>&page=<?= $i ?>&filter_status=<?= $filterStatusId ?>&order_code=<?= urlencode($searchCode) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            <?php } ?>

        </div>
    </div>
</div>