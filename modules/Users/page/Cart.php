<?php
if (isset($_POST['addCart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];
    $productInventory = $inventoryController->getProductInventory($id);

    if ($id && $price) {
        if (isset($cart[$id])) {
            $checkQuantity = $cart[$id]['quantity'];
            $sumQuantity = $cart[$id]['quantity'] += $quantity;
            if ($sumQuantity < $productInventory['stock_quantity']) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id]['quantity'] = $productInventory['stock_quantity'];
            }
        } else {
            $cart[$id] = [
                'id'       => $id,
                'name'     => $name,
                'price'    => $price,
                'image'    => $image,
                'quantity' => $quantity
            ];
        }
    }
    echo '<meta http-equiv="refresh" content="0">';

    $_SESSION['cart'] = $cart;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    //Xoá đã chọn 
    if ($action === 'delete_selected' && !empty($_POST['selected'])) {
        foreach ($_POST['selected'] as $id) {
            unset($cart[$id]);
        }
    }

    //đặt hàng 
    if ($action === 'checkout' && !empty($_POST['selected'])) {

        // foreach ($_POST['selected'] as $id) {
        //     unset($cart[$id]);
        // }
        $method = $_POST['payment_method'] ?? 'cod';

        if ($method === 'cod') {
            $totalAmount;
            foreach ($_POST['selected'] as $id) {
                $priceProduct = $product->getById(id: $id);

                $quantity = $cart[$id]['quantity'];

                $totalAmount += $priceProduct['price'] * $quantity;
            }

            $note = $_POST['note'] ?? '';
            $data = [
                'total_amount' => $totalAmount,
                'status' => "đang giao",
                'user_id' => $userData->id,
                'note' => $note
            ];
            $order = $orderController->add($data);
            foreach ($_POST['selected'] as $id) {
                $priceProduct = $product->getById(id: $id);

                $quantity = $cart[$id]['quantity'];

                $dataOrderItem = [
                    'quantity' => $quantity,
                    'unit_price' => $priceProduct['price'],
                    'product_id' => $id,
                    'order_id' => $order['order_id'],
                ];

                $orderItemController->add($dataOrderItem);
                unset($cart[$id]);
            }
            $_SESSION['cart'] = $cart;
            echo "<script>
                            alert('Mua hàng thành công!');
                            window.location.href = 'index.php';
                        </script>";
            exit;
        } else {
            echo "<h1>Thanh toan onl chua xu ly</h1>";
        }
    }


    //Tăng / giảm / xoá từng sản phẩm
    if (preg_match('/^(inc|dec|remove)_(\d+)$/', $action, $m)) {
        [$all, $cmd, $id] = $m;
        if (isset($cart[$id])) {
            switch ($cmd) {
                case 'inc':
                    $productInventory = $inventoryController->getProductInventory($id);
                    if ($cart[$id]['quantity'] < $productInventory['stock_quantity']) {
                        $cart[$id]['quantity']++;
                    }
                    break;
                case 'dec':
                    if ($cart[$id]['quantity'] > 1) $cart[$id]['quantity']--;
                    break;
                case 'remove':
                    unset($cart[$id]);
                    break;
            }
        }
    }
    echo '<meta http-equiv="refresh" content="0">';
}

