<?php

if ($_SERVER['REQUEST_METHOD'] && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $data = [
        'email' => $email,
        'password' => $password
    ];
    $res = $employeeController->login($data);
    if ($res['success']) {
        $_SESSION['jwt_employee'] = $res['token'];
        $employeeData = $employeeController->getCurrentEmployee();
        $_SESSION['menu'] = $employeeController->getMenuByUserId($employeeData->id);
    } else {
        echo "<script>
                alert('Sai tài khoản hoặc mặt khẩu');
                window.location.href = 'Auth/Login.php';
            </script>";
        exit;
    }
}



function hasPermission($url)
{
    foreach ($_SESSION['menu'] as $menu) {
        if ($menu['menu_url'] === $url) {
            return true;
        }
    }
    return false;
}
