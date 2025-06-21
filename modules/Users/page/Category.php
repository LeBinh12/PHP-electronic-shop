<?php
$products = [
    [
        'name' => 'Laptop Acer Nitro 5',
        'category' => 'laptop',
        'image' => 'https://product.hstatic.net/200000722513/product/legion_5_15irx10_ct1_02_5319efe70fe84554a98431db99c284f4_1024x1024.png',
        'price' => 21990000,
        'description' => 'Laptop gaming mạnh mẽ, card rời GTX 1650'
    ],
    [
        'name' => 'Laptop ASUS ROG',
        'category' => 'gaming',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 30990000,
        'description' => 'Thiết kế ngầu, hiệu năng cao cho game thủ'
    ],
    [
        'name' => 'PC GVN RGB',
        'category' => 'pc',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 17990000,
        'description' => 'PC build sẵn, LED RGB cực đẹp'
    ],
    [
        'name' => 'Laptop Dell Inspiron',
        'category' => 'laptop',
        'image' => 'https://product.hstatic.net/200000722513/product/legion_5_15irx10_ct1_02_5319efe70fe84554a98431db99c284f4_1024x1024.png',
        'price' => 16990000,
        'description' => 'Laptop học tập, văn phòng bền bỉ'
    ],
    [
        'name' => 'PC i7 12th',
        'category' => 'laptop',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 28990000,
        'description' => 'PC chơi game và làm việc đa năng'
    ],
    [
        'name' => 'Laptop HP Pavilion',
        'category' => 'laptop',
        'image' => 'https://product.hstatic.net/200000722513/product/legion_5_15irx10_ct1_02_5319efe70fe84554a98431db99c284f4_1024x1024.png',
        'price' => 19990000,
        'description' => 'Laptop mỏng nhẹ, pin trâu cho công việc'
    ],
    [
        'name' => 'Laptop Lenovo IdeaPad',
        'category' => 'laptop',
        'image' => 'https://product.hstatic.net/200000722513/product/legion_5_15irx10_ct1_02_5319efe70fe84554a98431db99c284f4_1024x1024.png',
        'price' => 15990000,
        'description' => 'Laptop giá rẻ, hiệu năng ổn định'
    ],
    [
        'name' => 'Laptop MSI GF63',
        'category' => 'laptop',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 24990000,
        'description' => 'Laptop gaming mỏng nhẹ, card rời GTX 1650'
    ],
    [
        'name' => 'PC Gaming Ryzen 5',
        'category' => 'laptop',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 21990000,
        'description' => 'PC gaming với hiệu năng vượt trội'
    ],
];

$selectedCategory = $_GET['category'] ?? null;
$filteredProducts = array_filter($products, fn($p) => $p['category'] === $selectedCategory);
?>

<div class="container mt-4">
    <h4 class="mb-3">Sản phẩm thuộc danh mục:
        <span class="text-danger"><?= htmlspecialchars(ucfirst($selectedCategory)) ?></span>
    </h4>

    <div class="row g-3">
        <?php if (!empty($filteredProducts)): ?>
            <?php foreach ($filteredProducts as $product): ?>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 200px; object-fit: contain;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                        </div>
                        <div class="card-footer bg-white border-top-0 text-center">
                            <p class="text-danger fw-bold mb-2"><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                            <!-- <a href="#" class="text-primary text-decoration-none">Xem chi tiết >></a> -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Không có sản phẩm nào trong danh mục này.</p>
        <?php endif; ?>
    </div>
</div>