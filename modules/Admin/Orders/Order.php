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

<h1 class="h3 mb-4">Danh sách đơn hàng</h1>

<!-- Form tìm kiếm -->
<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <form class="search-form" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Orders/Order.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm đơn hàng...">
        </form>
    </div>


    <?php require_once 'modules/Admin/Orders/ChangeStatusOrder.php'; ?>
    <?php require_once 'modules/Admin/Orders/DeleteOrder.php'; ?>
    <?php require_once 'modules/Admin/Orders/UpdateOrder.php'; ?>
    <!-- Bảng danh sách -->
    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width: 70px">ID</th>
                        <th style="width: 250px">Người đặt</th>
                        <th>Ngày đặt</th>
                        <th style="width: 250px">Trạng thái</th>
                        <th style="width: 250px">Tổng tiền</th>
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
                                <td><?= $item['id'] ?></td>
                                <td><?= htmlspecialchars($item['FullName']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($item['create_at'])) ?></td>
                                <td><?= htmlspecialchars($item['status_name']) ?></td>
                                <td><?= number_format((float)$item['total_amount'], 0) ?> đ</td>
                                <td>
                                    <a href="Admin.php?page=modules/Admin/Orders/ViewOrder.php&id=<?= $item['id'] ?>"
                                        class="btn btn-sm btn-info text-white btn-sm-fixed">
                                        <i class="fas fa-eye me-1"></i> Xem
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-warning text-white btn-update-order btn-sm-fixed"
                                        data-id="<?= $item['id'] ?>"
                                        data-status="<?= $item['status_id'] ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateOrderModal">
                                        <i class="fas fa-edit me-1"></i> Sửa
                                    </button>

                                    <button type="button"
                                        class="btn btn-sm btn-secondary change-status-btn btn-sm-fixed" data-id="<?= $item['id'] ?>" data-bs-toggle="modal" data-bs-target="#changeStatusModal">
                                        <i class="fas fa-sync-alt me-1"></i> Chuyển
                                    </button>
                                    <button type="button"
                                        class="btn btn-sm btn-danger delete-order-btn btn-sm-fixed" data-id="<?= $item['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteOrderModal">
                                        <i class="fas fa-trash-alt me-1"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

        <!-- PHÂN TRANG -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="Admin.php?page=modules/Admin/Orders/Order.php&search=<?= urlencode($keyword) ?>&page=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>




        </table>
    </div>

    <!-- PHÂN TRANG -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Page navigation">
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