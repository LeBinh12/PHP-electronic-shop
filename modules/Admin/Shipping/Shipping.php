<?php
$keyword = $_GET['search'] ?? '';


$keyword = $_GET["search"] ?? "";
$page    = max(1, ($_GET['pageNumber'] ?? 1));
$limit   = 6;
$offset  = ($page - 1) * $limit;

// Lấy dữ liệu từ controller
$listOrders = $orderController->getAllOrdersPagination($keyword, $limit, $offset);
$totalRows  = $orderController->getAllCountOrder($keyword);
$totalPages = max(1, ceil($totalRows / $limit));







require_once 'modules/Admin/Shipping/OrderTransfer.php';
require_once 'modules/Admin/Shipping/ViewSenderLocation.php';
require_once 'modules/Admin/Shipping/ViewCurrentLocation.php';
?>


<!-- Form tìm kiếm -->
<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Shipping/Shipping.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm hàng đang giao...">
        </form>
    </div>

    <!-- Table hiển thị đơn hàng -->
    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px">ID</th>
                        <th style="width: 180px">Tên khách hàng</th>
                        <th style="width: 200px">Địa chỉ người gửi</th>
                        <th style="width: 200px">Địa chỉ hiện tại</th>

                        <th style="width: 380px">Chức năng</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listOrders as $order) {
                        if ($order['status_id'] !== 6) {
                    ?>

                            <tr>
                                <td><?= $order['code'] ?></td>
                                <td><?= $order['FullName'] ?></td>
                                <td><?= $order['Address'] ?></td>
                                <td><?= $order['shipping_address'] ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white"
                                        onclick='showSenderInfo(<?= json_encode([
                                                                    "id" => $order["code"],
                                                                    "senderName" => $order["FullName"],
                                                                    "senderPhone" => $order["Phone"],
                                                                    "senderAddress" => $order["Address"]
                                                                ]) ?>)'>
                                        <i class="bi bi-geo-alt-fill me-1"></i> Xem vị trí người gửi
                                    </button>

                                    <!-- Nút xem vị trí hiện tại của đơn hàng -->
                                    <button class="btn btn-sm btn-success text-white"
                                        onclick='showCurrentLocation(<?= json_encode([
                                                                            "id" => $order["code"],
                                                                            "shipperName" => $order["FullName"],
                                                                            "shipperPhone" => $order["Phone"],
                                                                            "status" => $order["shipping_status"],
                                                                            "currentAddress" => $order["shipping_address"] // vị trí đơn hàng hiện tại
                                                                        ]) ?>)'>
                                        <i class="bi bi-geo-alt me-1"></i> Vị trí hiện tại
                                    </button>


                                    <button
                                        class="btn btn-warning btn-sm text-white"
                                        data-bs-toggle="modal"
                                        data-bs-target="#transferModal"
                                        onclick="loadTransferForm('<?= $order['code'] ?>', '<?= $order['shipping_address'] ?>', '<?= $order['shipping_id'] ?>')">
                                        Chuyển đơn
                                    </button>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Shipping/Shipping.php&search=<?= urlencode($keyword) ?>&pageNumber=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lắng nghe submit form trong modal (nếu có)
        document.querySelectorAll(
            "#transferModal form"
        ).forEach(form => {
            form.addEventListener("submit", function() {
                Loading(true);
            });
        });

        // Lắng nghe click nút submit trong modal (nếu có)
        document.querySelectorAll(
            "#transferModal button[type=submit]"
        ).forEach(btn => {
            btn.addEventListener("click", function() {
                Loading(true);
            });
        });

        // Lắng nghe submit form tìm kiếm
        const searchForm = document.querySelector(".search-form");
        if (searchForm) {
            searchForm.addEventListener("submit", function() {
                Loading(true);
            });
        }

        // Lắng nghe click phân trang
        document.querySelectorAll(".pagination .page-link").forEach(link => {
            link.addEventListener("click", function() {
                Loading(true);
            });
        });
    });
</script>