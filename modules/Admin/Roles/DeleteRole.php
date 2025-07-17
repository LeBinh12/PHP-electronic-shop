<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_role_id'])) {
    $id = $_POST['delete_role_id'];
    $result = $roleController->delete($id);
    if ($result["success"]) {
        echo "<script>
            alert('Xóa quyền thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Roles/Role.php';
        </script>";
        exit;
    }
}
