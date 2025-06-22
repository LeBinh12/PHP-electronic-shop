<?php
$id_category = null;
$id_supplier = null;
$keyword = null;
if (isset($_GET['category']) && $_GET['category'] !== '') {
    $id_category = $_GET['category'];
}

if (isset($_GET['supplier']) && $_GET['supplier'] !== '') {
    $id_supplier = $_GET['supplier'];
}

if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
}


$products = $product->getFilterProducts($id_category, $id_supplier, $keyword);

// var_dump($products);
?>

<div class="container mt-4">

    <div class="row g-3">
        <?php foreach ($products as $item): ?>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>" style="height: 200px; object-fit: contain;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
                    </div>
                    <div class="card-footer bg-white border-top-0 text-center">
                        <p class="text-danger fw-bold mb-2"><?= number_format($item['price'], 0, ',', '.') ?>₫</p>
                        <!-- <a href="#" class="text-primary text-decoration-none">Xem chi tiết >></a> -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>