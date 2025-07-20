<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    $result = $menuController->delete($id);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Menus/Menu.php';</script>";
    exit;
}
