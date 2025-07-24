<?php

require_once './models/Admin.php';

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new Admin();
    }

    public function Login($email, $password)
    {
        return $this->adminModel->ExistsLogin($email, $password);
    }
}
