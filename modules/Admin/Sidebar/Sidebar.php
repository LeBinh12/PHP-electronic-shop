<?php
$currentPage = $_GET['page'] ?? '';
$is_stats_active = in_array($currentPage, [
  'modules/Admin/RecycleBin/Product/Product.php',
  'modules/Admin/RecycleBin/Category/Category.php',
  'modules/Admin/RecycleBin/Supplier/Supplier.php'
]);
?>

<div class="sidebar">
  <div class="sidebar-header">
    <a href="Admin.php" style="text-decoration: none;">
      <h2 class="gradient-text">GARENA</h2>
    </a>
  </div>
  <ul>
    <li class="<?= ($currentPage === '' || $currentPage == 'dashboard') ? 'active' : '' ?>">
      <a href="Admin.php"><i class="fas fa-home"></i> Dashboard</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Products/Product.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Products/Product.php"><i class="fas fa-box"></i> Sản Phẩm</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Branches/Branch.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Branches/Branch.php"><i class="fas fa-building"></i> Quản lý chi nhánh</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Categories/Category.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Categories/Category.php"><i class="fas fa-tags"></i> Loại sản phẩm</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Suppliers/Supplier.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Suppliers/Supplier.php"><i class="fas fa-truck"></i> Nhà cung cấp</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Inventory/Inventory.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Inventory/Inventory.php"><i class="fas fa-warehouse"></i> Kho hàng</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Customers/Customer.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Customers/Customer.php"><i class="fas fa-users"></i> Khách hàng</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Orders/Order.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Orders/Order.php"><i class="fas fa-shopping-cart"></i> Đơn hàng</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Menus/Menu.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Menus/Menu.php"><i class="fas fa-screwdriver-wrench"></i> Quản lý chức năng</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Roles/Role.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Roles/Role.php"><i class="fas fa-sitemap"></i> Quản lý quyền</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Employees/Employee.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Employees/Employee.php"><i class="fas fa-clipboard-user"></i> Quản lý nhân viên</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Shipping/Shipping.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Shipping/Shipping.php"><i class="fas fa-truck"></i> Quản lý giao hàng</a>
    </li>
    <li class="dropdown">
      <div id="dropdown-toggle" class="dropdown-toggle">
        <span class="toggle-label">
          <i class="fas fa-trash-alt" style="margin-right: 8px; width: 20px;"></i> Thùng rác
        </span>
        <span class="arrow <?= $is_stats_active ? 'open' : '' ?>">&#9656;</span>
      </div>

      <ul id="dropdown-menu" class="dropdown-menu <?= $is_stats_active ? 'show' : '' ?>">
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Product/Product.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Product/Product.php">
            <i class="fas fa-dollar-sign"></i> Sản phẩm
          </a>
        </li>
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Category/Category.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Category/Category.php">
            <i class="fas fa-receipt"></i> Loại sản phẩm
          </a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<script>
  const toggle = document.getElementById('dropdown-toggle');
  const menu = document.getElementById('dropdown-menu');
  const arrow = toggle.querySelector('.arrow');

  if (toggle && menu && arrow) {
    toggle.addEventListener('click', () => {
      menu.classList.toggle('show');
      arrow.classList.toggle('open');
    });
  }
</script>