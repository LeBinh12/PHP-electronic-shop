<?php
$keyword = $_GET["search"] ?? "";
$page    = max(1, ($_GET['pageNumber'] ?? 1));
$limit   = 6;
$offset  = ($page - 1) * $limit;

// Lấy dữ liệu từ controller
$listOrders = $orderController->getAllOrdersPagination($keyword, $limit, $offset);
$totalRows  = $orderController->getAllCountOrder($keyword);
$totalPages = max(1, ceil($totalRows / $limit));
?>



<!-- Form tìm kiếm -->
<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Orders/Order.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm mã đơn hàng...">
        </form>
    </div>



    <!-- Bảng danh sách -->
    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width: 70px">ID</th>
                        <th style="width: 250px">Người đặt</th>
                        <th>Ngày đặt</th>
                        <th style="width: 200px">Trạng thái</th>
                        <th style="width: 210px">Tổng tiền</th>
                        <th style="width: 100px">Nhân viên phụ trách</th>
                        <th style="width: 350px">Chức năng</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (empty($listOrders)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Không tìm thấy đơn hàng nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listOrders as $item): ?>
                            <tr>
                                <td><?= $item['code'] ?></td>
                                <td><?= htmlspecialchars($item['FullName']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($item['create_at'])) ?></td>
                                <td><?= htmlspecialchars($item['status_name']) ?></td>
                                <td><?= number_format((float)$item['total_amount'], decimals: 0) ?> đ</td>
                                <td>
                                    <?= $item['employee_id'] ? "Đã có người nhận" : 'không có nhân viên phụ trách' ?>
                                </td>
                                <td>
                                    <a href="Admin.php?page=modules/Admin/Orders/Order.php&id=<?= $item['order_id'] ?>"
                                        class="btn btn-sm btn-info text-white btn-sm-fixed">
                                        <i class="fas fa-eye me-1"></i> Xem
                                    </a>
                                    <?php
                                    if (hasPermission('modules/Admin/Orders/UpdateOrder.php')) {

                                    ?>
                                        <a href="Admin.php?page=modules/Admin/Orders/Order.php&orderid=<?= $item['order_id'] ?>"
                                            class="btn btn-sm btn-warning text-white btn-sm-fixed">
                                            <i class="fas fa-edit me-1"></i> Sửa
                                        </a>

                                        <?php
                                    }
                                    if (hasPermission('modules/Admin/Orders/ChangeStatusOrder.php')) {

                                        if ($item['status_id'] < 4) {
                                        ?>
                                            <button type="button"
                                                style="padding:4px; font-size: 16px;"
                                                class="btn btn-sm btn-primary change-status-btn btn-sm-fixed" data-id="<?= $item['order_id'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#changeStatusModal">
                                                <i class="fas fa-sync-alt me-1"></i> Chuyển
                                            </button>
                                        <?php
                                        } else {
                                        ?>
                                            <button
                                                style="padding:4px; font-size: 16px;"
                                                class="btn btn-sm btn-primary change-status-btn btn-sm-fixed">
                                                <i class=" fas fa-sync-alt me-1"></i> Chuyển
                                            </button>
                                        <?php
                                        }
                                    }
                                    if (hasPermission('modules/Admin/Inventory/DeleteOrder.php')) {

                                        ?>

                                        <button type="button"
                                            class="btn btn-sm btn-danger delete-order-btn btn-sm-fixed" data-id="<?= $item['order_id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteOrderModal">
                                            <i class="fas fa-trash-alt me-1"></i> Xóa
                                        </button>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
        </table>
    </div>

    <!-- PHÂN TRANG -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="Admin.php?page=modules/Admin/Orders/Order.php&search=<?= urlencode($keyword) ?>&pageNumber=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>


    <?php
    require_once 'modules/Admin/Orders/ChangeStatusOrder.php';
    require_once 'modules/Admin/Orders/DeleteOrder.php';
    require_once 'modules/Admin/Orders/UpdateOrder.php';
    require_once 'modules/Admin/Orders/ViewOrder.php';
    ?>