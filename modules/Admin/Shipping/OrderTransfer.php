<?php

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['transferShipping'])) {
  $supplierId = $_POSt['supplierId'];
  $address = $_POST['address'];
  var_dump($supplierId);
  var_dump($address);

  $result = $shippingController->update($supplierId, ['address' => $address]);
  if ($result['success']) {
    $_SESSION['success'] = $result['message'];
  } else {
    $_SESSION['error'] = $result['message'];
  }

  echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Shipping/Shipping.php';</script>";
  exit;
}

?>


<!-- Modal Chuyển đơn -->
<div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content shadow">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title text-white" id="transferLabel">
          <i class="bi bi-arrow-left-right me-2"></i> Chuyển đơn hàng
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <form id="transferForm" method="post">
        <div class="modal-body">
          <input type="text" class="form-control" name="supplierId" id="transfer-supplier-id" readonly>

          <div class="mb-3">
            <label class="form-label">Mã đơn hàng</label>
            <input type="text" class="form-control" id="transfer-order-id" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Vị trí hiện tại</label>
            <input type="text" class="form-control" id="transfer-current-location" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Chuyển đến</label>
            <input type="text" class="form-control" name="address" id="transfer-destination" placeholder="Nhập nơi cần chuyển đến" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning text-white" name="transferShipping">Xác nhận chuyển</button>
        </div>
      </form>
    </div>
  </div>
</div>