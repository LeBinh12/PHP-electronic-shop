<?php
// $listSupplier = $supplier->getAll();


$keyword = $_GET['search'] ?? '';



$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;



$totalSuppliers = $supplier->countSuppliers();
$totalPages = ceil($totalSuppliers / $limit);
$listSuppliers = $supplier->getFilterSuppliers($limit, $offset, $keyword);



?>
<?php require_once 'modules/Admin/Suppliers/AddSupplier.php'; ?>
<?php require_once 'modules/Admin/Suppliers/UpdateSupplier.php'; ?>
<?php require_once 'modules/Admin/Suppliers/DeleteSupplier.php'; ?>
<div class="text-center mb-2">
    <h1 class="h3">Danh sách nhà cung cấp</h1>
</div>
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
        <i class="fas fa-plus-circle me-1"></i> Thêm nhà cung cấp
    </button>
</div>
 <!-- Tìm kiếm -->
    <form class="d-flex position-relative" method="GET" action="Admin.php" style="max-width: 350px; width: 100%;">
        <input type="hidden" name="page" value="modules/Admin/Suppliers/Supplier.php">
        <button class="btn position-absolute top-50 start-0 translate-middle-y ms-2" type="submit" style="z-index: 10; border: none; background: transparent;">
            <i class="bi bi-search text-muted"></i>
        </button>
        <input type="search"
            name="search"
            value="<?= htmlspecialchars($keyword) ?>"
            class="form-control ps-5 rounded-pill"
            placeholder="Tìm nhà cung cấp...">
    </form>



<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-lg custom-table mx-auto" style="width: auto;">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Người liên hệ</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $imageFail = 'https://res.cloudinary.com/diizgvtq9/image/upload/v1751033642/suppliers/xgzffwxlcyraw9ncvdch.jpg';
                foreach ($listSuppliers as $item): ?>
                    <tr>
                        <td><?= $item["id"] ?></td>
                        <td><?= htmlspecialchars($item["name"]) ?></td>
                        <td><?= htmlspecialchars($item["contact_person"] ?? '') ?></td>
                        <td><?= htmlspecialchars($item["Phone"] ?? '') ?></td>
                        <td><?= htmlspecialchars($item["Email"] ?? '') ?></td>
                        <td>
                            <img src="<?= htmlspecialchars($item['image_url'] ?? $imageFail) ?>" alt="Ảnh sản phẩm" width="80" height="80" style="object-fit:cover;">
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary" onclick="openEditSupplierModal(
                                <?= $item['id'] ?>,
                               '<?= addslashes($item['name']) ?>',
                               '<?= addslashes($item['contact_person'] ?? '') ?>',
                               '<?= addslashes($item['Phone'] ?? '') ?>',
                               '<?= addslashes($item['Email'] ?? '') ?>',
                               '<?= addslashes(string: $item['Address'] ?? '') ?>',
                               '<?= addslashes(string: $item['image_url'] ?? '') ?>')">

                                    <i class="fas fa-edit"></i> Sửa
                                </button>

                                <button class="btn btn-sm btn-danger delete-supplier-btn" data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>">
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

<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="Admin.php?page=modules/Admin/Suppliers/Supplier.php&search=<?= $keyword ?>&number=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>

