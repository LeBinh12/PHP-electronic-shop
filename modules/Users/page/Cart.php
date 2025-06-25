<?php
$cart = $_SESSION['cart'] ?? [
    [
        'id' => 1,
        'name' => 'Acer Aspire 3 A315 58 529V i5',
        'price' => 9990000,
        'image' => 'https://cdn2.fptshop.com.vn/unsafe/750x0/filters:format(webp):quality(75)/msi_g24c4_e2_4_928b4e190d.png',
        'quantity' => 1,
    ],
    [
        'id' => 2,
        'name' => 'Macbook Air M3 15 2024',
        'price' => 31990000,
        'image' => 'https://cdn2.fptshop.com.vn/unsafe/750x0/filters:format(webp):quality(75)/msi_g24c4_e2_4_928b4e190d.png',
        'quantity' => 1,
    ],
];
?>

<div class="container my-4 cart-container">
    <form method="post" action="cart_action.php">
        <div class="border rounded p-3 bg-white">

            <div class="cart-header">
                <div>
                    <input type="checkbox" id="checkAll"> <label for="checkAll">Chọn tất cả</label>
                </div>
                <button type="submit" name="action" value="delete" class="btn btn-outline-none text-danger">
                    <i class="bi bi-trash"></i> Xoá đã chọn
                </button>
            </div>

            <?php
            $total = 0;
            foreach ($cart as $item):
                $itemTotal = $item['price'] * $item['quantity'];
                $total += $itemTotal;
            ?>
                <div class="cart-item">
                    <input type="checkbox" name="selected[]" value="<?= $item['id'] ?>" class="item-checkbox me-2">

                    <img src="<?= $item['image'] ?>" alt="Ảnh sản phẩm">

                    <div class="product-info">
                        <h6><?= $item['name'] ?></h6>
                        <p><?= number_format($item['price'], 0, ',', '.') ?>₫</p>
                    </div>

                    <div class="quantity-control">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(<?= $item['id'] ?>, -1)">-</button>
                        <input type="text" readonly name="quantities[<?= $item['id'] ?>]" class="form-control form-control-sm" value="<?= $item['quantity'] ?>">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(<?= $item['id'] ?>, 1)">+</button>
                    </div>

                    <button type="submit" name="remove" value="<?= $item['id'] ?>" class="btn btn-link remove-btn">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
            <?php endforeach; ?>
            <div class="cart-footer">
                <h5 class="text-primary mb-0">Tổng tiền: <?= number_format($total, 0, ',', '.') ?>₫</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal">Mua hàng</button>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
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
</div>

<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
    });

    function updateQuantity(id, change) {
        const input = document.querySelector(`input[name="quantities[${id}]"]`);
        let qty = parseInt(input.value) + change;
        if (qty < 1) qty = 1;
        input.value = qty;
    }
</script>