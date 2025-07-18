<?php
$keyword = $_GET['search'] ?? '';
$statusGetAll = $statusController->getAll();

$filterStatusId = $_GET['filter_status'] ?? '0';
$searchCode = $_POST['order_code'] ?? '';

$statusId  = $_GET['status_id']  ?? '';
$page      = max(1, (int)($_GET['page'] ?? 1));
$limit     = 2;
$offset    = ($page - 1) * $limit;

$userId = $userData->id;
// $address = "Trường Đại Học Đồng Tháp";

if ($filterStatusId == 0) {
    $orders = $orderController->getOrderPagination(
        $userId,
        null,
        $limit,
        $offset,
        $keyword,
    );
    $totalRows = $orderController->getCountOrder(
        $userId,
        null,
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
    $totalRows = $orderController->getCountOrder(
        $userId,
        $filterStatusId,
        $keyword,
    );
}

$totalPages = max(1, ceil($totalRows / $limit));
$groupSize = 3;
$pageGroup = ceil($page / $groupSize);
$startPage = ($pageGroup - 1) * $groupSize + 1;
$endPage = min($startPage + $groupSize - 1, $totalPages);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
    $node_cancel = $_POST['cancel_reason'] ?? "";
    $cancel_by = "user." . $userData->id;
    $id = $_POST['cancel_order'];
    var_dump($id);
    $data = [
        "status_id" => 5,
        "cancel_reason" => $node_cancel,
        "cancel_at" => date("Y-m-d H:i:s"),
        "cancel_by" => $cancel_by
    ];
    $result = $orderController->edit($id, $data);

    if ($result['success']) {
        echo "<script>
            alert('Hủy đơn hàng thành công!');
            window.location.href = 'Index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=$filterStatusId';
        </script>";
    } else {
        echo "<script>
            alert('Hủy đơn hàng thất bại do hệ thông đang bảo trì!');
            window.location.href = 'Index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=$filterStatusId';
        </script>";
    }
}
?>

