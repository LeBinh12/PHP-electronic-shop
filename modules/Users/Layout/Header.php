<?php
$categoryGetAll = $category->getAll();
$supplierGetAll = $supplier->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $res = $userController->register([
        'FullName' => $_POST['fullname'],
        'Email' => $_POST['email'],
        'Phone' => $_POST['phone'],
        'Address' => $_POST['address'],
        'password' => $_POST['password'],
        'isDeleted' => 0
    ]);
    if ($res['success']) {
        // echo "Đăng ký thành công!";
        swal_alert('success', 'Đăng ký thành công!');
    } else {
        foreach ($res['message'] as $field => $rules) {
            foreach ($rules as $rule => $msg) {
                // echo "$msg<br>";
                swal_alert('error', $msg);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $res = $userController->login($_POST['email'], $_POST['password']);
    if ($res['success']) {
        $_SESSION['jwt'] = $res['token'];
        $userData = $userController->getCurrentUser();
        echo "{$_SESSION['jwt']}";
    } else {
        // echo "<script>
        //         alert('Tài khoản của bạn đã bị khóa đến {$res['report']['banned_until']}!');
        //         window.location.href = 'index.php';
        //     </script>";
        swal_alert(
            'error',
            'Tài khoản bị khóa',
            'Tài khoản của bạn đã bị khóa đến ' . $res['report']['banned_until'] . '!',
            'index.php'
        );
        exit;
    }
}


if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['update_account'])) {
    $fullName = $_POST['FullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $data = [
        'FullName' => $fullName,
        'Email' => $email,
        'Phone' => $phone,
        'Address' => $address
    ];

    $res = $userController->updateProfile($userData->id, $data, true);

    if ($res['success']) {
        $_SESSION['jwt'] = $res['token'];
        $userData = $userController->getCurrentUser();
        // echo "<script>
        //     alert('Cập nhật tài khoản thành công!');
        //     window.location.href = 'index.php';
        // </script>";
        swal_alert('success', 'Cập nhật tài khoản thành công!', '', 'index.php');
    }
}
?>

