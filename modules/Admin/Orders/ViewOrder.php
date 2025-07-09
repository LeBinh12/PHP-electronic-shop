<?php

if (isset($_GET['id'])) {
  $orderId = $_GET['id'];

  $orderMap = $orderController->getById($orderId);

  $orderItems = $orderItemController->getOrderItemById($orderId);

  $userData = $userController->getById($orderMap["user_id"]);

  $statusData = $statusController->getById(id: $orderMap['status_id']);
?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const modal = new bootstrap.Modal(document.getElementById('viewOrderModal'));
      modal.show();
    });
  </script>
<?php
}


?>

<!-- MODAL CHI TIẾT -->
<div class="modal fade" id="viewOrderModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Chi tiết đơn hàng #<?= $orderMap['code'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row mb-4">
          <!-- Thông tin khách hàng -->
          <div class="col-md-6">
            <h5>Thông tin khách hàng</h5>
            <ul class="list-unstyled">
              <li><strong>Họ tên:</strong> <?= $userData['FullName'] ?></li>
              <li><strong>Email:</strong> <?= $userData['Email'] ?></li>
              <li><strong>Số điện thoại:</strong> <?= $userData['Phone'] ?></li>
              <li><strong>Địa chỉ:</strong> <?= $userData['Address'] ?></li>
            </ul>
          </div>

          <!-- Thông tin đơn hàng -->
          <div class="col-md-6">
            <h5>Thông tin đơn hàng</h5>
            <ul class="list-unstyled">
              <li><strong>Mã đơn hàng:</strong> <?= $orderMap['code'] ?></li>
              <li><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($orderMap['create_at'])) ?></li>
              <li><strong>Trạng thái:</strong> <?= $statusData['name'] ?></li>
              <li><strong>Tổng tiền:</strong> <?= number_format($orderMap['total_amount'], 0) ?> đ</li>
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
            foreach ($orderItems as $item) {
              $subtotal = $item['unit_price'] * $item['quantity'];
              $total += $subtotal;
            ?>
              <tr>
                <td><img src="<?= $item['image_url'] ?>" width="80"></td>
                <td><?= $item['name'] ?></td>
                <td><?= number_format($item['unit_price'], 0) ?> đ</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($subtotal, 0) ?> đ</td>
              </tr>
            <?php } ?>
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