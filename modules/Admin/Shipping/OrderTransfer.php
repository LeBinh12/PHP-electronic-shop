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
      <form id="transferForm" onsubmit="submitTransfer(event)">
        <div class="modal-body">
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
            <input type="text" class="form-control" id="transfer-destination" placeholder="Nhập nơi cần chuyển đến" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning text-white">Xác nhận chuyển</button>

        </div>
      </form>
    </div>
  </div>
</div>
