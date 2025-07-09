<?php
session_start();

// Gắn dữ liệu ảo nếu chưa có trong session
if (!isset($_SESSION['orderItems'])) {
  $_SESSION['orderItems'] = [
    101 => [
      ['product_id' => 1, 'unit_price' => 1200000, 'quantity' => 1],
      ['product_id' => 2, 'unit_price' => 150000, 'quantity' => 2],
    ]
  ];
}

// Xử lý cập nhật số lượng qua AJAX
if (isset($_GET['update_quantity'])) {
  $orderId = $_GET['orderid'] ?? 101;
  $productId = (int) $_GET['product_id'];
  $delta = (int) $_GET['delta'];
  foreach ($_SESSION['orderItems'][$orderId] as &$item) {
    if ($item['product_id'] == $productId) {
      $item['quantity'] = max(1, $item['quantity'] + $delta);
      echo json_encode(['success' => true, 'newQuantity' => $item['quantity']]);
      exit;
    }
  }
  echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
  exit;
}

// ==================== DỮ LIỆU ====================
$orderId = $_GET['id'] ?? 101;

$orderMap = [
  101 => [
    'id' => 101,
    'code' => 'DH101',
    'user_id' => 1,
    'status' => 'Chờ xử lý',
    'create_at' => '2025-06-30 14:30:00',
    'total_amount' => 1500000
  ]
];

$userMap = [
  1 => [
    'FullName' => 'Nguyễn Văn A',
    'email' => 'a@gmail.com',
    'phone' => '0123456789',
    'address' => '123 Đường A, Quận 1, TP.HCM'
  ]
];

$productMap = [
  1 => ['name' => 'Laptop XYZ', 'image_url' => 'https://via.placeholder.com/80x80?text=Laptop'],
  2 => ['name' => 'Chuột không dây ABC', 'image_url' => 'https://via.placeholder.com/80x80?text=Chu%E1%BB%99t']
];

$orderData = $orderMap[$orderId] ?? null;
if (!$orderData) {
  echo "<div class='alert alert-danger'>Không tìm thấy đơn hàng!</div>";
  exit;
}

$userData = $userMap[$orderData['user_id']];
$orderItems = $_SESSION['orderItems'];
?>

<!-- ========== MODAL XEM & CHỈNH SỬA ĐƠN HÀNG ========== -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="viewOrderModalLabel">Chỉnh sửa đơn hàng #<?= $orderData['code'] ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-4">
            <div class="col-md-6">
              <h5>Thông tin khách hàng</h5>
              <ul class="list-unstyled">
                <li><strong>Họ tên:</strong> <?= $userData['FullName'] ?></li>
                <li><strong>Email:</strong> <?= $userData['email'] ?></li>
                <li><strong>Số điện thoại:</strong> <?= $userData['phone'] ?></li>
                <li><strong>Địa chỉ:</strong> <?= $userData['address'] ?></li>
              </ul>
            </div>
            <div class="col-md-6">
              <h5>Thông tin đơn hàng</h5>
              <ul class="list-unstyled">
                <li><strong>Mã đơn hàng:</strong> <?= $orderData['code'] ?></li>
                <li><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($orderData['create_at'])) ?></li>
                <li class="d-flex align-items-center gap-2">
                  <strong>Trạng thái:</strong>
                  <form method="POST" action="modules/Admin/Orders/ChangeStatusOrder.php">
                    <input type="hidden" name="order_id" value="<?= $orderData['id'] ?>">
                    <select name="status" class="form-select form-select-sm w-auto pe-4" onchange="this.form.submit()">
                      <?php
                      $statusOptions = ['Chờ xử lý', 'Đang giao', 'Hoàn thành', 'Đã hủy'];
                      foreach ($statusOptions as $status) {
                        $selected = $orderData['status'] === $status ? 'selected' : '';
                        echo "<option value='$status' $selected>$status</option>";
                      }
                      ?>
                    </select>
                  </form>
                </li>
                <li><strong>Tổng tiền:</strong> <?= number_format($orderData['total_amount'], 0) ?> đ</li>
              </ul>
            </div>
          </div>

          <h5>Sản phẩm</h5>
          <table class="table table-bordered text-center">
            <thead class="table-warning">
              <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orderItems[$orderId] as $item):
                $product = $productMap[$item['product_id']];
                $subtotal = $item['unit_price'] * $item['quantity'];
              ?>
              <tr>
                <td><img src="<?= $product['image_url'] ?>" width="60" height="60"></td>
                <td><?= $product['name'] ?></td>
                <td><?= number_format($item['unit_price'], 0) ?> đ</td>
                <td>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(<?= $orderId ?>, <?= $item['product_id'] ?>, -1)">-</button>
                    <span id="qty-<?= $item['product_id'] ?>"><?= $item['quantity'] ?></span>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(<?= $orderId ?>, <?= $item['product_id'] ?>, 1)">+</button>
                  </div>
                </td>
                <td><?= number_format($subtotal, 0) ?> đ</td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
      </form>
    </div>
  </div>
</div>



