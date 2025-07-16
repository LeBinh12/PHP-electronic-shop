<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    $result = $menuController->delete($id);

    if ($result['success']) {
        echo "<script>
            alert('Xóa chức năng thành công!');
            window.location.href = 'Admin.php?page=modules/Admin/Menus/Menu.php';
        </script>";
        exit;
    }
}