<div id="multiBannerCarousel" class="carousel slide mb-2 mt-1" data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="row g-0">
                <div class="col-6">
                    <img src="https://file.hstatic.net/200000722513/file/bot_promotion_banner_small_2_2ad55c2345c64fbfb87dab4957b33914.png"
                        class="img-fluid w-100" alt="Banner 1" style="height: 200px; object-fit: contain;">
                </div>
                <div class="col-6">
                    <img src="https://file.hstatic.net/200000722513/file/banner_790x250_tai_nghe_6f6dcb17d3a54fcc88b3de96762d2d41.jpg"
                        class="img-fluid w-100" alt="Banner 2" style="height: 200px; object-fit: contain;">
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="row g-0">
                <div class="col-6">
                    <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_build_pc_top_promotion_banner_2.png"
                        class="img-fluid w-100" alt="Banner 3" style="height: 200px; object-fit: contain;">
                </div>
                <div class="col-6">
                    <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_ghe_top_promotion_banner_1.png"
                        class="img-fluid w-100" alt="Banner 4" style="height: 200px; object-fit: contain;">
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="row g-0">
                <div class="col-12">
                    <img src="https://theme.hstatic.net/200000722513/1001090675/14/headblog_banner.jpg?v=9171"
                        class="img-fluid w-100"
                        alt="Banner 3"
                        style="height: 200px; object-fit: cover; border-radius: 0.25rem;">
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#multiBannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#multiBannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-danger shadow-sm sticky-top" style="z-index: 1031;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-white" href="index.php">GARENA</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <div class="d-flex align-items-center w-100 justify-content-between" style="gap: 1rem;">
                <div class="d-flex align-items-center flex-grow-1" style="gap: 1rem;">
                    <!-- Dropdown Danh mục -->
                    <div class="dropdown">
                        <a class="nav-link fw-bold dropdown-toggle text-white" href="#" id="categoryDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list"></i> Danh mục
                        </a>

                        <ul class="dropdown-menu dropdown-menu-grid p-2 shadow" aria-labelledby="categoryDropdown">
                            <li>
                                <a class="dropdown-item"
                                    href="index.php?subpage=modules/Users/Layout/Main.php&<?= isset($_GET['supplier']) ? 'supplier=' . $_GET['supplier'] : '' ?>">
                                    Tất cả
                                </a>
                            </li>
                            <?php foreach ($categoryGetAll as $item) { ?>
                                <li>
                                    <a class="dropdown-item"
                                        href="index.php?subpage=modules/Users/Layout/Main.php&category=<?= $item['id'] ?><?= isset($_GET['supplier']) ? '&supplier=' . $_GET['supplier'] : '' ?>">
                                        <?= $item['name'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <!-- Dropdown Thương hiệu -->
                    <div class="dropdown">
                        <a class="nav-link fw-bold dropdown-toggle text-white" href="#" id="supplierDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-box-seam"></i> Thương hiệu
                        </a>
                        <ul class="dropdown-menu dropdown-menu-grid p-2 shadow" aria-labelledby="supplierDropdown">
                            <li>
                                <a class="dropdown-item"
                                    href="index.php?subpage=modules/Users/Layout/Main.php&<?= isset($_GET['category']) ? 'category=' . $_GET['category'] : '' ?>&<?= isset($_GET['search']) ? 'search=' . $_GET['search'] : '' ?>">
                                    Tất cả
                                </a>
                            </li>
                            <?php foreach ($supplierGetAll as $item) { ?>
                                <li>
                                    <a class="dropdown-item"
                                        href="index.php?subpage=modules/Users/Layout/Main.php&supplier=<?= $item['id'] ?>&<?= isset($_GET['category']) ? 'category=' . $_GET['category'] : '' ?>&<?= isset($_GET['search']) ? 'search=' . $_GET['search'] : '' ?>">
                                        <?= $item['name'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <form action="index.php" method="get" class="search-form d-flex align-items-center">
                        <input type="hidden" name="subpage" value="modules/Users/Layout/Main.php">

                        <input type="hidden" name="category" value="<?= $_GET['category'] ?? '' ?>">
                        <input type="hidden" name="supplier" value="<?= $_GET['supplier'] ?? '' ?>">
                        <input type="search" name="search" class="form-control custom-search-input"
                            placeholder="Bạn cần tìm gì?" value="<?= $_GET['search'] ?? '' ?>">
                        <button class=" btn custom-search-btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <ul class="navbar-nav" style="gap: 0.75rem;">
                    <li class="nav-item">
                        <?php if ($userData === null) { ?>
                            <a data-bs-toggle="modal"
                                data-bs-target="#loginModal" href="#" class="nav-link text-white">
                                <i class="bi bi-receipt-cutoff me-1"></i> Tra cứu đơn hàng
                            </a>
                        <?php
                        } else {
                        ?>
                            <a href="index.php?subpage=modules/Users/page/CheckOrder.php" class="nav-link text-white">
                                <i class="bi bi-receipt-cutoff me-1"></i> Tra cứu đơn hàng
                            </a>
                        <?php
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?subpage=modules/Users/page/Cart.php" class="nav-link text-white">
                            <i class="bi bi-cart-fill me-1"></i> Giỏ hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <?php if ($userData === null) { ?>
                            <a href="#" class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="bi bi-person-circle me-1"></i> Đăng nhập
                            </a>
                        <?php } else { ?>
                            <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($userData->name) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#accountModal">Tài khoản của tôi</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="logout.php">Đăng xuất</a></li>
                            </ul>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
</nav>

<!-- Modal Đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content rounded-4 shadow">
            <form action="" method="post">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-primary fw-bold w-100 text-center">Đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0 text-center">
                    <p class="text-muted mb-4">Vui lòng nhập thông tin để tiếp tục</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                        <span class="input-group-text bg-white"><i class="bi bi-eye"></i></span>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="#" class="small text-decoration-none" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Quên mật khẩu?</a>
                    </div>
                    <button class="btn btn-primary w-100 mb-3" type="submit" name="login">Đăng nhập</button>
                    <p class="mb-0">Bạn chưa có tài khoản?
                        <a href="#" class="text-primary text-decoration-none" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký</a>
                    </p>
            </form>
        </div>
    </div>
</div>
</div>



<!-- Modal Tài khoản -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal modal-dialog-centered">
        <form method="post" id="accountForm" class="w-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="mb-3">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control user-field"
                                name="FullName"
                                value="<?= htmlspecialchars($userData->name) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control user-field"
                                name="email"
                                value="<?= htmlspecialchars($userData->email) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control user-field"
                                name="phone"
                                value="<?= htmlspecialchars($userData->phone) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control user-field"
                                name="address"
                                value="<?= htmlspecialchars($userData->address) ?>" disabled>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" id="editBtn" class="btn btn-warning">Chỉnh sửa thông tin tài khoản</button>
                    <button type="submit" id="saveBtn" name="update_account" class="btn btn-success d-none">Lưu thay đổi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content rounded-4 shadow">
            <form action="" method="post">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-success fw-bold w-100 text-center">Đăng ký</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0 text-center">
                    <p class="text-muted mb-4">Tạo tài khoản mới để mua sắm</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                        <input type="text" name="fullname" class="form-control" placeholder="Họ và tên">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="number" name="phone" class="form-control" placeholder="Số điện thoại">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="text" name="address" class="form-control" placeholder="Địa chỉ">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="text" name="password" class="form-control" placeholder="Mật khẩu">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="text" name="passwordChange" class="form-control" placeholder="Nhập lại mật khẩu">
                    </div>
                    <button class="btn btn-success w-100 mb-3" type="submit" name="register">Đăng ký</button>
                    <p class="mb-0">Đã có tài khoản?
                        <a href="#" class="text-success text-decoration-none" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Quên mật khẩu -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-danger fw-bold w-100 text-center">Quên mật khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 text-center">
                <p class="text-muted mb-4">Nhập email để nhận mã xác nhận</p>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="forgotEmail" class="form-control" placeholder="Email">
                </div>
                <button class="btn btn-danger w-100" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#verifyOtpModal">Gửi mã xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác nhận mã và đổi mật khẩu -->
<div class="modal fade" id="verifyOtpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-success fw-bold w-100 text-center">Xác nhận đổi mật khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 text-center">
                <p class="text-muted mb-4">Nhập mã xác nhận và mật khẩu mới</p>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white"><i class="bi bi-shield-lock"></i></span>
                    <input type="text" id="otpCode" class="form-control" placeholder="Mã xác nhận">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                    <input type="password" id="newPassword" class="form-control" placeholder="Mật khẩu mới">
                </div>
                <button class="btn btn-success w-100" id="confirmResetBtn">Xác nhận đổi mật khẩu</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editBtn = document.getElementById("editBtn");
        const saveBtn = document.getElementById("saveBtn");
        const fields = document.querySelectorAll(".user-field");

        editBtn.addEventListener("click", function() {
            fields.forEach(field => field.disabled = false);
            saveBtn.classList.remove("d-none");
            editBtn.classList.add("d-none");
        });
    });
</script>