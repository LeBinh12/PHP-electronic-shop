<?php
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

$orderItems = [
    101 => [
        ['product_id' => 1, 'unit_price' => 1200000, 'quantity' => 1],
        ['product_id' => 2, 'unit_price' => 150000, 'quantity' => 2]
    ]
];

$userMap = [
    1 => [
        'FullName' => 'Nguyễn Văn A',
        'email' => 'nguyenvana@gmail.com',
        'phone' => '0123456789',
        'address' => '123 Đường A, Quận 1, TP.HCM'
    ]
];

$productMap = [
    1 => [
        'name' => 'Laptop XYZ',
        'image_url' => 'https://via.placeholder.com/80x80?text=Laptop'
    ],
    2 => [
        'name' => 'Chuột không dây ABC',
        'image_url' => 'https://via.placeholder.com/80x80?text=Chuột'
    ]
];

$orderData = $orderMap[$orderId] ?? null;
if (!$orderData) {
    echo "<div class='alert alert-danger'>Không tìm thấy đơn hàng!</div>";
    exit;
}
$userData = $userMap[$orderData['user_id']];
?>

<!-- MODAL CHI TIẾT -->
<div class="modal fade" id="viewOrderModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Chi tiết đơn hàng #<?= $orderData['code'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
  <div class="row mb-4">
    <!-- Thông tin khách hàng -->
    <div class="col-md-6">
      <h5>Thông tin khách hàng</h5>
      <ul class="list-unstyled">
        <li><strong>Họ tên:</strong> <?= $userData['FullName'] ?></li>
        <li><strong>Email:</strong> <?= $userData['email'] ?></li>
        <li><strong>Số điện thoại:</strong> <?= $userData['phone'] ?></li>
        <li><strong>Địa chỉ:</strong> <?= $userData['address'] ?></li>
      </ul>
    </div>

    <!-- Thông tin đơn hàng -->
    <div class="col-md-6">
      <h5>Thông tin đơn hàng</h5>
      <ul class="list-unstyled">
        <li><strong>Mã đơn hàng:</strong> <?= $orderData['code'] ?></li>
        <li><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($orderData['create_at'])) ?></li>
        <li><strong>Trạng thái:</strong> <?= $orderData['status'] ?></li>
        <li><strong>Tổng tiền:</strong> <?= number_format($orderData['total_amount'], 0) ?> đ</li>
      </ul>
    </div>
  </div>

  <!-- Sản phẩm -->
  <h5>Sản phẩm</h5>
    <table class="table table-bordered table-hover custom-table">
    <thead class="table-secondary">
      <tr>
        <th>Hình ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Đơn giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      foreach ($orderItems[$orderId] as $item):
          $product = $productMap[$item['product_id']];
          $subtotal = $item['unit_price'] * $item['quantity'];
          $total += $subtotal;
      ?>
        <tr>
          <td><img src="<?= $product['image_url'] ?>" width="80"></td>
          <td><?= $product['name'] ?></td>
          <td><?= number_format($item['unit_price'], 0) ?> đ</td>
          <td><?= $item['quantity'] ?></td>
          <td><?= number_format($subtotal, 0) ?> đ</td>
        </tr>
      <?php endforeach ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="4" class="text-end">Tổng cộng:</th>
        <th><?= number_format($total, 0) ?> đ</th>
      </tr>
    </tfoot>
  </table>
</div>


      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
