<?php

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    $result = $branchController->delete($id);
    if ($result['success']) {
        echo "<script>
            alert('Xóa chi nhánh thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Branches/Branch.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('{$result['message']}');
            window.location.href = 'Admin.php?page=modules/Admin/Branches/Branch.php';
        </script>";
        exit;
    }
}
