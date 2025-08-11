<?php


$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalProducts = $product->countProducts($id_category, $id_supplier, $keyword, $priceRanges);
$totalPages = ceil($totalProducts / $limit);

$products = $product->getFilterProducts($id_category, $id_supplier, $keyword, $limit, $offset, $priceRanges);

// var_dump($products);
?>

<div class="container mt-3 product-list">
    <div class="row g-3">
        <?php foreach ($products as $item) {
            $originalPrice = $item['price'];
            $discount = $item['discount'];
            $finalPrice = $originalPrice * (1 - $discount / 100);
        ?>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="product-card h-100 shadow-sm">
                    <a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= $item['id'] ?>">
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" class="product-img" alt="<?= htmlspecialchars($item['name']) ?>" style="height: 200px; object-fit: contain;">
                    </a>
                    <div class="product-body text-center">
                        <h5 class="product-title fs-6"><a class="text-decoration-none" href="index.php?subpage=modules/Users/page/Detail.php&id=<?= htmlspecialchars($item['id']) ?>"><?= htmlspecialchars($item['name']) ?></a></h5>
                    </div>
                    <div class="product-footer">
                        <?php
                        if ($discount <= 0) {
                        ?>
                            <p class="product-price mb-2">Giá: <?= number_format($item['price'], 0, ',', '.') ?>₫</p>
                        <?php
                        } else {
                        ?>
                            <span class="text-muted text-decoration-line-through"><?= number_format($originalPrice, 0, ',', '.') ?>₫</span>
                            <br>
                            <span class="text-danger fw-bold"><?= number_format($finalPrice, 0, ',', '.') ?>₫</span>
                        <?php
                        }
                        ?>
                        <!-- <a href="#" class="text-primary text-decoration-none">Xem chi tiết >></a> -->
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="index.php?subpage=modules/Users/Layout/Main.php&category=<?= $id_category ?>&supplier=<?= $id_supplier ?>&search=<?= $keyword ?>&number=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>