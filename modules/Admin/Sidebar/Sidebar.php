<?php
$currentPage = $_GET['page'] ?? '';
?>

<div class="sidebar custom-sidebar" style="top: 0; margin-top: 0; padding-top: 0;">
  <div class="logo">
    <img src="Style/Images/123.png" alt="Logo" style="max-width: 200px; height: auto; object-fit: contain; border-radius: 20px;">
  </div>

  <ul class="nav flex-column p-3">
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === '' || $currentPage === 'dashboard') ? 'active' : '' ?>" href="Admin.php">
        <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Products/Product.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Products/Product.php">
        <i class="fas fa-box"></i><span>Quản lý Sản Phẩm</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Categories/Category.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Categories/Category.php">
        <i class="fas fa-table"></i><span>Quản lý Loại Sản Phẩm</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Suppliers/Supplier.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Suppliers/Supplier.php">
        <i class="fas fa-boxes-packing"></i><span>Quản lý Đối Tác Cung Cấp</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Inventory/Inventory.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Inventory/Inventory.php">
        <i class="fas fa-warehouse"></i><span>Quản lý Kho Hàng</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Customers/Customer.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Customers/Customer.php">
        <i class="fas fa-users"></i><span>Quản lý Khách hàng</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Orders/Order.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Orders/Order.php">
        <i class="fas fa-shopping-cart"></i><span>Quản lý Đơn hàng</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Menus/Menu.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Menus/Menu.php">
        <i class="fas fa-screwdriver-wrench"></i><span>Quản lý chức năng</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Roles/Role.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Roles/Role.php">
        <i class="fas fa-sitemap"></i><span>Quản lý quyền</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Employees/Employee.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Employees/Employee.php">
        <i class="fas fa-clipboard-user"></i><span>Quản lý nhân viên</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/Shipping/Shipping.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/Shipping/Shipping.php">
        <i class="fas fa-truck"></i><span>Quản lý giao hàng</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link d-flex justify-content-between align-items-center <?= (strpos($currentPage, 'modules/Admin/RecycleBin') !== false) ? 'active' : '' ?>" data-bs-toggle="collapse" href="#recycleCollapse" role="button" aria-expanded="<?= (strpos($currentPage, 'modules/Admin/RecycleBin') !== false) ? 'true' : 'false' ?>" aria-controls="recycleCollapse">
        <div class="d-flex align-items-center gap-2">
          <i class="fas fa-trash"></i><span>Recycle Bin</span>
        </div>
        <i class="fas fa-chevron-right arrow-icon <?= (strpos($currentPage, 'modules/Admin/RecycleBin') !== false) ? 'rotate' : '' ?>"></i>
      </a>

      <div class="collapse <?= (strpos($currentPage, 'modules/Admin/RecycleBin') !== false) ? 'show' : '' ?>" id="recycleCollapse">
        <ul class="nav flex-column ms-4">
          <li>
            <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/RecycleBin/Product/Product.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/RecycleBin/Product/Product.php">
              <i class="fas fa-box-open"></i><span>Product</span>
            </a>
          </li>
          <li>
            <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/RecycleBin/Category/Category.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/RecycleBin/Category/Category.php">
              <i class="fas fa-table"></i><span>Category</span>
            </a>
          </li>
          <li>
            <a class="nav-link d-flex align-items-center gap-2 <?= ($currentPage === 'modules/Admin/RecycleBin/Supplier/Supplier.php') ? 'active' : '' ?>" href="Admin.php?page=modules/Admin/RecycleBin/Supplier/Supplier.php">
              <i class="fas fa-truck"></i><span>Supplier</span>
            </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item"><a class="nav-link d-flex align-items-center gap-2" href="#"><i class="fas fa-language"></i><span>Language</span></a></li>
    <li class="nav-item"><a class="nav-link d-flex align-items-center gap-2" href="#"><i class="fas fa-sign-in-alt"></i><span>Login</span></a></li>
    <li class="nav-item"><a class="nav-link d-flex align-items-center gap-2" href="#"><i class="fas fa-cogs"></i><span>Settings</span></a></li>
  </ul>
</div>

<style>
.sidebar .nav-link {
  display: flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: 14px;
}

.sidebar .nav-link span {
  flex-shrink: 1;
}

.sidebar .nav-link i {
  min-width: 20px;
  text-align: center;
}

.arrow-icon {
  transition: transform 0.3s ease;
}

.arrow-icon.rotate {
  transform: rotate(90deg);
}
.sidebar {
  overflow-y: auto;
  scrollbar-width: none;        /* Firefox */
  -ms-overflow-style: none;     /* IE & Edge */
}

.sidebar::-webkit-scrollbar {
  display: none;                /* Chrome, Safari */
}

</style>