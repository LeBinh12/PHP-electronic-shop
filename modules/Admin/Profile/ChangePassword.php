<?php

if ($_SERVER['REQUEST_METHOD'] && isset($_POST['ChangeToPassword'])) {
  $passwordOld = $_POST['current_password'];
  $passwordNew = $_POST['new_password'];
  $changePassword = $_POST['confirm_password'];

  if ($passwordNew == $changePassword) {
    if ($_SESSION['admin']) {
      $result = $adminController->ChangePassword($_SESSION['admin']['email'], $passwordOld, $passwordNew);
      if ($result['success']) {
        $_SESSION['success'] = $result['message'];
      } else {
        $_SESSION['error'] = $result['message'];
      }
    } else {
      $result = $employeeController->ChangeToPassword($employeeData->email, $passwordOld, $passwordNew);
      if ($result['success']) {
        $_SESSION['success'] = $result['message'];
      } else {
        $_SESSION['error'] = $result['message'];
      }
    }
  } else {
    $_SESSION['error'] = "Mật khẩu không trùng khớp!";
  }
  echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Profile/index.php';</script>";
  exit;
}

?>


<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="changePasswordLabel"><i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label"></label>
            <input type="password" class="form-control" name="current_password" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Mật khẩu mới</label>
            <input type="password" class="form-control" name="new_password" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" class="form-control" name="confirm_password" required>
          </div>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" name="ChangeToPassword" class="btn btn-warning text-white">Lưu thay đổi</button>
        </div>
      </form>
    </div>
  </div>
</div>