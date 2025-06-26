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
    <div class="row">
        <div class="col-md-6">
            <img
                src="<?= $productById['image_url'] ?>"
                class="img-fluid border rounded mb-3"
                id="mainImage"
                alt="MacBook Air M3">
            <div class="d-flex gap-2">
                <?php
                foreach ($imageByProductId as $item) {
                ?>
                    <img src="<?= $item['image_url'] ?>"
                        class="thumb-img border"
                        onclick="document.getElementById('mainImage').src=this.src;">

                <?php
                }
                ?>
            </div>
        </div>

        <div class="col-md-6">
            <h2><?= $productById['name'] ?></h2>
            <?= $productById['content'] ?>
            <h4 class="text-danger">Giá: <?= $productById['price'] ?></h4>

            <form class="d-flex align-items-center my-3" style="gap: 10px;">
                <input type="number" value="1" min="1" class="form-control w-25">
                <button class="btn btn-primary">Thêm giỏ hàng</button>
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

    <!-- Bài viết -->
    <!-- <div class="mt-5">
        <h4>Bài viết liên quan</h4>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100">
                    <img src="https://cdn2.fptshop.com.vn/unsafe/1920x0/filters:format(webp):quality(75)/laptop_mau_den_9381eecd93.jpg" class="card-img-top" alt="Bài viết 1">
                    <div class="card-body">
                        <h5 class="card-title">So sánh Macbook Air M2 và M3</h5>
                        <p class="card-text text-justify-custom">Khám phá sự khác biệt giữa hai dòng Macbook nổi bật, từ hiệu năng đến thời lượng pin và thiết kế mỏng nhẹ.</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="#" class="text-primary text-decoration-none">Đọc tiếp</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="https://cdn2.fptshop.com.vn/unsafe/1920x0/filters:format(webp):quality(75)/laptop_cho_sinh_vien_ngoai_ngu_duoi_15_trieu_2025_00_330438b01a.jpg" class="card-img-top" alt="Bài viết 3">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Laptop văn phòng năm 2024</h5>
                        <p class="card-text text-justify-custom">Danh sách các dòng laptop mỏng nhẹ, pin trâu, hiệu năng ổn định được đánh giá cao nhất dành cho dân văn phòng.</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="#" class="text-primary text-decoration-none">Đọc tiếp</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="https://cdn2.fptshop.com.vn/unsafe/1920x0/filters:format(webp):quality(75)/laptop_cho_sinh_vien_ngoai_ngu_duoi_15_trieu_2025_00_330438b01a.jpg" class="card-img-top" alt="Bài viết 3">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Laptop văn phòng năm 2024</h5>
                        <p class="card-text text-justify-custom">Danh sách các dòng laptop mỏng nhẹ, pin trâu, hiệu năng ổn định được đánh giá cao nhất dành cho dân văn phòng.</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="#" class="text-primary text-decoration-none">Đọc tiếp</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>