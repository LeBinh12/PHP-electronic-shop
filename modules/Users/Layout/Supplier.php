<?php
$supplierGetAll = $supplier->getAll();
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Đối tác cung cấp</h2>

    <div class="row g-3 supplier-grid">
        <?php foreach ($supplierGetAll as $sp) { ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">

                <a href="index.php?supplier=<?= $sp['id'] ?>"
                    class="text-decoration-none">

                    <div class="card supplier-card h-100 text-center text-white">
                        <img src="<?= htmlspecialchars($sp['image_url']) ?>"
                            class="card-img-top img-fluid"
                            alt="<?= htmlspecialchars($sp['name']) ?>">

                        <div class="card-body p-2">
                            <h6 class="card-title mb-0 fw-semibold" style="color: black;">
                                <?= htmlspecialchars($sp['name']) ?>
                            </h6>
                        </div>
                    </div>
                </a>

            </div>
        <?php } ?>
    </div>
</div>