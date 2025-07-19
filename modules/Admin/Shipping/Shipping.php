<?php
$keyword = $_GET['search'] ?? '';

// Dữ liệu mẫu (chi tiết)
$orders = [
    [
        'id' => 'DH001',
        'name' => 'Đơn hàng A',
        'senderName' => 'Nguyễn Văn A',
        'senderPhone' => '0123456789',
        'senderAddress' => '123 Đường Lê Lợi, Quận 1, TP.HCM',
        'senderLocation' => '10.762622,106.660172',
        'current' => '123 Đường Lê Lợi, Quận 1, TP.HCM',
        'shipperName' => 'Nguyễn Giao Hàng',
        'shipperPhone' => '0901122334',
        'status' => 'Đang giao'
    ],
    [
        'id' => 'DH002',
        'name' => 'Đơn hàng B',
        'senderName' => 'Trần Thị B',
        'senderPhone' => '0987654321',
        'senderAddress' => '456 Đường Nguyễn Huệ, Quận 1, TP.HCM',
        'senderLocation' => '10.774329,106.700806',
        'current' => '456 Đường Nguyễn Huệ, Quận 1, TP.HCM',
        'shipperName' => 'Trần Giao Nhanh',
        'shipperPhone' => '0909988776',
        'status' => 'Đang lấy hàng'
    ]
];




require_once 'modules/Admin/Shipping/OrderTransfer.php';
require_once 'modules/Admin/Shipping/ViewSenderLocation.php';
require_once 'modules/Admin/Shipping/ViewCurrentLocation.php';

// Nếu có từ khóa, lọc danh sách
if ($keyword) {
    $orders = array_filter($orders, function ($order) use ($keyword) {
        return stripos($order['id'], $keyword) !== false ||
               stripos($order['name'], $keyword) !== false ||
               stripos($order['senderAddress'], $keyword) !== false;
    });
}
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
                        <th style="width: 200px">Tên khách hàng</th>
                        <th style="width: 200px">Địa chỉ người gửi</th>
                        <th style="width: 200px">Địa chỉ hiện tại</th>
                        <th style="width: 340px">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= $order['name'] ?></td>
                            <td><?= $order['senderAddress'] ?></td>
                            <td><?= $order['current'] ?></td>
                            <td>
                               <button class="btn btn-sm btn-info text-white"
    onclick='showSenderInfo(<?= json_encode([
        "id" => $order["id"],
        "name" => $order["name"],
        "senderName" => $order["senderName"],
        "senderPhone" => $order["senderPhone"],
        "senderAddress" => $order["senderAddress"]
    ]) ?>)'>
    <i class="bi bi-geo-alt-fill me-1"></i> Xem vị trí người gửi
</button>

<!-- Nút xem vị trí hiện tại của đơn hàng -->
<button class="btn btn-sm btn-success text-white"
  onclick='showCurrentLocation(<?= json_encode([
    "id" => $order["id"],
    "shipperName" => $order["shipperName"],
    "shipperPhone" => $order["shipperPhone"],
    "status" => $order["status"],
    "currentAddress" => $order["current"]
  ]) ?>)'>
  <i class="bi bi-geo-alt me-1"></i> Vị trí hiện tại
</button>


<button
  class="btn btn-warning btn-sm text-white"
  data-bs-toggle="modal"
  data-bs-target="#transferModal"
  onclick="loadTransferForm('<?= $order['id'] ?>', '<?= $order['current'] ?>')">
  Chuyển đơn
</button>

 
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>  