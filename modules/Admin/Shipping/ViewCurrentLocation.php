<div class="modal fade" id="currentLocationModal" tabindex="-1" aria-labelledby="currentLocationLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="bi bi-geo-fill me-2"></i> Vị trí hiện tại của người giao</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <ul class="list-unstyled mb-3">
          <li><strong>Mã đơn hàng:</strong> <span id="current-order-id"></span></li>
          <li><strong>Người giao hàng:</strong> <span id="current-shipper-name"></span></li>
          <li><strong>Số điện thoại:</strong> <span id="current-shipper-phone"></span></li>
          <li><strong>Địa chỉ hiện tại của đơn hàng:</strong> <span id="current-address"></span></li>
          <li><strong>Trạng thái:</strong> <span id="current-order-status"></span></li>
        </ul>
        <div class="ratio ratio-16x9">
          <iframe id="current-location-map" class="border rounded shadow" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
