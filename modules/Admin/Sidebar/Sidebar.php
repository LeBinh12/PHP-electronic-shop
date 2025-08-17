<?php
$currentPage = $_GET['page'] ?? '';
$is_stats_active = in_array($currentPage, [
  'modules/Admin/RecycleBin/Products/Product.php',
  'modules/Admin/RecycleBin/Category/Category.php',
  'modules/Admin/RecycleBin/Suppliers/Supplier.php',
  'modules/Admin/RecycleBin/Branches/Branch.php',
  'modules/Admin/RecycleBin/Categories/Category.php',
  'modules/Admin/RecycleBin/Customers/Customer.php',
  'modules/Admin/RecycleBin/Orders/Order.php',
  'modules/Admin/RecycleBin/Menus/Menu.php',
  'modules/Admin/RecycleBin/Roles/Role.php',
  'modules/Admin/RecycleBin/Employees/Employee.php'

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
      <a href="Admin.php"><i class="fas fa-tachometer-alt"></i> Thống kê </a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Products/Product.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Products/Product.php"><i class="fas fa-box"></i> Quản lý sản phẩm</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Branches/Branch.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Branches/Branch.php"><i class="fas fa-store"></i> Quản lý chi nhánh</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Categories/Category.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Categories/Category.php"><i class="fas fa-table"></i> Quản lý loại sản phẩm</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Suppliers/Supplier.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Suppliers/Supplier.php"><i class="fas fa-boxes-packing"></i> Quản lý nhà cung cấp</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Inventory/Inventory.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Inventory/Inventory.php"><i class="fas fa-warehouse"></i> Quản lý kho hàng</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Customers/Customer.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Customers/Customer.php"><i class="fas fa-users"></i> Quản lý khách hàng</a>
    </li>
    <li class="<?= ($currentPage == 'modules/Admin/Orders/Order.php') ? 'active' : '' ?>">
      <a href="Admin.php?page=modules/Admin/Orders/Order.php"><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</a>
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

      <?php
      if (hasPermission('modules/Admin/RecycleBin')) {
      ?>
        <div id="dropdown-toggle" class="dropdown-toggle">
          <span class="toggle-label">
            <i class="fas fa-trash-alt" style="margin-right: 8px; width: 20px;"></i> Thùng rác
          </span>
          <span class="arrow <?= $is_stats_active ? 'open' : '' ?>">&#9656;</span>
        </div>

      <?php
      }
      ?>

      <ul id="dropdown-menu" class="dropdown-menu <?= $is_stats_active ? 'show' : '' ?>">
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Products/Product.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Products/Product.php">
            <i class="fas fa-box"></i> Sản phẩm
          </a>
        </li>
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Branches/Branch.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Branches/Branch.php">
            <i class="fas fa-store "></i> Chi nhánh
          </a>
        </li>
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Categories/Category.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Categories/Category.php">
            <i class="fas fa-table"></i> Loại sản phẩm
          </a>
        </li>
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Suppliers/Supplier.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Suppliers/Supplier.php">
            <i class="fas fa-boxes-packing "></i> Nhà cung cấp
          </a>
        </li>
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Customers/Customer.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Customers/Customer.php">
            <i class="fas fa-users"></i> Khách hàng
          </a>
        </li>
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Orders/Order.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Orders/Order.php">
            <i class="fas fa-shopping-cart"></i> Đơn hàng
          </a>
        </li>
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Menus/Menu.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Menus/Menu.php">
            <i class="fas fa-screwdriver-wrench"></i> Chức năng
          </a>
        </li>
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Roles/Role.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Roles/Role.php">
            <i class="fas fa-sitemap"></i> Quyền
          </a>
        </li>
        <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Employees/Employee.php') ? 'active-sub' : '' ?>">
          <a href="Admin.php?page=modules/Admin/RecycleBin/Employees/Employee.php">
            <i class="fas fa-clipboard-user"></i> Nhân viên
          </a>
        </li>
      </ul>
    </li>
  </ul>

  <ul class="mb-4">
    <li>
      <a class="text-danger d-flex align-items-center gap-2" href="Auth/logout.php">
        <i class="fas fa-sign-out-alt"></i> Đăng xuất
      </a>
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

<style>
  .sidebar {
    width: 250px;
    background-color: #f4f6f8;
    position: fixed;
    top: 0;
    bottom: 0;
    overflow-y: auto;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);
    scrollbar-width: none;
  }

  .sidebar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
  }

  .sidebar ul li {
    padding: 10px 20px;
  }

  .gradient-text {
    padding: 10px;
    text-align: center;
    font-weight: bold;
    background: linear-gradient(90deg, #ff4e50, #ef4cf5, #1e90ff, #7b2ff7);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
  }

  .gradient-text:hover {
    opacity: 0.8;
    transition: all 0.2s ease;
  }

  .sidebar a i {
    margin-right: 8px;
    width: 20px;
  }


  .sidebar ul li a,
  .sidebar .dropdown-toggle {
    text-decoration: none;
    color: #333;
    display: block;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
  }

  .sidebar ul li:hover,
  .sidebar .dropdown-toggle:hover {
    background-color: #e2e6ea;
  }

  .sidebar ul li.active,
  .sidebar ul li.active-sub,
  .sidebar .dropdown-toggle.active {
    background-color: #007bff;
    color: white;
  }

  .sidebar ul li.active a,
  .sidebar ul li.active-sub a,
  .sidebar .dropdown-toggle.active {
    color: white;
  }

  .sidebar .dropdown {
    position: relative;
  }

  .sidebar .dropdown-menu {
    display: none;
    list-style-type: none;
    padding-left: 30px;
    margin: 0;
    border-left: 2px solid #007bff;
    background-color: transparent;
    position: static;
    border-top: none;
    border-right: none;
    border-bottom: none;
    background-color: transparent;
    box-shadow: none;
    border-radius: 0;
  }


  .sidebar .dropdown-menu.show {
    display: block;
  }

  .sidebar .dropdown-menu li {
    padding: 8px 15px;
    margin: 2px 0;
  }

  .sidebar .dropdown-menu li:hover {
    background-color: #ced4da;
  }

  .dropdown-toggle {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .arrow {
    margin-left: 85px;
    display: inline-block;
    transition: transform 0.3s ease;
    font-size: 20px;
    color: inherit;
  }

  .arrow.open {
    transform: rotate(90deg);
  }

  .content {
    margin-left: 250px;
    padding: 80px 20px 20px 20px;
  }

  #dropdown-toggle::after {
    content: none !important;
    display: none !important;
  }
</style>