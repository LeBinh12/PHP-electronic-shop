<!-- Modal Thông tin người gửi (bản đồ to full chiều rộng) -->
<div class="modal fade" id="senderLocationModal" tabindex="-1" aria-labelledby="senderLocationLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="senderLocationLabel">
          <i class="bi bi-geo-alt-fill me-2"></i> Thông tin người gửi
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <!-- Thông tin -->
        <ul class="list-unstyled mb-4">
          <li><strong>Mã đơn hàng:</strong> <span id="modal_order_id"></span></li>
          <li><strong>Tên đơn hàng:</strong> <span id="modal_order_name"></span></li>
          <li><strong>Người gửi:</strong> <span id="modal_sender_name"></span></li>
          <li><strong>Số điện thoại:</strong> <span id="modal_sender_phone"></span></li>
          <li><strong>Địa chỉ gửi:</strong> <span id="modal_sender_address"></span></li>
        </ul>

        <!-- Bản đồ to full chiều ngang -->
        <div class="ratio ratio-16x9 border rounded shadow">
          <iframe
            id="mapIframe"
            src=""
            style="border:0;"
            allowfullscreen
            loading="lazy">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</div>