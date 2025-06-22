<?php
session_start();
// Giả sử đây là dữ liệu mẫu từ session hoặc database
$cart = $_SESSION['cart'] ?? [
    [
        'id' => 1,
        'name' => 'Laptop Gaming Acer Nitro 5',
        'price' => 25000000,
        'image' => 'images/laptop1.jpg',
        'quantity' => 1,
    ],
    [
        'id' => 2,
        'name' => 'Tai nghe HyperX Cloud II',
        'price' => 1990000,
        'image' => 'images/headphone.jpg',
        'quantity' => 2,
    ],
];
?>

<div class="container py-5">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>
    <form method="post" action="cart_action.php">
        <table class="table table-bordered align-middle bg-white">
            <thead class="table-danger">
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>STT</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $index => $item): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selected[]" value="<?= $item['id'] ?>">
                        </td>
                        <td><?= $index + 1 ?></td>
                        <td><img src="<?= $item['image'] ?>" class="cart-img"></td>
                        <td><?= $item['name'] ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="updateQuantity(<?= $item['id'] ?>, -1)">-</button>
                                <input type="text" name="quantities[<?= $item['id'] ?>]" class="form-control quantity-input" value="<?= $item['quantity'] ?>" readonly>
                                <button type="button" class="btn btn-outline-secondary btn-sm ms-1" onclick="updateQuantity(<?= $item['id'] ?>, 1)">+</button>
                            </div>
                        </td>
                        <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <button type="submit" name="action" value="delete" class="btn btn-danger">
                <i class="bi bi-trash"></i> Xoá đã chọn
            </button>
            <button type="submit" name="action" value="checkout" class="btn btn-success">
                <i class="bi bi-bag-check"></i> Mua hàng
            </button>
        </div>
    </form>
</div>

<script>
    // Chọn tất cả checkbox
    document.getElementById('checkAll').addEventListener('change', function() {
        document.querySelectorAll('input[name="selected[]"]').forEach(cb => cb.checked = this.checked);
    });

    // Hàm xử lý tăng/giảm số lượng
    function updateQuantity(productId, change) {
        const input = document.querySelector(`input[name="quantities[${productId}]"]`);
        let value = parseInt(input.value) + change;
        if (value < 1) value = 1;
        input.value = value;
    }
</script>