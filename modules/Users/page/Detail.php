<?php

$id_product = $_GET['id'] ?? '';

if ($id_product == '') {
    echo "<h1>Yêu cầu mã</h1>";
    exit;
}

$productById = $product->getById($id_product);
$productByCategoryId = $product->getFilterProducts($productById['category_id'], null, null);

$imageByProductId = $imageController->getImageById($id_product);


?>


<div class="container py-5">
    <!-- Sản phẩm -->
    <div class="row align-items-start">
        <div class="col-lg-5 col-md-6 col-12 product-image-col">
            <img src="<?= $productById['image_url'] ?>" class="img-fluid border rounded mb-3" id="mainImage" alt="Ảnh sản phẩm" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal">

            <div class="d-flex gap-2 flex-wrap">
                <?php foreach ($imageByProductId as $item) { ?>
                    <img src="<?= $item['image_url'] ?>" class="thumb-img border" onclick="swapImage(this);">
                <?php } ?>
            </div>
        </div>


        <div class="col-lg-7 col-md-6 col-12">
            <h2><?= $productById['name'] ?></h2>
            <?= $productById['content'] ?>
            <h4 class="text-danger">Giá: <?= $productById['price'] ?>đ</h4>

            <form class="product-form mt-4" method="post" action="index.php?subpage=modules/Users/page/Cart.php">
                <input type="hidden" name="id" value="<?= $productById['id'] ?>">
                <input type="hidden" name="name" value="<?= $productById['name'] ?>">
                <input type="hidden" name="price" value="<?= $productById['price'] ?>">
                <input type="hidden" name="image" value="<?= $productById['image_url'] ?>">
                <input type="number" name="quantity" value="1" min="1" class="form-control w-25">
                <button class="btn btn-primary" name="addCart">Thêm giỏ hàng</button>
            </form>
        </div>
    </div>


    <div class="mt-5">
        <h4>Mô tả sản phẩm</h4>
        <p><?= $productById['description'] ?></p>
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
                        <div class="card-body">
                            <h5 class="card-title"><?= $item['name'] ?></h5>
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