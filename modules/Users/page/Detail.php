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
?>

<style>
    .store-box {
        width: 100%;
        background-color: #fffbe6;
        border: 1px solid #ffe58f;
        padding: 16px;
        border-radius: 8px;
        margin-top: 16px;
    }

    .store-box h6 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ffe58f;
    }


    .store-box ul {
        padding-left: 20px;
        margin-bottom: 0;
    }

    .store-box li {
        margin-bottom: 4px;
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

    <div class="mt-5 product-description">
        <h4>Mô tả sản phẩm</h4>
        <div id="descriptionContent" class="product-description-content">
            <?= $productById['description'] ?>
        </div>
        <div class="show-more-wrapper">
            <span id="toggleDescription" class="show-more-btn" style="display: none;">Xem thêm</span>
        </div>
    </div>

    <!-- Sp tương tự -->
    <div class="mt-5">
        <h4>Sản phẩm tương tự</h4>
        <div class="row row-cols-1 row-cols-md-5 g-4">
            <?php
            $count = 0;
            foreach ($productByCategoryId as $item) {
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
                            <p class="card-price">Giá: <?= $item['price'] ?>đ</p>
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
        <div class="modal-content bg-dark border-0 position-relative">
            <!-- <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button> -->
            <div class="modal-body text-center position-relative p-0">
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

    // Kiểm tra xem nội dung có bị tràn hay không
    window.addEventListener('load', () => {
        if (description.scrollHeight > description.clientHeight + 5) {
            toggleBtn.style.display = 'inline-block';
        }
    });

    toggleBtn.addEventListener('click', function() {
        description.classList.toggle('expanded');
        if (description.classList.contains('expanded')) {
            toggleBtn.textContent = 'Thu gọn';
        } else {
            toggleBtn.textContent = 'Xem thêm';
        }
    });
</script>