<div class="mt-3">
  <div class="d-flex" style="min-height: 100vh;">
    <div style="width: 310px;">
      <div style="position: sticky; top: 70px; z-index: 1029;">
        <?php include 'Sidebar.php'; ?>
      </div>
    </div>

    <div class="flex-grow-1 ms-3">
      <div class="row g-3">
        <?php
        if (isset($_GET['category'])) {
          $tam = $_GET['category'];
        } else {
          $tam = '';
        }
        if ($tam == 'laptop') {
          include("page/Category.php");
        } elseif ($tam == 'cart') {
          include("page/Cart.php");
        } elseif ($tam == 'tintuc') {
          include("page/tintuc.php");
        } else {
          include("page/Home.php");
        }
        ?>
      </div>
    </div>
  </div>
</div>