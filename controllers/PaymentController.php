<?php

require_once './models/Product.php';
require_once './core/RedisCache.php';

class PaymentController
{
    private $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new Payment();
    }

    public function add($data)
    {
        return $this->paymentModel->insert($data);
    }
}
