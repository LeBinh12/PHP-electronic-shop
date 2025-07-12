<!-- Modal Chỉnh sửa Thông tin Cá nhân -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form action="updateprofile.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editProfileLabel"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa hồ sơ</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Họ và tên</label>
              <input type="text" class="form-control" name="fullname" value="Nguyễn Thanh Tùng" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" value="nguyenvana@example.com" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Số điện thoại</label>
              <input type="text" class="form-control" name="phone" value="0123 456 789">
            </div>
            <div class="col-md-6">
              <label class="form-label">Chức vụ</label>
              <select class="form-select" name="role">
                <option>Admin</option>
                <option>Nhân viên</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label">Địa chỉ</label>
              <input type="text" class="form-control" name="address" value="123 Lý Thường Kiệt, Q.10, TP.HCM">
            </div>
            <div class="col-md-12">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" name="avatar" accept="image/*" onchange="previewAvatar(this)">
                <small class="text-muted">Nếu không thay đổi thì để trống.</small>

            <!-- Ảnh preview -->
            <div class="mt-3">
                 <img id="avatarPreview" src="Style/Images/mtp.jpg" alt="Ảnh xem trước" class="rounded-circle border" width="80" height="80">
            </div>
        </div>
          </div>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </div>
      </form>
    </div>
  </div>
</div>
