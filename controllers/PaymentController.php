<?php

<<<<<<< HEAD
require_once './models/Payment.php';
=======
>>>>>>> origin/dev/vinh
require_once './core/RedisCache.php';
require_once './models/Payment.php';

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
