<?php

$id_category = null;
$id_supplier = null;
$arrayBrand = [];
$arrayPrice = [];
$keyword = null;
if (isset($_GET['category']) && $_GET['category'] !== '') {
    $id_category = $_GET['category'];
}

if (isset($_GET['supplier']) && $_GET['supplier'] !== '') {
    $id_supplier = $_GET['supplier'];
}

if (isset($_GET['brand']) && $_GET['brand'] !== '') {
    $arrayBrand = (array) $_GET['brand'];
    var_dump($arrayBrand);
}
if (isset($_GET['price']) && $_GET['price'] !== '') {
    $arrayPrice = (array) $_GET['price'];
    var_dump($arrayPrice);
}

if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
}

$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalProducts = $product->countProducts($id_category, $id_supplier, $keyword);
$totalPages = ceil($totalProducts / $limit);

$products = $product->getFilterProducts($id_category, $id_supplier, $keyword, $limit, $offset);

// var_dump($products);
?>

<div class="container mt-3">

    <div class="row g-3">
        <?php foreach ($products as $item) { ?>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>" style="height: 200px; object-fit: contain;">
                    <div class="card-body">
                        <h5 class="card-title"><a class="text-decoration-none" href="index.php?subpage=modules/Users/page/Detail.php&id=<?= htmlspecialchars($item['id']) ?>"><?= htmlspecialchars($item['name']) ?></a></h5>
                        <p class="card-text"><?= $item['content'] ?></p>
                    </div>
                    <div class="card-footer bg-white border-top-0 text-center">
                        <p class="text-danger fw-bold mb-2 fs-5"><?= number_format($item['price'], 0, ',', '.') ?>₫</p>
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
                <a class="page-link" href="index.php?category=<?= $id_category ?>&supplier=<?= $id_supplier ?>&search=<?= $keyword ?>&number=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>