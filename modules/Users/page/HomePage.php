<?php
// Sản phẩm nổi bật
$featuredProducts = $product->getLatestProducts();

// Sản phẩm giảm giá
$saleProducts = $product->getLatestSaleProducts();


$getCategory = $category->getAll();

?>


<!-- Danh mục tiêu biểu -->
<div class="container ecom-section">
    <h3 class="ecom-title">Danh mục nổi bật</h3>
    <div class="ecom-category-list">
        <?php

        foreach ($getCategory as $item) {
        ?>
            <a href="index.php?subpage=modules/Users/Layout/Main.php&category=<?= $item['id'] ?>" class="ecom-category-card text-decoration-none">
                <i class="fa-solid fa-laptop"></i>
                <div class="ecom-category-title"><?= $item['name'] ?></div>
            </a>
        <?php
        }

        ?>
    </div>
</div>



<!-- Sản phẩm nổi bật -->
<div class="container ecom-section ecom-carousel">
    <h3 class="ecom-title">Sản phẩm nổi bật</h3>
    <div id="featuredCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            <?php foreach (array_chunk($featuredProducts, 6) as $i => $group) { ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <div class="row g-3 product-list">
                        <?php foreach ($group as $item) { ?>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                <div class="ecom-product-card h-100 shadow-sm">
                                    <span class="ecom-product-badge new">Mới</span>
                                    <img src="<?= htmlspecialchars($item['image_url']) ?>" class="ecom-product-img" alt="<?= htmlspecialchars($item['name']) ?>">
                                    <h6 class="ecom-product-title">
                                        <a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= $item['id'] ?>">
                                            <?= htmlspecialchars($item['name']) ?>
                                        </a>
                                    </h6>
                                    <div class="ecom-price mb-2"><?= number_format($item['price'], 0, ',', '.') ?>₫</div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<div class="container ecom-section">
    <div class="row g-3">

        <!-- Carousel Banner 1 -->
        <div class="col-md-6">
            <div id="bannerCarousel1" class="carousel slide ecom-small-banner-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://file.hstatic.net/200000722513/file/bot_promotion_banner_small_2_2ad55c2345c64fbfb87dab4957b33914.png" class="img-fluid w-100" alt="Banner 1" style="height: 200px; object-fit: contain;">
                    </div>
                    <div class="carousel-item">
                        <img src="https://file.hstatic.net/200000722513/file/banner_790x250_tai_nghe_6f6dcb17d3a54fcc88b3de96762d2d41.jpg" class="img-fluid w-100" alt="Banner 2" style="height: 200px; object-fit: contain;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel1" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel1" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

        <!-- Carousel Banner 2 -->
        <div class="col-md-6">
            <div id="bannerCarousel2" class="carousel slide ecom-small-banner-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_build_pc_top_promotion_banner_2.png" class="img-fluid w-100" alt="Banner 3" style="height: 200px; object-fit: contain;">
                    </div>
                    <div class="carousel-item">
                        <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_ghe_top_promotion_banner_1.png" class="img-fluid w-100" alt="Banner 4" style="height: 200px; object-fit: contain;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel2" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel2" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Sản phẩm giảm giá -->
<div class="container ecom-section ecom-carousel">
    <h3 class="ecom-title">Sản phẩm giảm giá</h3>
    <div id="saleCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            <?php foreach (array_chunk($saleProducts, 6) as $i => $group) { ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <div class="row g-3">
                        <?php foreach ($group as $item) {
                            $originalPrice = $item['price'];
                            $discount = $item['discount'];
                            $finalPrice = $originalPrice * (1 - $discount / 100);
                        ?>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                <div class="ecom-product-card">
                                    <span class="ecom-product-badge sale">Giảm <?= $discount ?>%</span>
                                    <img src="<?= htmlspecialchars($item['image_url']) ?>" class="ecom-product-img" alt="<?= htmlspecialchars($item['name']) ?>">
                                    <h6 class="ecom-product-title">
                                        <a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= $item['id'] ?>">
                                            <?= htmlspecialchars($item['name']) ?>
                                        </a>
                                    </h6>
                                    <div class="ecom-price mb-1">
                                        <span class="text-muted text-decoration-line-through me-2"><?= number_format($originalPrice, 0, ',', '.') ?>₫</span>
                                        <span class="text-danger fw-bold"><?= number_format($finalPrice, 0, ',', '.') ?>₫</span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#saleCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#saleCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>