$_SESSION['cart'] = $cart;
// $cart = $_SESSION['cart'] ?? [
//     [
//         'id' => 1,
//         'name' => 'Acer Aspire 3 A315 58 529V i5',
//         'price' => 9990000,
//         'image' => 'https://cdn2.fptshop.com.vn/unsafe/750x0/filters:format(webp):quality(75)/msi_g24c4_e2_4_928b4e190d.png',
//         'quantity' => 1,
//     ],
//     [
//         'id' => 2,
//         'name' => 'Macbook Air M3 15 2024',
//         'price' => 31990000,
//         'image' => 'https://cdn2.fptshop.com.vn/unsafe/750x0/filters:format(webp):quality(75)/msi_g24c4_e2_4_928b4e190d.png',
//         'quantity' => 1,
//     ],
// ];
?>
<?php
$total = 0;
?>
<form method="post" action="">
    <div class="container my-4 cart-container">
        <div class="cart-layout">
            <div class="cart-left">
                <?php if (empty($cart)) { ?>
                    <div class="text-center">
                        <img src="Style/Images/emptyCart.png" alt="Giỏ hàng trống" style="max-width: 700px; width: 100%;">
                        <p class="mt-3 fw-bold fs-4">Chưa có sản phẩm nào trong giỏ hàng</p>
                        <p class="text-muted">Hãy thêm sản phẩm để bắt đầu mua sắm!</p>
                    </div>
                <?php } else { ?>
                    <!-- Nút xoá selected -->
                    <div class="cart-header d-flex justify-content-between">
                        <div>
                            <input type="checkbox" id="checkAll"> <label for="checkAll">Chọn tất cả</label>
                        </div>
                        <button type="submit"
                            name="action" value="delete_selected"
                            class="btn btn-outline-none text-danger">
                            <i class="bi bi-trash"></i> Xoá đã chọn
                        </button>
                    </div>

                    <?php
                    $total = 0;
                    foreach ($cart as $item) {
                        $price = (float) preg_replace('/[^\d.]/', '', $item['price']); // 1.200.000₫ -> 1200000

                        // 2. Ép kiểu số nguyên cho quantity
                        $qty   = (int) $item['quantity'];

                        // 3. Tính tiền dòng
                        $itemTotal = $price * $qty;
                        $total    += $itemTotal;
                    ?>
                        <div class="cart-item">
                            <input type="checkbox"
                                name="selected[]"
                                value="<?= $item['id'] ?>"
                                class="item-checkbox me-2">

                            <img src="<?= $item['image'] ?>" alt="">
                            <div class="product-info">
                                <h6><?= $item['name'] ?></h6>
                                <p><?= number_format($item['price'], 0, ',', '.') ?>₫</p>
                            </div>

                            <!-- tăng / giảm / xoá 1 sản phẩm -->
                            <div class="quantity-control">
                                <button name="action" value="dec_<?= $item['id'] ?>"
                                    class="btn btn-outline-secondary btn-sm">-</button>
                                <span class="mx-1"><?= $item['quantity'] ?></span>
                                <button name="action" value="inc_<?= $item['id'] ?>"
                                    class="btn btn-outline-secondary btn-sm">+</button>
                            </div>

                            <button name="action" value="remove_<?= $item['id'] ?>" class="btn btn-link remove-btn">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="cart-right">
                <input type="hidden" name="totalAmount" value="<?= $total ?>">
                <h5 class="text-primary">Tổng tiền: <?= number_format($total, 0, ',', '.') ?>₫</h5>
                <hr>
                <div class="mb-3">
                    <p class="fw-bold mb-2">Phương thức thanh toán:</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            name="payment_method" id="cod" value="cod" checked>
                        <label class="form-check-label" for="cod">
                            Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            name="payment_method" id="online" value="online">
                        <label class="form-check-label" for="online">
                            Thanh toán Online (VNPay, Momo…)
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <p class="fw-bold">Ghi chú đơn hàng:</p>
                    <textarea name="note" id="note" placeholder="Ghi chú thêm nếu cần..."></textarea>
                </div>
                <p class="text-danger small mb-2">
                    Lưu ý: Bạn cần phải tích vào những sản phẩm muốn thanh toán
                </p>
                <?php if ($userData === null) { ?>
                    <button type="button"
                        class="btn btn-primary w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#loginModal">
                        Đăng nhập để mua hàng
                    </button>
                <?php } else { ?>
                    <button type="submit"
                        name="action" value="checkout"
                        class="btn btn-primary w-100">
                        Mua hàng
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>
</form>



<!-- <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="checkoutForm">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="checkoutModalLabel">Thông tin mua hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Họ và tên</label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Số điện thoại</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Địa chỉ nhận hàng</label>
                        <textarea name="address" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary">Xác nhận mua</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>