<div class="order-page-container container my-4">
    <div class="order-layout">
        <div class="order-content">
            <div class="order-header">
                <h5>Đơn hàng đã mua</h5>
                <div class="search-filter">
                    <form method="get" class="order-search-form">
                        <input type="hidden" name="subpage" value="modules/Users/page/CheckOrder.php">
                        <input type="hidden" name="filter_status" value="<?= $filterStatusId ?>">
                        <div class="search-box">
                            <input type="text" name="search" placeholder="Nhập mã đơn hàng..." value="<?= $keyword ?>">
                            <button type="submit" class="btn btn-primary">Tra cứu</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bộ lọc trạng thái -->
            <form method="post" class="status-filter-form mb-3">
                <input type="hidden" name="filter_status" id="filter_status" value="<?= htmlspecialchars($filterStatusId) ?>">
                <div class="order-status-filter">
                    <a class="status-btn text-decoration-none <?= ($filterStatusId == 0) ? 'active' : '' ?>" href="index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=0">Tất cả</a>

                    <?php foreach ($statusGetAll as $status): ?>
                        <a type="button"
                            class="status-btn text-decoration-none <?= ($filterStatusId == $status['id']) ? 'active' : '' ?>"
                            href="index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=<?= $status['id'] ?>">
                            <?= htmlspecialchars($status['name']) ?>
                        </a>
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
                        <div class="order-item-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h6>Mã đơn: <?= htmlspecialchars($order['code']) ?> | Trạng thái: <?= htmlspecialchars($order['status_name']) ?></h6>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <?php if ($order['status_name'] === 'Đang giao hàng') { ?>
                                    <a href="index.php?subpage=modules/Users/page/OrderTracking.php&order_id=<?= htmlspecialchars($order['order_id']) ?>"
                                        class="btn btn-outline-primary btn-sm"
                                        style=" background-color: #007bff; 
                                                color: #fff; 
                                                border: none;
                                                padding: 6px 14px;
                                                border-radius: 20px;
                                                font-size: 0.9rem;
                                                transition: background-color 0.3s ease;
                                                box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
                                                text-decoration: none;
                                                display: inline-block;"
                                        onmouseover="this.style.backgroundColor='#0056b3'"
                                        onmouseout="this.style.backgroundColor='#007bff'">
                                        Xem vị trí đơn hàng
                                    </a>
                                <?php } ?>
                                <strong class="mb-0">Tổng tiền: <?= number_format($order['total_amount'], 0, ',', '.') ?>₫</strong>
                            </div>
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
                                            <div class="order-product-price"><?= number_format($product['unit_price'], 0, ',', '.') ?>₫</div>
                                            <p>Số lượng: <?= $product['quantity'] ?></p>
                                        </div>
                                    </div>
                                <?php }; ?>
                            </div>
                        </div>
                        <?php if ($order['status_name'] === 'Chờ xử lý') { ?>
                            <button type="button" class="cancel-btn" data-bs-toggle="modal" data-bs-target="#cancelModal" data-order-id="<?= htmlspecialchars($order['order_id']) ?>">
                                Hủy đơn hàng
                            </button>
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

                        <?php if ($totalPages > $groupSize && $startPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?subpage=modules/Users/page/CheckOrder.php&search=<?= $keyword ?>&page=<?= $startPage - 1 ?>&filter_status=<?= $filterStatusId ?>&order_code=<?= urlencode($searchCode) ?>">
                                    «
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?subpage=modules/Users/page/CheckOrder.php&search=<?= $keyword ?>&page=<?= $i ?>&filter_status=<?= $filterStatusId ?>&order_code=<?= urlencode($searchCode) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($totalPages > $groupSize && $endPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?subpage=modules/Users/page/CheckOrder.php&search=<?= $keyword ?>&page=<?= $endPage + 1 ?>&filter_status=<?= $filterStatusId ?>&order_code=<?= urlencode($searchCode) ?>">
                                    »
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Xử lý Map -->
<!-- <h1>Vị trí đơn hàng của bạn</h1>
<div id="map" style="width:100%;height:400px;"></div> -->

<?php
$cancelReasons = [
    "Muốn đổi sản phẩm",
    "Đặt nhầm",
    "Thời gian giao hàng lâu",
    "Tìm được giá tốt hơn",
    "Không còn nhu cầu",
    "Khác"
];
?>

<!-- Modal chọn lý do hủy -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="display: flex; align-items: center; justify-content: center;">
        <form method="post" id="cancelForm">
            <input type="hidden" name="cancel_order" id="cancel_order_id">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-semibold text-primary">
                        <i class="bi bi-x-circle-fill me-2 text-danger"></i>Chọn lý do hủy đơn
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-white">
                    <p class="mb-3 text-muted">
                        Trước khi hủy đơn, bạn vui lòng cho chúng tôi biết lý do. Điều này giúp chúng tôi cải thiện chất lượng dịch vụ tốt hơn.
                    </p>
                    <select class="form-select rounded-3 py-3 px-4" id="reasonSelect" name="cancel_reason" required>
                        <option disabled selected>-- Chọn lý do --</option>
                        <?php foreach ($cancelReasons as $reason): ?>
                            <option value="<?= htmlspecialchars($reason) ?>"><?= htmlspecialchars($reason) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-3 fs-6">Xác nhận hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal nhập lý do khác -->
<div class="modal fade" id="customReasonModal" tabindex="-1" aria-labelledby="customReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="display: flex; align-items: center; justify-content: center;">
        <form method="post">
            <input type="hidden" name="cancel_order" id="custom_order_id">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-semibold text-primary">
                        Nhập lý do hủy đơn
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-white">
                    <p class="mb-3 text-muted">
                        Bạn đã chọn "Khác" là lý do hủy đơn. Hãy cho chúng tôi biết thêm chi tiết để có thể cải thiện dịch vụ trong tương lai.
                    </p>
                    <div class="form-group">
                        <label class="form-label fw-semibold mb-2">Lý do cụ thể</label>
                        <textarea class="form-control rounded-3 py-2 px-3 fs-6" name="cancel_reason" rows="4" required placeholder="Ví dụ: Tôi cần thay đổi địa chỉ giao hàng, đơn bị lỗi thanh toán, v.v..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-3">Xác nhận hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cancelButtons = document.querySelectorAll(".cancel-btn");
        const cancelInput = document.getElementById("cancel_order_id");

        cancelButtons.forEach(button => {
            button.addEventListener("click", function() {
                const orderId = this.getAttribute("data-order-id");
                cancelInput.value = orderId;
            })
        })
        document.getElementById('reasonSelect').addEventListener('change', function() {
            if (this.value === 'Khác') {
                const orderId = document.getElementById('cancel_order_id').value;
                const cancelModalInstance = bootstrap.Modal.getInstance(document.getElementById('cancelModal'));
                cancelModalInstance.hide();

                document.getElementById('custom_order_id').value = orderId;
                const customModal = new bootstrap.Modal(document.getElementById('customReasonModal'));
                customModal.show();
            }
        });
    })
</script>