<?php
$fullName = $employeeData ? $employeeData->name : '';
$email = $employeeData ? $employeeData->email : '';
$phone = $employeeData ? $employeeData->phone : '';
$address = $employeeData ? $employeeData->address : '';
if ($_SESSION['admin']) {
  $fullName = $_SESSION['admin']['username'];
  $email = $_SESSION['admin']['email'];
}

if ($_SERVER['REQUEST_METHOD'] && isset($_POST['saveChange'])) {
  if ($_SESSION['admin']) {
    $data = [
      'username' => $_POST['fullname'],
      'email' => $_POST['email']
    ];

    $result = $adminController->update($_SESSION['admin']['id'], $data);

    if ($result['success']) {
      $_SESSION['admin'] = $adminController->getById($_SESSION['admin']['id']);
      $_SESSION['success'] = $result['message'];
    } else {
      $_SESSION['error'] = $result['message'];
    }
  } else {
    $data = [
      'name' => $_POST['fullname'],
      'email' => $_POST['email'],
      'phone' => $_POST['phone'],
      'address' => $_POST['address'],
    ];

    $result = $employeeController->update($employeeData->id, $data);
    if ($result['success']) {
      $employeeController->refreshtoken($employeeData->id);
      $employeeData = $employeeController->getCurrentEmployee();
      $_SESSION['success'] = $result['message'];
    } else {
      $_SESSION['error'] = $result['message'];
    }
  }

  echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Profile/index.php';</script>";
  exit;
}

?>



<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editProfileLabel"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa hồ sơ</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Họ và tên</label>
              <input type="text" class="form-control" name="fullname" value="<?= $fullName ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" value="<?= $email ?>" required>
            </div>
            <?php
            if ($employeeData) {
            ?>
              <div class="col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" name="phone" value="<?= $phone ?>">
              </div>
              <div class="col-md-12">
                <label class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" name="address" value="<?= $address ?>">
              </div>
          </div>
        <?php
            }
        ?>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary" name="saveChange">Lưu thay đổi</button>
        </div>
      </form>
    </div>
  </div>
</div>