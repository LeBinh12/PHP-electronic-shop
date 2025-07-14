<?php
$keyword = $_GET['search'] ?? '';

$customers = [
    ['id' => 1, 'full_name' => 'Nguyễn Văn A', 'email' => 'a.nguyen@gmail.com', 'phone' => '0909123456'],
    ['id' => 2, 'full_name' => 'Trần Thị B', 'email' => 'b.tran@gmail.com', 'phone' => '0912345678'],
    ['id' => 3, 'full_name' => 'Lê Văn C', 'email' => 'c.le@gmail.com', 'phone' => '0932123456'],
    ['id' => 4, 'full_name' => 'Phạm Thị D', 'email' => 'd.pham@gmail.com', 'phone' => '0978123456'],
    ['id' => 5, 'full_name' => 'Đỗ Văn E', 'email' => 'e.do@gmail.com', 'phone' => '0923456789'],
    ['id' => 6, 'full_name' => 'Lý Thị F', 'email' => 'f.ly@gmail.com', 'phone' => '0944123456'],
    ['id' => 7, 'full_name' => 'Hoàng Văn G', 'email' => 'g.hoang@gmail.com', 'phone' => '0987654321'],
];

if ($keyword !== '') {
    $customers = array_filter($customers, fn($cus) =>
        stripos($cus['full_name'], $keyword) !== false ||
        stripos($cus['email'], $keyword) !== false |
        stripos($cus['phone'], $keyword) !== false
    );
}

$limit = 5;
$totalPages = max(1, ceil(count($customers) / $limit));

$page = isset($_GET['number']) ? (int) $_GET['number'] : 1;
$page = max(1, min($page, $totalPages));

$offset = ($page - 1) * $limit;
$customers = array_slice($customers, $offset, $limit);
?>

<h1 class="h3">Danh sách khách hàng</h1>

<!-- Form tìm kiếm -->
<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Customers/Customer.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm khách hàng...">
        </form>
    </div>

<?php require_once 'modules/Admin/Customers/UpdateCustomer.php'; ?>
<?php require_once 'modules/Admin/Customers/DeleteCustomer.php'; ?>

   <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
            <thead class="table-dark">
                <tr>
                    <th style="width: 20px; text-align: center">ID</th>
                    <th style="width: 100px">Họ tên</th>
                    <th style="width: 50px">Điện thoại</th>
                    <th style="width: 150px">Email</th>
                    <th class="text-center" style="width: 130px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $cus): ?>
                    <tr>
                        <td class="text-center"><?= $cus['id'] ?></td>
                        <td><?= htmlspecialchars($cus['full_name']) ?></td>
                        <td><?= htmlspecialchars($cus['phone']) ?></td>
                        <td><?= htmlspecialchars($cus['email']) ?></td>

  <td class="text-center">
  <div class="d-flex flex-wrap gap-1 justify-content-center">

    <!-- Chi tiết -->
<button class="btn btn-sm btn-info text-white d-inline-flex align-items-center gap-1 px-2 py-1 btn-detail-customer"
  data-id="<?= $cus['id'] ?>"
  data-fullname="<?= htmlspecialchars($cus['full_name']) ?>"
  data-phone="<?= htmlspecialchars($cus['phone']) ?>"
  data-email="<?= htmlspecialchars($cus['email']) ?>"
  data-bs-toggle="modal"
  data-bs-target="#detailCustomerModal">
  <i class="fas fa-info-circle"></i> Chi tiết
</button>

<!-- Báo cáo -->
<button class="btn btn-sm btn-warning text-dark d-inline-flex align-items-center gap-1 px-2 py-1"
  onclick="alert('Chức năng báo cáo sẽ được cập nhật sau!')">
  <i class="fas fa-chart-bar"></i> Báo cáo
</button>

<!-- Sửa -->
<button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1"
  data-id="<?= $cus['id'] ?>"
  data-fullname="<?= htmlspecialchars($cus['full_name']) ?>"
  data-phone="<?= htmlspecialchars($cus['phone']) ?>"
  data-email="<?= htmlspecialchars($cus['email']) ?>"
  data-bs-toggle="modal"
  data-bs-target="#editCustomerModal">
  <i class="fas fa-edit"></i> Sửa
</button>


    <!-- Nút Xóa -->
<button class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete-customer"
    data-id="<?= $cus['id'] ?>"
    data-name="<?= htmlspecialchars($cus['full_name']) ?>"
    data-bs-toggle="modal"
    data-bs-target="#deleteCustomerModal">
    <i class="fas fa-trash-alt"></i> Xóa
</button>

  </div>
</td>



                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Phân trang -->
<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link"
                   href="Admin.php?page=modules/Admin/Customers/Customer.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor ?>
    </ul>
</nav>
