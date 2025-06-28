<?php
$supplierGetAll = $supplier->getAll();
?>

<div class="container py-5">
    <h2 class="text-center mb-4 fw-bold text-uppercase">Đối tác cung cấp</h2>
    <div class="row g-4">
        <?php foreach ($supplierGetAll as $sp) { ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="index.php?supplier=<?= $sp['id'] ?>" class="text-decoration-none">
                    <div class="supplier-card">
                        <div class="supplier-image-wrapper">
                            <img src="<?= htmlspecialchars($sp['image_url']) ?>"
                                class="supplier-img"
                                alt="<?= htmlspecialchars($sp['name']) ?>">
                        </div>
                        <h6 class="supplier-name">
                            <?= htmlspecialchars($sp['name']) ?>
                        </h6>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</div>