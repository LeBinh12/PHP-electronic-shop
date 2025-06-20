<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $discount = $_POST['discount'] ?? 0;
        $description = $_POST['description'] ?? '';
        $category_id = $_POST['category_id'] ?? 1;
        $supplier_id = $_POST['supplier_id'] ?? 1;
        echo "<h1>$name</h1>";
        // Handle image (either upload or URL)
        $imageUrl = $_POST['image_url'] ?? ''; // URL from form
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/'; // Đường dẫn tới uploads trong thư mục v1
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $fileName;

            // Debug information
            error_log("Uploading to: $targetFile");
            error_log("Temp file: " . $_FILES['image']['tmp_name']);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imageUrl = 'uploads/' . $fileName; // Đường dẫn tương đối nếu upload
                error_log("Upload successful, image_url: $imageUrl");
            } else {
                error_log("Upload failed for: " . $_FILES['image']['name'] . " - Error: " . $_FILES['image']['error']);
            }
        }

        $data = [
            'name' => $name,
            'price' => $price,
            'discount' => $discount,
            'description' => $description,
            'category_id' => $category_id,
            'supplier_id' => $supplier_id,
            'isDeleted' => false,
            'image_url' => $imageUrl
        ];
        $result = $product->add($data);
        if ($result['success']) {
            echo "<h1>{$result['message']}</h1>";
            header("Location: Admin.php");
        } else {
            echo "<h1>{$result['message']}</h1>";
        }
    } catch (Exception) {
        echo "Lỗi $Exception";
    }
}
?>

<h2>Thêm Sản Phẩm</h2>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Tên</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Giá</label>
        <input type="number" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Giảm giá (%)</label>
        <input type="number" name="discount" class="form-control" step="0.01" min="0" max="100">
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">URL Ảnh (hoặc để trống nếu upload)</label>
        <input type="url" name="image_url" class="form-control" placeholder="https://example.com/image.jpg">
    </div>
    <div class="mb-3">
        <label class="form-label">Ảnh (upload)</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <div class="mb-3">
        <label class="form-label">Loại</label>
        <select name="category_id" class="form-select">
            <?php
            $categories = $category->getAll();
            foreach ($categories as $cat) {
                echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Nhà cung cấp</label>
        <select name="supplier_id" class="form-select">
            <?php
            $suppliers = $supplier->getAll();
            foreach ($suppliers as $sup) {
                echo "<option value='{$sup['id']}'>{$sup['name']}</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Thêm</button>
</form>