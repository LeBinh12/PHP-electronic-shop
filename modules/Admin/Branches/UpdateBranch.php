<?php

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_Branch'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $data = [
        'name' => $name,
        'address' => $address,
        'phone' => $phone,
        'email' => $email,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $result = $branchController->update($id, $data);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Branches/Branch.php';</script>";
    exit;
}

?>


<div class="modal fade" id="editBranchModal" tabindex="-1" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="Admin.php?page=modules/Admin/Branches/Branch.php">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Sửa chi nhánh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><input name="name" id="edit-name" class="form-control" required></div>
                    <div class="mb-3"><input name="address" id="edit-address" class="form-control" required></div>
                    <div class="mb-3"><input name="phone" id="edit-phone" class="form-control"></div>
                    <div class="mb-3"><input name="email" id="edit-email" class="form-control"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="edit_Branch">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>
