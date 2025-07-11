<?php
$currentPage = $_GET['page'] ?? '';
?>

<div class="sidebar custom-sidebar" style="top: 0; margin-top: 0; padding-top: 0;">
    <div class="logo" style="margin-top: 0;">
        <img src="Style/Images/123.png" alt="Logo"
            style="max-width: 200px; height: auto; object-fit: contain; border-radius: 20px;">
    </div>

    <ul class="nav flex-column p-3">
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage === '' || $currentPage === 'dashboard') ? 'active' : '' ?>" href="Admin.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($currentPage === 'modules/Admin/Products/Product.php') ? 'active' : '' ?>"
               href="Admin.php?page=modules/Admin/Products/Product.php">
                <i class="fas fa-box"></i> Sản Phẩm
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($currentPage === 'modules/Admin/Categories/Category.php') ? 'active' : '' ?>"
               href="Admin.php?page=modules/Admin/Categories/Category.php">
                <i class="fas fa-table"></i> Loại Sản Phẩm
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($currentPage === 'modules/Admin/Suppliers/Supplier.php') ? 'active' : '' ?>"
               href="Admin.php?page=modules/Admin/Suppliers/Supplier.php">
                <i class="fas fa-truck"></i> Đối Tác Cung Cấp
            </a>
        </li>

        <li class="nav-item">
    <a class="nav-link <?= ($currentPage === 'modules/Admin/Inventory/Inventory.php') ? 'active' : '' ?>"
        href="Admin.php?page=modules/Admin/Inventory/Inventory.php">
        <i class="fas fa-warehouse"></i> Kho Hàng
    </a>
</li>


        <li class="nav-item">
    <a class="nav-link <?= ($currentPage === 'modules/Admin/Customers/Customer.php') ? 'active' : '' ?>"
       href="Admin.php?page=modules/Admin/Customers/Customer.php">
        <i class="fas fa-users"></i> Khách hàng
    </a>
</li>

         <li class="nav-item">
    <a class="nav-link <?= ($currentPage === 'modules/Admin/Orders/Order.php') ? 'active' : '' ?>"
       href="Admin.php?page=modules/Admin/Orders/Order.php">
        <i class="fas fa-shopping-cart"></i> Đơn hàng
    </a>
</li>
  <!--       <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-file-invoice"></i> Invoice</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-history"></i> History</a>
        </li> -->
          <!-- Recycle Bin -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center <?= (strpos($currentPage, 'modules/Admin/RecycleBin') !== false) ? 'active' : '' ?>"
               data-bs-toggle="collapse"
               href="#recycleCollapse"
               role="button"
               aria-expanded="<?= (strpos($currentPage, 'modules/Admin/RecycleBin') !== false) ? 'true' : 'false' ?>"
               aria-controls="recycleCollapse">
                <i class="fas fa-trash me-3"></i> Recycle Bin
                <i class="fas fa-chevron-right ms-auto arrow-icon <?= (strpos($currentPage, 'modules/Admin/RecycleBin') !== false) ? 'rotate' : '' ?>"></i>
            </a>

            <div class="collapse <?= (strpos($currentPage, 'modules/Admin/RecycleBin') !== false) ? 'show' : '' ?>" id="recycleCollapse">
                <ul class="nav flex-column ms-4">
                    <li>
                        <a class="nav-link <?= ($currentPage === 'modules/Admin/RecycleBin/Product/Product.php') ? 'active' : '' ?>"
                           href="Admin.php?page=modules/Admin/RecycleBin/Product/Product.php">
                            <i class="fas fa-box-open me-1"></i> Product
                        </a>
                    </li>
                    <li>
                        <a class="nav-link <?= ($currentPage === 'modules/Admin/RecycleBin/Category/Category.php') ? 'active' : '' ?>"
                           href="Admin.php?page=modules/Admin/RecycleBin/Category/Category.php">
                            <i class="fas fa-table me-1"></i> Category
                        </a>
                    </li>
                    <li>
                        <a class="nav-link <?= ($currentPage === 'modules/Admin/RecycleBin/Supplier/Supplier.php') ? 'active' : '' ?>"
                           href="Admin.php?page=modules/Admin/RecycleBin/Supplier/Supplier.php">
                            <i class="fas fa-truck me-1"></i> Supplier
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-language"></i> Language</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-sign-in-alt"></i> Login</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-cogs"></i> Settings</a></li>
    </ul>
</div>