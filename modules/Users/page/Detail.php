<?php

$id_product = $_GET['id'] ?? '';

if ($id_product == '') {
    echo "<h1>Yêu cầu mã</h1>";
    exit;
}

$productById = $product->getById($id_product);
$productByCategoryId = $product->getFilterProducts($productById['category_id'], null, null);

$imageByProductId = $imageController->getImageById($id_product);

$inventoryProduct = $inventoryController->getProductInventory($id_product, null) ?? 0;


$reviews = $reviewController->getAllReviewUser($id_product);

?>
<style>
    .card-title-container a {
        font-weight: bold;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: auto;
        line-height: 1.2em;
        max-height: calc(1.2em * 2);
    }
</style>

<div class="container py-5">
    <!-- Sản phẩm -->
    <div class="row align-items-start" style="margin: 0 30px;">
        <div class="col-lg-6 col-md-6 col-12 product-image-col">
            <img src="<?= $productById['image_url'] ?>" class="img-fluid border rounded mb-3" id="mainImage" alt="Ảnh sản phẩm" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal">

            <div class="d-flex gap-2 flex-wrap">
                <?php foreach ($imageByProductId as $item) { ?>
                    <img src="<?= $item['image_url'] ?>" class="thumb-img border" onclick="swapImage(this);">
                <?php } ?>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
            <h2><?= $productById['name'] ?></h2>
            <?= strip_tags($productById['content']) ?>
            <?php
            $originalPrice = $productById['price'];
            $discount = $productById['discount'];
            $finalPrice = $originalPrice * (1 - $discount / 100);
            ?>

            <div class="mt-2">
                <label class="fw-medium fs-5 mb-1">Giá sản phẩm:</label>
                <?php if ($discount > 0) { ?>
                    <h4 class="text-danger">
                        <span class="fw-bold">
                            <?= number_format($finalPrice, 0, ',', '.') ?>₫
                        </span>
                        <span class="text-muted text-decoration-line-through me-2 fs-5">
                            <?= number_format($originalPrice, 0, ',', '.') ?>₫
                        </span>
                    </h4>
                <?php } else { ?>
                    <h4 class="text-danger">
                        <?= number_format($originalPrice, 0, ',', '.') ?>₫
                    </h4>
                <?php } ?>
            </div>

            <form class="product-form mt-2" method="post" action="index.php?subpage=modules/Users/page/Cart.php">
                <?php if (!empty($inventoryProduct)) { ?>
                    <button class="btn btn-primary" name="addCart">Thêm giỏ hàng</button>
                <?php } ?>
                <br>
                <input type="hidden" name="id" value="<?= $productById['id'] ?>">
                <input type="hidden" name="name" value="<?= $productById['name'] ?>">
                <input type="hidden" name="price" value="<?= $finalPrice ?>">
                <input type="hidden" name="image" value="<?= $productById['image_url'] ?>">
                <div class="store-box">
                    <h6><i class="bi bi-geo-alt-fill me-1 text-danger"></i> Sản phẩm có tại các cửa hàng</h6>
                    <?php if (!empty($inventoryProduct)) { ?>
                        <ul>
                            <?php foreach ($inventoryProduct as $inv) { ?>
                                <li>
                                    <span><?= $inv['name'] ?> - </span>
                                    <span><?= $inv['address'] ?> - </span>
                                    <span class="text-danger fw-semibold"><?= $inv['stock_quantity'] ?> sản phẩm</span>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="text-muted mb-0 text-center">Sản phẩm hiện không có ở bất kỳ cửa hàng nào.</p>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mt-5" id="productTab" role="tablist">
        <li class="nav-item" role="presentation" style="font-weight: bold; font-size: 1.2rem;">
            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-pane" type="button" role="tab">
                Mô tả sản phẩm
            </button>
        </li>
        <li class="nav-item" role="presentation" style="font-weight: bold; font-size: 1.2rem;">
            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-pane" type="button" role="tab">
                Đánh giá
            </button>
        </li>
    </ul>

    <div class="tab-content border p-3" id="productTabContent">
        <!-- Tab mô tả -->
        <div class="tab-pane fade show active" id="description-pane" role="tabpanel" aria-labelledby="description-tab">
            <div id="descriptionContent" class="product-description-content">
                <?= $productById['description'] ?>
            </div>
            <div class="show-more-wrapper">
                <span id="toggleDescription" class="show-more-btn" style="display: none; cursor:pointer; color:blue;">Xem thêm</span>
            </div>
        </div>

        <div class="tab-pane fade" id="reviews-pane" role="tabpanel" aria-labelledby="reviews-tab">
            <?php if (!empty($reviews)) { ?>
                <?php foreach ($reviews as $review) { ?>
                    <div class="review-item">
                        <!-- Avatar -->
                        <div class="review-avatar">
                            <?= strtoupper(substr($review['FullName'], 0, 1)) ?>
                        </div>

                        <!-- Nội dung -->
                        <div class="review-content">
                            <div class="review-header">
                                <span class="review-username"><?= htmlspecialchars($review['FullName']) ?></span>
                                <span class="review-date"><?= date('d/m/Y', strtotime($review['created_at'])) ?></span>
                            </div>
                            <div class="review-stars">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <i class="bi <?= $i <= $review['rating'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
                                <?php } ?>
                            </div>
                            <p class="review-text"><?= nl2br($review['comment']) ?></p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-muted text-center my-4">Chưa có đánh giá nào cho sản phẩm này.</p>
            <?php } ?>
        </div>
    </div>


    <!-- Sp tương tự -->
    <div class="mt-5">
        <h4>Sản phẩm tương tự</h4>
        <div class="row row-cols-1 row-cols-md-5 g-4">
            <?php
            $count = 0;
            foreach ($productByCategoryId as $item) {
                $originalPrice = $item['price'];
                $discount = $item['discount'];
                $finalPrice = $originalPrice * (1 - $discount / 100);
                if ($count == 4)
                    break;
            ?>
                <div class="col">
                    <div class="card related-product">
                        <img src="<?= $item['image_url'] ?>" class="card-img-top" alt="Sản phẩm 3">
                        <div class="card-body text-center">
                            <div class="card-title-container">
                                <a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= $item['id'] ?>" class="card-title text-decoration-none fs-6" style="height: 48px;"><?= $item['name'] ?></a>
                            </div>
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
                        </div>
                    </div>
                </div>
            <?php
                $count++;
            }
            ?>
        </div>
    </div>
</div>

<!-- modal hình  -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 position-relative w-100">
            <!-- <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button> -->
            <div class="modal-body text-center position-relative p-0" style="height: auto; margin: 10px;">
                <button class="btn btn-light position-absolute top-50 start-0 translate-middle-y" style="z-index:2;" onclick="prevImage()">
                    &#10094;
                </button>
                <img src="" id="modalImage" class="img-fluid rounded">
                <button class="btn btn-light position-absolute top-50 end-0 translate-middle-y" style="z-index:2;" onclick="nextImage()">
                    &#10095;
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    const description = document.getElementById('descriptionContent');
    const toggleBtn = document.getElementById('toggleDescription');

    function checkDescriptionHeight() {
        if (description.scrollHeight > description.clientHeight + 5) {
            toggleBtn.style.display = 'inline-block';
        } else {
            toggleBtn.style.display = 'none';
        }
    }

    toggleBtn.addEventListener('click', function() {
        description.classList.toggle('expanded');
        toggleBtn.textContent = description.classList.contains('expanded') ? 'Thu gọn' : 'Xem thêm';
    });

    // Khi load trang
    window.addEventListener('load', () => {
        setTimeout(checkDescriptionHeight, 200);
    });

    // Khi chuyển sang tab mô tả
    document.getElementById('description-tab').addEventListener('shown.bs.tab', () => {
        checkDescriptionHeight();
    });
</script>