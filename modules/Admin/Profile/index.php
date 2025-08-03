<div class="container mt-5 pt-4">

  <!-- Hero -->
  <div class="bg-primary text-white rounded-4 p-4 d-flex align-items-center justify-content-between shadow-lg">
    <div class="d-flex align-items-center">
      <img src="
        <?=
        $_SESSION['admin'] ? 'https://cdn3.f-cdn.com/contestentries/1733723/31242958/5e49683f03d42_thumb900.jpg' :
          'https://cdn3d.iconscout.com/3d/premium/thumb/employee-avatar-10232456-8264146.png';
        ?>
      " class="rounded-circle border border-3 border-white shadow" width="100" height="100">
      <div class="ms-4">
        <h3 class="mb-1">
          <?=
          $_SESSION['admin'] ? $_SESSION['admin']['username'] : $employeeData->name
          ?>
        </h3>
        <p class="mb-0">
          <?=
          $_SESSION['admin'] ? $_SESSION['admin']['role'] : $employeeData->position
          ?>
        </p>
      </div>
    </div>
    <div class="d-flex align-items-center">
      <button class="btn btn-warning text-white me-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
        <i class="bi bi-shield-lock me-1"></i> Đổi mật khẩu
      </button>

      <button class="btn btn-light text-primary me-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
        <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
      </button>

      <form action="Auth/logout.php" method="post" class="mb-0">
        <button type="submit" class="btn btn-danger">
          <i class="bi bi-box-arrow-right me-1"></i> Đăng xuất
        </button>
      </form>
    </div>

  </div>

  <!-- Thống kê dữ liệu ảo -->
  <?php
  $completedOrders = 124;
  $processingOrders = 8;
  $monthlyRevenue = 128500000; // đồng
  $lastLogin = '2025-07-11 08:00:00';
  ?>

  <div class="row text-center mt-4 g-4">
    <!-- Đơn đã xử lý -->
    <div class="col-md-3">
      <div class="card border-0 shadow bg-success-subtle position-relative overflow-hidden">
        <div class="position-absolute top-0 end-0 me-3 mt-3">
          <i class="bi bi-check2-circle fs-1 text-success opacity-25"></i>
        </div>
        <div class="card-body z-1 position-relative">
          <h6 class="text-uppercase fw-bold text-success">Đã xử lý</h6>
          <h3 class="fw-bold"><?= $completedOrders ?></h3>
          <p class="text-muted mb-0">Đơn hàng hoàn tất</p>
        </div>
      </div>
    </div>

    <!-- Đơn đang xử lý -->
    <div class="col-md-3">
      <div class="card border-0 shadow bg-warning-subtle position-relative overflow-hidden">
        <div class="position-absolute top-0 end-0 me-3 mt-3">
          <i class="bi bi-hourglass-split fs-1 text-warning opacity-25"></i>
        </div>
        <div class="card-body z-1 position-relative">
          <h6 class="text-uppercase fw-bold text-warning">Đang xử lý</h6>
          <h3 class="fw-bold"><?= $processingOrders ?></h3>
          <p class="text-muted mb-0">Đơn hàng chưa hoàn tất</p>
        </div>
      </div>
    </div>

    <!-- Doanh thu tháng -->
    <div class="col-md-3">
      <div class="card border-0 shadow bg-info-subtle position-relative overflow-hidden">
        <div class="position-absolute top-0 end-0 me-3 mt-3">
          <i class="bi bi-bar-chart-line fs-1 text-info opacity-25"></i>
        </div>
        <div class="card-body z-1 position-relative">
          <h6 class="text-uppercase fw-bold text-info">Doanh thu tháng</h6>
          <h4 class="fw-bold"><?= number_format($monthlyRevenue, 0, ',', '.') ?>₫</h4>
          <p class="text-muted mb-0"><?= date('m/Y') ?></p>
        </div>
      </div>
    </div>

    <!-- Lần đăng nhập gần nhất -->
    <div class="col-md-3">
      <div class="card border-0 shadow bg-danger-subtle position-relative overflow-hidden">
        <div class="position-absolute top-0 end-0 me-3 mt-3">
          <i class="bi bi-clock-history fs-1 text-danger opacity-25"></i>
        </div>
        <div class="card-body z-1 position-relative">
          <h6 class="text-uppercase fw-bold text-danger">Lần đăng nhập</h6>
          <h5 class="fw-bold"><?= date('d/m/Y - H:i', strtotime($lastLogin)) ?></h5>
          <p class="text-muted mb-0">Thời gian gần nhất</p>
        </div>
      </div>
    </div>
  </div>


  <!-- Thông tin người dùng -->
  <div class="card mt-5 shadow">
    <div class="card-header bg-light">
      <h5 class="mb-0">Thông tin cá nhân</h5>
    </div>
    <div class="card-body">
      <table class="table table-borderless mb-0">
        <tr>
          <th>Email:</th>
          <td>
            <?=
            $_SESSION['admin'] ? $_SESSION['admin']['email'] : $employeeData->email
            ?>
          </td>
        </tr>
        <tr>
          <th>Số điện thoại:</th>
          <td>
            <?=
            $employeeData ? $employeeData->phone : 'Không có';
            ?>
          </td>
        </tr>
        <tr>
          <th>Địa chỉ:</th>
          <td>
            <?=
            $employeeData ? $employeeData->address : 'Không có';
            ?>
          </td>
        </tr>
        <tr>
          <th>Chức năng:</th>
          <td>
            <?php
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
              echo "Toàn quyền";
            } else {
              $roleIds = $employeeController->getRoleIds($employeeData->id);
              foreach ($roleIds as $roleId) {
                $role = $roleController->getById($roleId);
                echo $role['role_name'] . ', ';
              }
            }
            ?>
          </td>
        </tr>
        <tr>
          <th>Ngày tạo:</th>
          <td> <?=
                $_SESSION['admin'] ? $_SESSION['admin']['created_at'] : $employeeData->create_at
                ?></td>
        </tr>
      </table>
    </div>
  </div>


  <?php
  require_once 'modules/Admin/Profile/UpdateProfile.php';
  require_once 'modules/Admin/Profile/ChangePassword.php';
  ?>