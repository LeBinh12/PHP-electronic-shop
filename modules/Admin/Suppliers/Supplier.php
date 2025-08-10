<?php
// $listSupplier = $supplier->getAll();


$keyword = $_GET['search'] ?? '';



$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;



$totalSuppliers = $supplier->countSuppliersToDB($keyword);
$totalPages = ceil($totalSuppliers / $limit);
$listSuppliers = $supplier->getFilterSuppliersToDB($limit, $offset, $keyword);



?>
<?php require_once 'modules/Admin/Suppliers/AddSupplier.php'; ?>
<?php require_once 'modules/Admin/Suppliers/UpdateSupplier.php'; ?>
<?php require_once 'modules/Admin/Suppliers/DeleteSupplier.php'; ?>

<!-- Tìm kiếm -->
<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <?php
        if (hasPermission('modules/Admin/Suppliers/AddSupplier.php')) {
        ?>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                <i class="bi bi-plus-circle me-2"></i> Thêm đối tác mới
            </button>
        <?php
        }
        ?>
        <form class="search-form" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Suppliers/Supplier.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm loại đối tác cung cấp...">
        </form>
    </div>


    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px">ID</th>
                        <th style="width: 120px">Tên</th>
                        <th style="width: 200px">Người liên hệ</th>
                        <th style="width: 100px">Điện thoại</th>
                        <th style="width: 150px">Email</th>
                        <th style="width: 150px">Ảnh</th>
                        <th style="width: 250px">Địa chỉ</th>
                        <th style="width: 160px; text-align:center">Chức năng</th>
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
                            <td><?= htmlspecialchars($item["Address"] ?? '') ?></td>


                            <td>
                                <div class="action-buttons">
                                    <?php
                                    if (hasPermission('modules/Admin/Suppliers/UpdateSupplier.php')) {
                                    ?>
                                        <button class="btn btn-sm btn-primary text-white"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editSupplierModal"
                                            data-id="<?= $item['id'] ?>"
                                            data-name="<?= htmlspecialchars($item['name']) ?>"
                                            data-contact="<?= htmlspecialchars($item['contact_person'] ?? '') ?>"
                                            data-phone="<?= htmlspecialchars($item['Phone'] ?? '') ?>"
                                            data-email="<?= htmlspecialchars($item['Email'] ?? '') ?>"
                                            data-address="<?= htmlspecialchars($item['Address'] ?? '') ?>"
                                            data-image="<?= htmlspecialchars($item['image_url'] ?? '') ?>">
                                            <i class="fas fa-edit me-1"></i> Sửa
                                        </button>
                                    <?php
                                    }
                                    if (hasPermission('modules/Admin/Suppliers/DeleteSupplier.php')) {
                                    ?>
                                        <button class="btn btn-sm btn-danger delete-supplier-btn" data-id="<?= $item['id'] ?>"
                                            data-name="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>">
                                            <i class="fas fa-trash-alt me-1"></i> Xóa
                                        </button>
                                    <?php
                                    }
                                    ?>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#addSupplierModal form, #editSupplierModal form, #deleteSupplierModal form')
            .forEach(form => {
                form.addEventListener('submit', () => {
                    Loading(true);
                });
            });

        document.querySelectorAll('.delete-supplier-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const deleteForm = document.querySelector('#deleteSupplierModal form');
                if (deleteForm) {
                    deleteForm.addEventListener('submit', () => Loading(true));
                }
            });
        });
    });
</script>