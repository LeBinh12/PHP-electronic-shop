<div class="order-page-container container my-4">
    <div class="order-layout">
        <div class="order-content">
            <div class="order-header">
                <h5>Đơn hàng đã mua</h5>
                <div class="search-filter">
                    <form method="post" class="order-search-form">
                        <div class="search-box">
                            <input type="text" name="order_code" placeholder="Nhập mã đơn hàng..." value="<?= $_POST['order_code'] ?? '' ?>">
                            <button type="submit" class="btn btn-primary">Tra cứu</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- <form method="post" class="order-search-form mb-3 col-4">
                <div class="search-box">
                    <input type="text" name="order_code" placeholder="Nhập mã đơn hàng..." value="<?= $_POST['order_code'] ?? '' ?>">
                    <button type="submit" class="btn btn-primary">Tra cứu</button>
                </div>
            </form> -->
            <!-- Bộ lọc trạng thái -->
            <form method="post" class="status-filter-form mb-3">
                <input type="hidden" name="filter_status" id="filter_status" value="<?= $_POST['filter_status'] ?? 'Tất cả' ?>">
                <div class="order-status-filter">
                    <?php
                    $statuses = ["Tất cả", "Chờ xử lý", "Đã xác nhận", "Đang chuyển hàng", "Đang giao hàng", "Đã hủy", "Thành công"];
                    foreach ($statuses as $status):
                        $active = (($_POST['filter_status'] ?? 'Tất cả') === $status);
                    ?>
                        <button type="button" class="status-btn <?= $active ? 'active' : '' ?>" onclick="filterStatus('<?= $status ?>')"><?= $status ?></button>
                    <?php endforeach; ?>
                </div>
            </form>
            <?php
            $orders = [
                [
                    'code' => 'DH001',
                    'status' => 'Chờ xử lý',
                    'total' => 5000000,
                    'customer' => [
                        'name' => 'Mai Chí Vĩnh',
                        'phone' => '0987654321',
                        'address' => '123 Nguyễn Văn A, TP. Cao Lãnh, Đồng Tháp',
                        'email' => 'vinh@gamil.com'
                    ],
                    'products' => [
                        [
                            'img' => 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_ng_n_8__4_54.png',
                            'name' => 'Laptop Dell XPS 13',
                            'quantity' => 1,
                            'price' => 2500000
                        ],
                        [
                            'img' => 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_ng_n_11__5_169.png',
                            'name' => 'Chuột Logitech',
                            'quantity' => 2,
                            'price' => 1250000
                        ],
                    ]
                ],
                [
                    'code' => 'DH002',
                    'status' => 'Đã xác nhận',
                    'total' => 3000000,
                    'customer' => [
                        'name' => 'Nguyễn Văn B',
                        'phone' => '0911222333',
                        'address' => '456 ba tri bến tre',
                        'email' => 'nguyenb@gmail.com'
                    ],
                    'products' => [
                        ['img' => 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_ng_n_11__5_169.png', 'name' => 'Bàn phím cơ AKKO', 'quantity' => 1, 'price' => 3000000],
                    ]
                ],
            ];
            $filter = $_POST['filter_status'] ?? 'Tất cả';
            $searchCode = $_POST['order_code'] ?? '';
            $filteredOrders = [];

            foreach ($orders as $order) {
                if (($filter === 'Tất cả' || $order['status'] === $filter) &&
                    ($searchCode === '' || stripos($order['code'], $searchCode) !== false)
                ) {
                    $filteredOrders[] = $order;
                }
            }
            ?>
            <?php if (count($filteredOrders) > 0): ?>
                <?php foreach ($filteredOrders as $order): ?>
                    <div class="order-item">
                        <div class="order-item-header">
                            <h6>Mã đơn: <?= $order['code'] ?> | Trạng thái: <?= $order['status'] ?></h6>
                            <strong>Tổng tiền: <?= number_format($order['total'], 0, ',', '.') ?>₫</strong>
                        </div>

                        <div class="order-item-info-row">
                            <div class="shipping-info">
                                <h5>Thông tin nhận hàng:</h5>
                                <p><strong>Họ tên:</strong> <?= $order['customer']['name'] ?></p>
                                <p><strong>SĐT:</strong> <?= $order['customer']['phone'] ?></p>
                                <p><strong>Địa chỉ:</strong> <?= $order['customer']['address'] ?></p>
                                <p><strong>Email:</strong> <?= $order['customer']['email'] ?></p>
                            </div>

                            <div class="order-product-list">
                                <h5>Thông tin sản phẩm:</h5>
                                <?php foreach ($order['products'] as $product): ?>
                                    <div class="order-product">
                                        <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>">
                                        <div class="order-product-info">
                                            <h6><?= $product['name'] ?></h6>
                                            <div class="product-price"><?= number_format($product['price'], 0, ',', '.') ?>₫</div>
                                            <p>Số lượng: <?= $product['quantity'] ?></p>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            </div>
                        </div>

                        <?php if ($order['status'] === 'Chờ xử lý'): ?>
                            <form method="post" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn?')">
                                <input type="hidden" name="cancel_order" value="<?= $order['code'] ?>">
                                <button type="submit" class="cancel-btn">Hủy đơn hàng</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>


            <?php else: ?>
                <div class="empty-order">
                    <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="No order">
                    <h6>Rất tiếc, không tìm thấy đơn hàng nào phù hợp</h6>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>